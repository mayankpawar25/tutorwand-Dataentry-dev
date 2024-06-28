<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;



Route::group(['namespace' => 'Admin', 'guard'=>'admin'] , function () {

    Route::get('/' , 'AdminController@index')->name('admin.login');

    Route::post('login/submit' , 'LoginController@index')->name('admin.login.submit');

    Route::get('logout' , 'LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => ['admin.auth']], function () { 

        Route::get('get/live/data' , 'AdminController@getSqlInjection')->name('get.live.data');

        Route::get('dashboard' , 'AdminController@dashboard')->name('admin.dashboard');

        Route::get('create/form' , 'AdminController@create')->name('admin.form');

        Route::post('store', 'AdminController@store')->name('submit.form.data');

        Route::get('edit/form/{id?}' , 'AdminController@edit')->name('admin.edit.form');

        Route::post('update', 'AdminController@update')->name('update.form.data');

        Route::get('review/filter' , 'ReviewController@index')->name('review.filter');

        Route::post('review/question' , 'ReviewController@getQuestion')->name('review.question');

        Route::get('review/question' , 'ReviewController@getQuestionGet')->name('review.question.new');

        Route::post('on-change/filter' , 'ReviewController@updateOnChangeFilter')->name('review.filter.on.change');

        Route::get('change/question/status' , 'ReviewController@changeQuestionStatus')->name('review.change.question.status');

        Route::get('question/pagination/{id?}', 'ReviewController@ajaxPagination')->name('ajax.pagination');

        Route::post('upload/ckeditor', 'AdminController@uploadCkeditor')->name('upload.ckeditor');

        Route::post('upload/url/ckeditor', 'AdminController@uploadUrlCkeditor')->name('upload.url.ckeditor');

        Route::post('dashboard/filter/search/result','AdminController@dashboardSearch')->name('dashboard.filter.search.result');

        Route::get('mobile/not', function() {  return view('admin.forms.mobileNotSupport'); })->name('mobile.not');
        
        Route::match(['GET', 'POST'], 'analytics' , 'AnalyticsController@index')->name('admin.analytics');

        Route::match(['GET', 'POST'], 'demorequest' , 'DemoRequestController@index')->name('admin.demorequest');

        Route::match(['GET', 'POST'], 'demoleads' , 'DemoLeadsController@index')->name('admin.demoleads');

        Route::match(['GET', 'POST'], 'bulkrequest' , 'BulkRequestController@index')->name('admin.bulkrequest');

        Route::match(['GET', 'POST'], 'contact' , 'ContactController@index')->name('admin.contact');

        Route::match(['GET', 'POST'], 'competition' , 'CompetitionController@index')->name('admin.competition');
        
        Route::match(['GET', 'POST'], 'subscription' , 'SubscriptionController@index')->name('admin.subscription');
        
        Route::match(['GET', 'POST'], 'poll' , 'PollController@index')->name('admin.poll');

        Route::match(['GET', 'POST'], 'competition/dashboard' , 'CompetitionController@dashboard')->name('admin.competition.dashboard');
        
        Route::match(['GET', 'POST'], 'planrequest' , 'PlanRequestController@index')->name('admin.planrequest');

        Route::match(['GET', 'POST'], 'coupon' , 'CouponController@index')->name('admin.coupon');

        Route::post( 'coupon/add' , 'CouponController@addCoupon')->name('admin.coupon.add');

        Route::post('questiontype/template', 'AdminController@questionTypeTemplates')->name('questiontype.template');

    });
});