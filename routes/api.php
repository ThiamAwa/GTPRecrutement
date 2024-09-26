<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;



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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user', [\App\Http\Controllers\AuthControllerController::class, 'getUser']);

//Route::middleware(['auth:sanctum', 'role:Manager'])->group(function () {
////    Route::get('/manager', [\App\Http\Controllers\ManagerController::class, 'index'])
//    return'bonjour';
//});
//
//Route::middleware(['auth:sanctum', 'role:Client'])->group(function () {
////    Route::get('/manager', [\App\Http\Controllers\ManagerController::class, 'index'])
//    return'bonjour';
//});
//
//
//Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
//    Route::get('/client', [\App\Http\Controllers\ClientController::class, 'index']);
//});

//Authentification

Route::post('register',[\App\Http\Controllers\AuthControllerController::class,'register']);
Route::post('login',[\App\Http\Controllers\AuthControllerController::class,'login'])->name('login');
Route::post('logout',[\App\Http\Controllers\AuthControllerController::class,'logout'])->middleware('auth');
Route::get('user', [\App\Http\Controllers\AuthControllerController::class, 'getAuthenticatedUser'])->middleware('auth:sanctum');


//Candidat

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('/candidat',\App\Http\Controllers\CandidatController::class);

}
Route::get('/candidat/filtrage', [\App\Http\Controllers\CandidatController::class, 'filtrageCandidat']);
Route::put('/candidat/{id}/status', [\App\Http\Controllers\CandidatController::class, 'updateStatus']);
Route::post('candidat/{id}/accepter', [\App\Http\Controllers\CandidatController::class, 'accepterCandidat']);

//Consultant

Route::apiResource('/consultant',\App\Http\Controllers\ConsultantController::class);
Route::get('/consultant/filtrage', [\App\Http\Controllers\ConsultantController::class, 'filterConsultant']);

//Mission

Route::apiResource('/missions',\App\Http\Controllers\MissionController::class);

Route::put('/missions/{id}/status', [\App\Http\Controllers\MissionController::class, 'updateStatus']);
Route::get('/missionsOngoing', [\App\Http\Controllers\MissionController::class, 'getOngoingMissions']);
Route::get('/missionsterminer', [\App\Http\Controllers\MissionController::class, 'gettermineMissions']);
Route::get('/missions/{id}', [\App\Http\Controllers\MissionController::class, 'getMissionDetails']);
Route::get('/missions/statistics', [\App\Http\Controllers\MissionController::class, 'getMissionStatistics']);
Route::middleware('auth:sanctum')->post('/missions/soumettreBesion', [\App\Http\Controllers\MissionController::class,'soumettreBesion']);
Route::put('/missions/{id}/assign-consultant', [\App\Http\Controllers\MissionController::class, 'assignConsultant']);


Route::get('/missions/overview', [\App\Http\Controllers\MissionController::class, 'overview']);


// Pour récupérer toutes les missions pour le client connecté
Route::get('/missions/client/{clientId}', [\App\Http\Controllers\MissionController::class, 'consulterMission']);

// Pour récupérer les détails d'une mission spécifique
Route::get('missions/showClient/{id}', [\App\Http\Controllers\MissionController::class, 'showClient']);

Route::get('/missions/status', [\App\Http\Controllers\MissionController::class, 'getMissionsSansConsultant']);
Route::get('/mission', [\App\Http\Controllers\MissionController::class, 'missionsSansConsultant']);
Route::post('/send-email-to-consultant', [\App\Http\Controllers\MissionController::class, 'sendEmailToConsultant']);

//Accepter un mission

Route::post('/missions/accept', [\App\Http\Controllers\MissionController::class, 'acceptMission']);
Route::post('/missions/reject', [\App\Http\Controllers\MissionController::class, 'rejectMission']);
Route::post('/missions/update-status', [\App\Http\Controllers\MissionController::class, 'updateMissionStatus']);
Route::get('missions/showClientMissionEncours/{clientId}/{missionId}', [\App\Http\Controllers\MissionController::class, 'showClientMissionEncours']);
Route::post('missions/valider/{missionId}', [\App\Http\Controllers\MissionController::class, 'validerMission']);
Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'soumettreFeedback']);




//Offre

Route::apiResource('/offre',\App\Http\Controllers\OffreController::class);
Route::get('/offres/filtrage', [\App\Http\Controllers\OffreController::class, 'filtrage']);
Route::post('/publier/offre', [\App\Http\Controllers\OffreController::class, 'publier']);


//client

Route::apiResource('/client',\App\Http\Controllers\ClientController::class);


//Route::group(['middleware' => 'isManager'], function () {
//    Route::get('/manager', [\App\Http\Controllers\ManagerController::class, 'index']);
//});
//
//Route::group(['middleware' => 'isClient'], function () {
//    Route::get('/client', [\App\Http\Controllers\ClientController::class, 'index']);
//});
//
//Route::group(['middleware' => 'isConsultant'], function () {
//    Route::get('/consultant', [\App\Http\Controllers\ConsultantController::class, 'index']);
//});

//Notification

// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'getUnreadNotifications']);
    Route::post('/notifications/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead']);
    Route::post('/notifications', [\App\Http\Controllers\NotificationController::class, 'store']);

});

Route::middleware('auth:sanctum')->get('user/me', [\App\Http\Controllers\AuthControllerController::class, 'me']);

