<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/exam', function () {
    return view('exam');
});

Route::group(['prefix' => 'admin'],function()
{
	// dashboard routes
	Route::redirect('/', 'admin/dashboard');
	Route::get('/dashboard', 'Admin\DashboardController@index');
	
	// Question type routes
	Route::get('question-type/getQuestionTypes', 'Admin\QuestionTypeController@getTypes');	
	Route::post('question-type/changeStatus', 'Admin\QuestionTypeController@changeStatus');	
	Route::resource('question-type', 'Admin\QuestionTypeController');

	// Repository routes
	Route::get('repository/getRepositoryQuestions', 'Admin\RepositoryController@getQuestions');	
	Route::get('repository/getHtmlStructure/{id}', 'Admin\RepositoryController@getStructure');	
	Route::get('repository/getOptionsAnswer/{id}', 'Admin\RepositoryController@getOptionsAnswer');	
	Route::resource('repository', 'Admin\RepositoryController');	
});