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

Route::group(['prefix' => 'admin','middleware' => 'AdminRedirectIfAuthenticated'],function()
{
	Route::get('/login', 'Auth\LoginController@index');//login
	Route::post('/login', 'Auth\LoginController@checkLogin');

	Route::get('/forgot','Auth\LoginController@forgot');//forgot password
	Route::post('/forgot','Auth\LoginController@forgot');

	Route::get('/resetpassword/{id}','Auth\LoginController@resetpassword');//reset password
	Route::post('/resetpassword','Auth\LoginController@resetpass');
});

Route::group(['prefix' => 'admin','middleware' => 'AdminAuthenticate'],function()
{
	Route::redirect('/', 'admin/dashboard');						//dashboard
	Route::get('/logout', 'Auth\LoginController@logout');			//logout
	Route::post('/logout', 'Auth\LoginController@logout');
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

	// Prerequisite routes
	Route::get('prerequisite/getPrerequisite', 'Admin\PrerequisiteController@getPrerequisite');	
	Route::post('prerequisite/changeStatus', 'Admin\PrerequisiteController@changeStatus');	
	Route::resource('prerequisite', 'Admin\PrerequisiteController');

	// site setting routes
	Route::get('site-setting/getSettings', 'Admin\SiteSettingController@getSettings');
	Route::resource('site-setting', 'Admin\SiteSettingController');	

	// council member routes
	Route::resource('concilMembers', 'Admin\CouncilMemberController');	
});
