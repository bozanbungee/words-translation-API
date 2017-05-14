<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//$app->get('/', function () use ($app) {
//    return $app->version();
//});



$app->get('/', function (){
    return view('welcome');
});

//  CRUD operation Protected via Api-Token
$app->group(['prefix' => 'api/v1'], function () use ($app) {
    $app->post('store/', 'TranslateController@store');
    $app->put('update/{id}', 'TranslateController@update');
    $app->delete('destroy/{id}', 'TranslateController@destroy');

});

//  CRUD operation shows records by giving params +paginate method
$app->group(['prefix' => 'api/v1/show'], function () use ($app) {
    $app->get('id/{id}', 'TranslateController@show');
    $app->get('word/{word}', 'TranslateController@showWord');
    $app->get('paginate/{perPage}', 'TranslateController@paginate');

});

//Send csv file via multipart/form-data
$app->get('/load_csv', 'CsvController@loadCsv');


//CRUD operation for csv trough REST service
$app->group(['prefix' => 'api/v1/csv'], function () use ($app) {

    $app->post('/get_csv_from_folder', 'CsvController@getFromFolder');
    $app->post('/get_csv_from_upload', 'CsvController@getFromUpload');

});





