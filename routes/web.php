<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('applications', 'ApplicationController')->only(['create', 'store', 'show']);
Route::resource('assessments', 'AssessmentController')->only(['create', 'store', 'show']);
// Route::post('qualifications', 'QualificationController@store');
Route::get('/api/qualifications', 'API\\QualificationController@index');

Route::group(['middleware' => ['auth']], function () {
    Route::get('competencies/{competency}/export', 'CompetencyExportController@single')->name('competencies.export');
    // Route::resource('applications', 'ApplicationController')->except(['destroy']);
    Route::resource('qualifications', 'QualificationController')->except(['index', 'destroy']);
    Route::resource('competencies', 'CompetencyController')->except(['destroy']);
    Route::resource('testitems', 'TestItemController')->except(['destroy']);
    Route::prefix('api')->namespace('API')->name('api.')->group(function () {
        Route::get('competencies/export', 'CompetencyExportController')->name('competencies.batch-export');
        Route::apiResource('competencies', 'CompetencyController')->only(['index', 'destroy']);
        Route::get('testitems/export', 'TestitemExportController')->name('testitems.batch-export');
        Route::apiResource('testitems', 'TestitemController')->only(['index', 'destroy']);
    });
    Route::get('/download', 'DownloadController')->name('download');
});

// Route::get('/assessors/register', 'Auth\\RegisterController@showRegistrationForm');
