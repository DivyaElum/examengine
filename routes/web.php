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

// Front section
Route::get('/', function () {
    return view('welcome');
});

Route::get('/exam', function () {
    return view('exam');
});
 
Route::group(['prefix' => 'purchase'],function()
{
	Route::post('/', 	   'PaymentController@purchase')->name('purchase');
	Route::get('/response','PaymentController@response')->name('purchase.response');
	Route::get('/cancel',  'PaymentController@cancel')->name('purchase.cancel');
});

Route::resource('/signup', 'Auth\RegisterController'); //registration

Route::get('/logout', 'Auth\LoginController@logout'); //logout
Route::post('/logout', 'Auth\LoginController@logout');

//Route::post('/login', 'Auth\RegisterController@checkLogin'); // login

Route::resource('/login', 'Auth\LoginController');

Route::get('/forgot','Auth\ForgotPasswordController@index'); //forgot password
Route::post('/forgot','Auth\ForgotPasswordController@forgotpassword');

Route::get('/resetpassword/{token}','Auth\ResetPasswordController@index'); //reset password
Route::post('/resetpassword','Auth\ResetPasswordController@resetpass');


Route::group(['middleware' => 'UserAuthenticate'],function()
{
	Route::get('/dashboard', 'Candidate\DashbordController@index');
	Route::group(['prefix' => 'certification'],function()
	{
		Route::get('/','Candidate\CertificationController@index');
		Route::get('/detail/{id}','Candidate\CertificationController@detail'); 
	});

	Route::group(['prefix' => 'course'],function()
	{
		Route::get('/details/{id}', 'Candidate\CourseController@index');
		Route::post('/updateWatchStatus', 'Candidate\CourseController@UpdatePreStatus');
	});
});


// Admin section
Route::group(['prefix' => 'admin','middleware' => 'AdminRedirectIfAuthenticated'],function()
{
	Route::get('/login', 'Admin\Auth\LoginController@index');//login
	Route::post('/login', 'Admin\Auth\LoginController@checkLogin');

	Route::get('/forgot','Admin\Auth\LoginController@forgotpassword');//forgot password
	Route::post('/forgot','Admin\Auth\LoginController@forgot');

	Route::get('/resetpassword/{token}','Admin\Auth\LoginController@resetpassword');//reset password
	Route::post('/resetpassword','Admin\Auth\LoginController@resetpass');
});

Route::group(['prefix' => 'admin','middleware' => 'AdminAuthenticate'],function()
{
	Route::redirect('/', 'admin/dashboard');						//dashboard
	Route::get('/logout', 'Admin\Auth\LoginController@logout');			//logout
	Route::post('/logout', 'Admin\Auth\LoginController@logout');
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

	// Exam routes
	Route::post('exam/getDynamicQuesions', 'Admin\ExamController@getDynamicQuesions');	
	Route::get('exam/getRecords', 'Admin\ExamController@getRecords');	
	Route::post('exam/changeStatus', 'Admin\ExamController@changeStatus');	
	Route::resource('exam', 'Admin\ExamController');

	// Coure routes
	Route::get('course/getRecords', 'Admin\CourseController@getRecords');	
	Route::post('course/changeStatus', 'Admin\CourseController@changeStatus');	
	Route::resource('course', 'Admin\CourseController');

	// site setting routes
	Route::get('site-setting/getSettings', 'Admin\SiteSettingController@getSettings');
	Route::resource('site-setting', 'Admin\SiteSettingController');	

	// council member routes
	Route::get('council-member/getMembers', 'Admin\CouncilMemberController@getMembers');
	Route::post('council-member/changeStatus', 'Admin\CouncilMemberController@changeStatus');
	Route::resource('council-member', 'Admin\CouncilMemberController');

	// question category routes
	Route::get('question-category/getQuestionCategory', 'Admin\QuestionCategoryController@getQuestionCategory');
	Route::post('question-category/changeStatus', 'Admin\QuestionCategoryController@changeStatus');
	Route::resource('question-category', 'Admin\QuestionCategoryController');	
});
