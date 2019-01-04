<?php
 
/*
|--------------------------------------------------------------------------
| FRONT END ROUTES
|--------------------------------------------------------------------------
*/

	// test
	// Route::get('/certificate-demo', function ()
	// {
	// 	return view('front.exam.certificate');
	// });

	// after authantication routes
	Route::group(['middleware' => 'FrontGeneralMiddleware'],function()
	{
		// index 
		Route::get('/', 'homeController@index');	

		//newsletter
		Route::post('/newsletter', 'homeController@saveNewsLetter');	

		// sign up
		Route::resource('/signup', 'Auth\RegisterController');
		
		// login
		Route::resource('/login', 'Auth\LoginController');
		
		// forget password
		Route::get('/forgot','Auth\ForgotPasswordController@index');
		Route::post('/forgot','Auth\ForgotPasswordController@forgotpassword');
		
		// reset password
		Route::get('/resetpassword/{token}','Auth\ResetPasswordController@index');
		Route::post('/resetpassword','Auth\ResetPasswordController@resetpass');		
		
		// certification rotues
		Route::group(['prefix' => 'certification'],function()
		{
			Route::get('/','Candidate\CertificationController@index');
			Route::get('/detail/{id}','Candidate\CertificationController@detail'); 
			Route::post('/applyVoucher','Candidate\CertificationController@applyVoucher'); 
		});
		

		// after authantication routes
		Route::group(['middleware' => 'UserAuthenticate'],function()
		{
			// Dashboard rotues
			Route::group(['prefix' => 'dashboard'],function()
			{
				Route::get('/', 'Candidate\DashbordController@index');
				Route::post('/buildCourseWiseCharts', 'Candidate\DashbordController@buildCourseWiseCharts');
				Route::get('/buildAllInOneChart', 'Candidate\DashbordController@buildAllInOneChart');
			});

			// certificate routing
			Route::group(['prefix' => 'certificate', 'namespace' => 'Candidate'],function()
			{
				Route::get('/','CertificationController@userCertificatesListing')->name('certificate');
			});

			// purchase course
			Route::group(['prefix' => 'purchase'],function()
			{
				Route::post('/', 	   'PaymentController@purchase')->name('purchase');
				Route::get('/response','PaymentController@response')->name('purchase.response');
				Route::get('/cancel',  'PaymentController@cancel')->name('purchase.cancel');
			});

			// course routes
			Route::group(['prefix' => 'course'],function()
			{
				Route::get('/course-listing', 'Candidate\CourseController@courseListing');
				Route::get('/details/{id}', 'Candidate\CourseController@index');
				Route::get('/{token}/varify', 'Candidate\CourseController@varify');
				Route::post('/updateWatchStatus', 'Candidate\CourseController@UpdatePreStatus');
			});

			// course routes
			Route::group(['prefix' => 'exam', 'namespace' => 'Front'],function()
			{
				Route::get('/',		'ExamController@index')->name('exam');
				Route::post('/submitResult','ExamController@submit')->name('exam.submit');
				Route::post('/updateExamResultStatus','ExamController@updateExamResultStatus')->name('exam.update.status');
				
				Route::get('/exam-book/{id}', 'ExamController@examBook');
				Route::get('/loadEvent', 'ExamController@events');
				Route::get('/getExampSlot', 'ExamController@getExampSlot');
				Route::post('/bookExamSlot', 'ExamController@bookExamSlot');
			});

			Route::get('/logout', 'Auth\LoginController@logout');			//logout
			Route::post('/logout', 'Auth\LoginController@logout');
		});

	});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

	Route::group(['prefix' => 'admin','middleware' => 'AdminRedirectIfAuthenticated', 'namespace'=>'Admin'],function()
	{
		Route::get('/login', 'Auth\LoginController@index');//login
		Route::post('/login', 'Auth\LoginController@checkLogin');

		Route::get('/forgot','Auth\LoginController@forgotpassword');//forgot password
		Route::post('/forgot','Auth\LoginController@forgot');

		Route::get('/resetpassword/{token}','Auth\LoginController@resetpassword');//reset password
		Route::post('/resetpassword','Auth\LoginController@resetpass');
	});

	Route::group(['prefix' => 'admin','middleware' => 'AdminAuthenticate', 'namespace'=>'Admin'],function()
	{
		Route::redirect('/', 'admin/dashboard');						//dashboard
		Route::get('/logout', 'Auth\LoginController@logout');			//logout
		Route::post('/logout', 'Auth\LoginController@logout');
		Route::get('/dashboard', 'DashboardController@index');

		// Question type routes
		Route::get('question-type/getQuestionTypes', 'QuestionTypeController@getTypes');	
		Route::post('question-type/changeStatus', 'QuestionTypeController@changeStatus');	
		Route::resource('question-type', 'QuestionTypeController');

		// Repository routes
		Route::get('question/getRecords', 'QuestionsController@getRecords');	
		Route::get('question/getHtmlStructure/{id}', 'QuestionsController@getStructure');	
		Route::get('question/getOptionsAnswer/{id}', 'QuestionsController@getOptionsAnswer');	
		Route::resource('question', 'QuestionsController');	

		// Prerequisite routes
		Route::get('prerequisite/getPrerequisite', 'PrerequisiteController@getPrerequisite');	
		Route::post('prerequisite/changeStatus', 'PrerequisiteController@changeStatus');	
		Route::resource('prerequisite', 'PrerequisiteController');

		// Exam routes
		Route::post('exam/getDynamicQuesions', 'ExamController@getDynamicQuesions');	
		Route::get('exam/getRecords', 'ExamController@getRecords');	
		Route::post('exam/changeStatus', 'ExamController@changeStatus');	
		Route::resource('exam', 'ExamController');

		// Coure routes
		Route::get('course/getRecords', 'CourseController@getRecords');	
		Route::post('course/changeStatus', 'CourseController@changeStatus');	
		Route::resource('course', 'CourseController');

		// site setting routes
		Route::get('site-setting/getSettings', 'SiteSettingController@getSettings');
		Route::resource('site-setting', 'SiteSettingController');	

		// council member routes
		Route::get('council-member/getMembers', 'CouncilMemberController@getMembers');
		Route::post('council-member/changeStatus', 'CouncilMemberController@changeStatus');
		Route::resource('council-member', 'CouncilMemberController');

		// question category routes
		Route::get('question-category/getQuestionCategory', 'QuestionCategoryController@getQuestionCategory');
		Route::post('question-category/changeStatus', 'QuestionCategoryController@changeStatus');
		Route::resource('question-category', 'QuestionCategoryController');	

		// news-letter routes
		Route::get('news-letter/getNewsLetter', 'NewsLetterController@getNewsLetter');
		Route::post('news-letter/changeStatus', 'NewsLetterController@changeStatus');
		Route::resource('news-letter', 'NewsLetterController');	
		
		//Voucher routes
		Route::get('voucher/getVoucher', 'VoucherController@getVoucher');
		Route::post('voucher/changeStatus', 'VoucherController@changeStatus');
		Route::resource('voucher', 'VoucherController');	
	});
