<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/boards',[\App\Http\Controllers\boardController::class,'getBoards']);
Route::post('/boards',[\App\Http\Controllers\boardController::class,'postBoards']);
Route::get('/board/{id}',[\App\Http\Controllers\boardController::class,'getBoard']);
Route::put('/board/{id}',[\App\Http\Controllers\boardController::class,'putBoard']);
Route::delete('/board/{id}',[\App\Http\Controllers\boardController::class,'deleteBoard']);

Route::get('/posts',[\App\Http\Controllers\postController::class,'getPosts']);
Route::post('/posts',[\App\Http\Controllers\postController::class,'postPosts']);
Route::get('/post/{id}',[\App\Http\Controllers\postController::class,'getPost']);
Route::put('/post/{id}',[\App\Http\Controllers\postController::class,'putPost']);
Route::delete('/post/{id}',[\App\Http\Controllers\postController::class,'deletePost']);

Route::get('/maintenances',[\App\Http\Controllers\maintenanceController::class,'getMaintenances']);
Route::post('/maintenances',[\App\Http\Controllers\maintenanceController::class,'postMaintenances']);
Route::get('/maintenance/{id}',[\App\Http\Controllers\maintenanceController::class,'getMaintenance']);
Route::put('/maintenance/{id}',[\App\Http\Controllers\maintenanceController::class,'putMaintenance']);
Route::delete('/maintenance/{id}',[\App\Http\Controllers\maintenanceController::class,'deleteMaintenance']);

Route::get('/maintenance_types',[\App\Http\Controllers\maintenanceController::class,'getMaintenanceTypes']);
Route::post('/maintenance_types',[\App\Http\Controllers\maintenanceController::class,'postMaintenanceTypes']);
Route::put('/maintenance_type/{id}',[\App\Http\Controllers\maintenanceController::class,'putMaintenanceType']);
Route::delete('/maintenance_type/{id}',[\App\Http\Controllers\maintenanceController::class,'deleteMaintenanceType']);

Route::get('/extinguisher_types',[\App\Http\Controllers\extinguisherController::class,'getExtinguisherTypes']);
Route::post('/extinguisher_types',[\App\Http\Controllers\extinguisherController::class,'postExtinguisherTypes']);
Route::put('/extinguisher_type/{id}',[\App\Http\Controllers\extinguisherController::class,'putExtinguisherType']);
Route::delete('/extinguisher_type/{id}',[\App\Http\Controllers\extinguisherController::class,'deleteExtinguisherType']);

Route::get('/sites',[\App\Http\Controllers\siteController::class,'getSites']);
Route::post('/sites',[\App\Http\Controllers\siteController::class,'postSites']);
Route::put('/site/{id}',[\App\Http\Controllers\siteController::class,'putSite']);
Route::delete('/site/{id}',[\App\Http\Controllers\siteController::class,'deleteSite']);

Route::post('/dev/reset',function (Request $request) {

    $control = [
        'board_post'   => [],
        'maintenance'  => [],

        'board' => [
            [ 'name' => 'Els?? napl??', ],
        ],
        'site' => [
            [ 'name' => 'Els?? telephely', ],
            [ 'name' => 'M??sodik telephely', ],
            [ 'name' => 'Harmadik telephely', ],
        ],
        'extinguisher_type' => [
            [ 'name' => 'K??sz??l??k T??pus A', ],
            [ 'name' => 'K??sz??l??k T??pus B', ],
            [ 'name' => 'K??sz??l??k T??pus C', ],
            [ 'name' => 'K??sz??l??k T??pus D', ],
            [ 'name' => 'K??sz??l??k T??pus E', ],
            [ 'name' => 'K??sz??l??k T??pus F', ],
            [ 'name' => 'K??sz??l??k T??pus G', ],
        ],
        'maintenance_type' => [
            [ 'name' => 'Karbantart??s T??pus A', ],
            [ 'name' => 'Karbantart??s T??pus B', ],
            [ 'name' => 'Karbantart??s T??pus C', ],
            [ 'name' => 'Karbantart??s T??pus D', ],
        ],
    ];

    foreach ($control as $modelClass => $defaultSet) {
        $class = '\\App\\Models\\' . $modelClass;
        foreach ( $class::all() ? : [] as $model ) {
            $model->delete();
        }

        if ($defaultSet) {
            foreach ($defaultSet as $dataSet) {
                $model = new $class;
                $model->timestamps = false;
                foreach ($dataSet as $param => $value) {
                    $model->$param = $value;
                }
                $model->save();
            }
        }

    }



});
