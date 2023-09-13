<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Models\ResourceContent;

class DaftarRekamMedisController extends Controller
{
    public function index()
    {
        $daftarPasien = Resource::join('resource_content', function ($join) {
            $join->on('resource.res_id', '=', 'resource_content.res_id')
                ->whereColumn('resource.res_version', '=', 'resource_content.res_ver');
        })->join('resource_forced_id', 'resource.res_id', '=', 'resource_forced_id.res_id')
            ->where('resource.res_type', '=', 'Patient')
            ->get();

        foreach ($daftarPasien as $dataPasien) {
            $resContent = json_decode($dataPasien->res_text, true);
            $nameData = getName($dataPasien->res_text);
            $parsedName = parseName($nameData);
            // dd($parsedName);
            $rekamMedis[] = [
                'res_id' => $dataPasien->res_id,
                'nama_pasien' => $parsedName,
                'nomor_rekam_medis' => $dataPasien->forced_id,
                'res_text' => $resContent['text']['div'],
            ];
        }

        return Inertia::render('Dashboard', [
            'rekamMedis' => $rekamMedis
        ]);
    }
}
