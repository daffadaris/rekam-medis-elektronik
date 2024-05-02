<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fhir\ConsentRequest;
use App\Http\Requests\Fhir\Search\KfaRequest;
use App\Http\Requests\FhirRequest;
use App\Models\Fhir\Resource;
use App\Models\Fhir\Resources\QuestionnaireResponse;
use App\Models\Fhir\Resources\ServiceRequest;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\MedicationCopy;

class ResourceController extends Controller
{
    public string $authUrl;
    public string $baseUrl;
    public string $consentUrl;
    public string $kfaV1Url;
    public string $kfaV2Url;
    public string $clientId;
    public string $clientSecret;
    public string $organizationId;

    public function __construct()
    {
        $this->authUrl = config('app.auth_url');
        $this->baseUrl = config('app.base_url');
        $this->consentUrl = config('app.consent_url');
        $this->kfaV1Url = config('app.kfa_v1_url');
        $this->kfaV2Url = config('app.kfa_v2_url');
        $this->clientId = config('app.client_id');
        $this->clientSecret = config('app.client_secret');
        $this->organizationId = config('app.organization_id');
    }
     public function getToken()
    {
        if (session()->has('token')) {
            if (session()->has('token_created_at')) {
                if (now()->diffInMinutes(session('token_created_at')) < 55) {
                    return session()->get('token');
                }
            }
        }
        session()->forget('token');
        session()->forget('token_created_at');

        $client = new Client();
        $url = $this->authUrl . '/accesstoken?grant_type=client_credentials';
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded',];
        $options = [
            'form_params' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ],
            'verify' => false,
        ];

        $request = new Request('POST', $url, $headers);

        $response = $client->sendAsync($request, $options)->wait();
        $contents = json_decode($response->getBody()->getContents());
        $token = $contents->access_token;

        session()->put('token', $token);
        session()->put('token_created_at', now());

        return $token;
    }

    public function index($resType)
    {
        if (!in_array($resType, config('app.resourceTypes'))) {
            return response()->json(['error' => 'Invalid resource type'], 400);
        }

        return response()->json(DB::table($resType)->get(), 200);
    }

   
    public function store($resType, HttpRequest $request) {
        $res_type = ucfirst(strtolower($resType));

        $token = $this->getToken();
        $client = new Client();

        $url = $this->baseUrl . '/' . $res_type;
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ];

        $data = $request->json()->all();
        
        $resourceType = ctype_upper($res_type[0]) ? $res_type : config('app.resource_type_map')[$res_type];

        $method = 'post';
        if (!in_array($method, config('app.available_methods')[$res_type])) {
            return response()->json([
                'error' => 'Method not allowed for this resource type.',
                'validMethods' => config('app.available_methods')[$res_type],
            ], 405);
        }
        $requestData = new Request('POST', $url, $headers, json_encode($data)); 
        
        try {
            $response = $client->sendAsync($requestData, ['verify' => false])->wait();       
            $contents = json_decode($response->getBody()->getContents(), true);
           
            $statusCode = $response->getStatusCode();
                if ($statusCode==201){

                    DB::beginTransaction();
                    $id = DB::table($resType)->insertGetId($contents);
                    DB::commit();
                    return response()->json(DB::table($resType)->find($id), 201);
                } else {
                    $errorMessage = $response->json()['error'] ?? 'Unknown error occurred';
                    
                    error_log('Failed to save data to the API:', $errorMessage);
                    DB::rollBack();
                    return response()->json(['error' => 'Failed to save data to the API'], $response->status());
                }
                return response()->json($contents, 201);
            } catch (ClientException $e) {
                return response()->json(json_decode(
                $e->getResponse()->getBody()->getContents()
                ), $e->getCode());
            }
    }
    
    public function show($resType, $id)
    {
        if (!in_array($resType, config('app.resourceTypes'))) {
            return response()->json(['error' => 'Invalid resource type'], 400);
        }

        try {
            $resource = DB::table($resType)->where('id', $id)->first();
            return response()->json($resource, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($resType, $id, Request $request)
    {
        if (!in_array($resType, config('app.resourceTypes'))) {
            return response()->json(['error' => 'Invalid resource type'], 400);
        }

        DB::beginTransaction();

        try {
            DB::table($resType)->where('id', $id)->update($request->all());
            DB::commit();
            return response()->json(DB::table($resType)->where('id', $id)->get(), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($resType, $id)
    {
        if (!in_array($resType, config('app.resourceTypes'))) {
            return response()->json(['error' => 'Invalid resource type'], 400);
        }

        DB::beginTransaction();

        try {
            DB::table($resType)->where('id', $id)->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

   
}
