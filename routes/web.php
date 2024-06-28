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

// Route::get('/','HomeController@index')->name('home_page');
// Route::get('/' , 'AdminController@index')->name('admin.login');

Route::get('google/auth', "GoogleAPIController@auth")->name('google.auth');
Route::get('google/setRole/{roleId?}', "GoogleAPIController@setRole")->name('google.setrole');

/* Google API */
Route::get('google/login', "GoogleAPIController@token")->name('auth2');

Route::get('privacypolicy', function()
{
    return View::make('privacypolicy');
})->name('privacypolicy');
Route::get('about', function()
{
    return View::make('teachers.pages.about');
});
Route::get('projects', function()
{
    return View::make('teachers.pages.projects');
});
Route::get('contact', function()
{
    return View::make('teachers.pages.contact');
});


Route::group(['namespace' => 'Teacher', 'prefix'=>'grading/assessment', 'as'=>'grading.', 'middleware' => 'role'] , function () {
    Route::get('home', "GradingController@home")->name('assessments.home')->middleware(['mobilecheck']);
    Route::get('board/{paperId?}', "GradingController@board")->name('assessments.board')->middleware(['mobilecheck']);
    Route::get('students/{studentId_paperId_responseId?}', "GradingController@index")->name('assessments.index')->middleware(['mobilecheck']);
    Route::post('sort/students', "GradingController@sortStudentList")->name('sort.students');
    
    Route::get('preview/pdf/{questionPaperId?}', "GradingController@previewPDF")->name('preview.pdf');
    Route::post('save/grade', "GradingController@saveGrade")->name('save');
	
    Route::get('publish/result', "GradingController@publishResult")->name('publish.result');
    Route::post('grade/all', "GradingController@gradeAll")->name('grade.all');
    Route::get('feedback','GradingController@gradingFeedback')->name('feedback');
    Route::post('update/student/list','GradingController@studentListUrl')->name('studentListUrl');

});

Route::group(['namespace' => 'Teacher', 'as'=>''] , function () {
    
    Route::get('teacher', "DashboardController@index")->name('teacher.dashboard')->middleware(['role']);
    
    Route::get('fastrack', "CreateQuestionController@index")->name('fastrack')->middleware(['role', 'mobilecheck']);
    Route::get('get/select/panel', "CreateQuestionController@getSelectPanel")->name('pages.selectPanel');
    Route::get('get/my/templates', "CreateQuestionController@getMyTemplate")->name('pages.myTemplates');
    Route::post('save/general/data' , "CreateQuestionController@saveGeneralData")->name('save.general.data');
    Route::get('testfunction' , "CreateQuestionController@testFunction")->name('get.question.json');
    Route::post('get/template/data' , "CreateQuestionController@getTemplateData")->name('get.template.data');
    Route::post('get/template/json' , "CreateQuestionController@getTemplateJSON")->name('get.template.json');
    Route::get('get/curl/data','CreateQuestionController@getCurlData')->name('get.curl.data');
    Route::get('flush/cache','CreateQuestionController@flushCache')->name('flush.cache');
    Route::post('save/template/data' , "CreateQuestionController@saveTemplateData")->name('save.template.data');
    Route::post('post/template/data' , "CreateQuestionController@updateTemplateData")->name('update.template.data');
    Route::post('assign/template/data' , "CreateQuestionController@assignTemplateData")->name('assign.template.data');
    Route::post('feedback', "CreateQuestionController@feedbackSubmit")->name('question.feedback.submit');
    Route::get('feedback/page', "CreateQuestionController@feedbackPage")->name('question.feedback.page');
    Route::get('check/dup/string' , "CreateQuestionController@checkDuplicateString")->name('check.duplicate.template');
    Route::get('create/paper/pdf' , "CreateQuestionController@uploadPDF")->name('create.paper.pdf');

    /* Board ki taiyari */
    Route::get('board/preparation', "BoardPreparationController@index")->name('boardPreparation')->middleware(['role', 'mobilecheck']);
    Route::get('get/select/board/preparation/panel', "BoardPreparationController@getSelectPanel")->name('pages.boardPreparation.selectPanel');
    Route::get('get/board/preparation/my/templates', "BoardPreparationController@getMyTemplate")->name('pages.boardPreparation.myTemplates');
    Route::post('getPaper', "BoardPreparationController@reviewPaper")->name('pages.boardPreparation.paper');
    Route::get('select/panel','BoardPreparationController@getCurlData')->name('board.get.curl.data');
    Route::get('board/modal' , "BoardPreparationController@questionModal")->name('board.get.questions.modal');
    Route::post('board/data' , "BoardPreparationController@saveGeneralData")->name('board.save.general.data');
    Route::post('submit/data' , "BoardPreparationController@assignTemplateData")->name('board.assign.template.data');

    /* Review Controller Section */
    Route::post('questionreview', "ReviewQuestionController@index")->name('questionreview')->middleware('role');
    Route::get('schedule', "ReviewQuestionController@schedule")->name('schedule');
    Route::get('get/question/swap' , "ReviewQuestionController@questionSwap")->name('get.question.swap');
    Route::get('get/questions/modal' , "ReviewQuestionController@questionModal")->name('get.questions.modal');
    Route::get('get/questions/view', "ReviewQuestionController@getQuestions")->name('get.questions.view');
    Route::post('get/modal/question/swap' , "ReviewQuestionController@swapModalQuestion")->name('get.modal.question.swap');
    Route::post('get/modal/question/report' , "ReviewQuestionController@reportQuestion")->name('get.modal.question.report');
    Route::get('pdf/{paperId?}' , "ReviewQuestionController@downloadPDF")->name('get.question.pdf');
    Route::get('get/question/pdf2' , "ReviewQuestionController@downloadPDF1")->name('get.question.pdf2');
    Route::get('get/question/pdf1' , "ReviewQuestionController@downloadPDFHtml")->name('get.question.pdf1');
    
    /* Assignment Controller Section */
    Route::get('assignment','AssignmentController@index')->name('assignment')->middleware(['role', 'mobilecheck']);
    Route::get('paper/{paperId?}','AssignmentController@reviewPaper')->name('paper')->middleware(['role', 'mobilecheck']);
    Route::get('get/course/student/list','AssignmentController@getCourseStudentList')->name('get.course.student.list');
    
    /* Report Controller Section  */
    Route::get('student/report/{paperId?}/{studentId?}/{GoogleClassId?}','ReportController@index')->name('report')->middleware(['role', 'mobilecheck']);
    Route::get('assessment/report/{paperId?}','ReportController@assessment')->name('assessment.report')->middleware(['role', 'mobilecheck']);
    
    Route::get('student/subject/report/{classId?}','ReportController@report3')->name('assessment.report3')->middleware(['role', 'mobilecheck']);
    Route::get('class/report/{paperId?}','ReportController@report4')->name('assessment.report4')->middleware(['role', 'mobilecheck']);

    Route::post('student/answersheet','ReportController@answerSheet')->name('student.answersheet')->middleware(['role', 'mobilecheck']);

    Route::get('class/list/{teacherId?}','ReportController@home')->name('report.home')->middleware(['role', 'mobilecheck']);
    Route::post('class/list/{teacherId?}','ReportController@ajaxHome')->name('ajax.google.classrooms')->middleware('role');
        
    Route::post('paginations/class/list','GradingController@classList')->name('ajax.pagination.classlist');
    
    /* Dashboard pagination listings */
    Route::get('ajax/class/room/list','DashboardController@ajaxClassroom')->name('ajax.classroom.list');
    Route::get('ajax/assessment/list','DashboardController@ajaxAssessmentList')->name('ajax.assessment.list');
    Route::get('refresh/class/list','DashboardController@refreshClassList')->name('ajax.refresh.class.list');
    
});

Route::group(['namespace' => 'Teacher', 'as' => 'class.'] , function () {

    Route::get('create/class','ClassController@create')->name('create')->middleware(['role', 'mobilecheck']);
    Route::post('store/class','ClassController@store')->name('store')->middleware(['role', 'mobilecheck']);

    Route::get('show/{class_id?}/class','ClassController@show')->name('show')->middleware(['role', 'mobilecheck']);
    Route::post('update/class','ClassController@update')->name('update');
    
    Route::get('refresf/{class_id?}/class','ClassController@refreshClass')->name('refresh');
});

Route::get('chooserole','HomeController@chooseRole')->name('user.chooserole');
Route::get('user/feedback','HomeController@feedback')->name('user.feedback');

Route::get('/mobile-device-not-supported', function(){
    return view('errors.mobileError');
})->name('mobile.view.error');

Route::group(['namespace' => 'Teacher','prefix' => 'board', 'middleware' => 'role'] , function () {
    Route::get('report/{subjectId?}','BoardReportController@index')->name('board.index');
    Route::get('student/report/{subjectId?}','BoardReportController@studentReport')->name('board.student');
});

Route::fallback(function () {
    return abort(404);
});