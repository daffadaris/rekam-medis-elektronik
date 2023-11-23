<?php

use App\Http\Controllers\AllergyIntoleranceController;
use App\Http\Controllers\ClinicalImpressionController;
use App\Http\Controllers\CompositionController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\MedicationDispenseController;
use App\Http\Controllers\MedicationRequestController;
use App\Http\Controllers\ObservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SatusehatController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\SpecimenController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// SATUSEHAT resource endpoint
// Route::middleware(['satusehat'])->group(function () {
//     Route::get('/satusehat/{resourceType}/{satusehatId}', [SatusehatResourceController::class, 'getResource']);
// });

Route::group(['middleware' => ['web']], function () {
    Route::get('/satusehat/{resourceType}/{satusehatId}', [SatusehatController::class, 'getResource']);
});


// Local DB resource endpoint
Route::get('/{res_type}', [ResourceController::class, 'index']);
Route::get('/{res_type}/{res_id}', [ResourceController::class, 'show']);

// Patient resource endpoint
Route::post('/patient', [PatientController::class, 'store']);
Route::put('/patient/{res_id}', [PatientController::class, 'update']);

// Encounter resource endpoint
Route::post('/encounter', [EncounterController::class, 'store']);
Route::put('/encounter/{res_id}', [EncounterController::class, 'update']);

// Condition resource endpoint
Route::post('/condition', [ConditionController::class, 'store']);
Route::put('/condition/{res_id}', [ConditionController::class, 'update']);

// AllergyIntolerance resource endpoint
Route::post('/allergyintolerance', [AllergyIntoleranceController::class, 'store']);
Route::put('/allergyintolerance/{res_id}', [AllergyIntoleranceController::class, 'update']);

// Observation resource endpoint
Route::post('/observation', [ObservationController::class, 'store']);
Route::put('/observation/{res_id}', [ObservationController::class, 'update']);

// Procedure resource endpoint
Route::post('/procedure', [ProcedureController::class, 'store']);
Route::put('/procedure/{res_id}', [ProcedureController::class, 'update']);

// Medication resource endpoint
Route::post('/medication', [MedicationController::class, 'store']);
Route::put('/medication/{res_id}', [MedicationController::class, 'update']);

// MedicationRequest resource endpoint
Route::post('/medicationrequest', [MedicationRequestController::class, 'store']);
Route::put('/medicationrequest/{res_id}', [MedicationRequestController::class, 'update']);

// MedicationDispense resource endpoint
Route::post('/medicationdispense', [MedicationDispenseController::class, 'store']);
Route::put('/medicationdispense/{res_id}', [MedicationDispenseController::class, 'update']);

// Composition resource endpoint
Route::post('/composition', [CompositionController::class, 'store']);
Route::put('/composition/{res_id}', [CompositionController::class, 'update']);

// ClinicalImpression resource endpoint
Route::post('/clinicalimpression', [ClinicalImpressionController::class, 'store']);
Route::put('/clinicalimpression/{res_id}', [ClinicalImpressionController::class, 'update']);

// ServiceRequest resource endpoint
Route::post('/servicerequest', [ServiceRequestController::class, 'store']);
Route::put('/servicerequest/{res_id}', [ServiceRequestController::class, 'update']);

// Specimen resource endpoint
Route::post('/specimen', [SpecimenController::class, 'store']);
Route::put('/specimen/{res_id}', [SpecimenController::class, 'update']);

// Testing endpoint
Route::get('/test-get/specimen/{satusehat_id}', [TestController::class, 'testSpecimenResource']);
Route::get('/test-get/servicerequest/{satusehat_id}', [TestController::class, 'testServiceRequestResource']);
Route::get('/test-get/clinicalimpression/{satusehat_id}', [TestController::class, 'testClinicalImpressionResource']);
Route::get('/test-get/composition/{satusehat_id}', [TestController::class, 'testCompositionResource']);
Route::get('/test-get/medicationdispense/{satusehat_id}', [TestController::class, 'testMedicationDispenseResource']);
Route::get('/test-get/medicationrequest/{satusehat_id}', [TestController::class, 'testMedicationRequestResource']);
Route::get('/test-get/medication/{satusehat_id}', [TestController::class, 'testMedicationResource']);
Route::get('/test-get/procedure/{satusehat_id}', [TestController::class, 'testProcedureResource']);
Route::get('/test-get/allergyintolerance/{satusehat_id}', [TestController::class, 'testAllergyIntoleranceResource']);
Route::get('/test-get/observation/{satusehat_id}', [TestController::class, 'testObservationResource']);
