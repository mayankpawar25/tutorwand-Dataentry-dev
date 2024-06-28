<?php

Route::group(['namespace' => 'Students', 'as'=>'students.'] , function () {
    //Route::get('dashboard', "DashboardController@index")->name('dashboard')->middleware(['role', 'mobilecheck']);
    Route::get('/', "DashboardController@index")->name('dashboard')->middleware(['role']);

    Route::get('assessment', "AssignmentController@index")->name('assessment')->middleware('role');
    Route::get('instructions/{paperId?}/{studentId?}', "StudentController@examInstructions")->name('instructions')->middleware('role');
    Route::get('exam/{paperId?}/{studentId?}', "StudentController@examPaper")->name('exam')->middleware('role');

	Route::get('assessments', "AssignmentController@index")->name('index')->middleware('role')->middleware('role');
    Route::get('toolinstruction', "StudentController@toolInstruction")->name('toolinstruction')->middleware('role');
    Route::get('studentexam', "StudentController@studentExam")->name('studentexam')->middleware('role');
    Route::get('exam', "StudentController@paper")->name('exam')->middleware('role');
    Route::post('update/submit/review', "StudentController@updateReviewQuestions")->name('update.submit.review')->middleware('role');
    Route::get('review', "StudentController@showSubmitPreview")->name('show.submit.review')->middleware('role');
    Route::get('feedback', "StudentController@feedbackScreen")->name('feedback.screen')->middleware('role');

    Route::post('fileupload','StudentController@fileUpload')->name('fileupload')->middleware('role');
    Route::post('fileremove','StudentController@fileRemove')->name('fileremove')->middleware('role');
    Route::post('get/student/question/report' , "StudentController@reportQuestion")->name('get.student.question.report')->middleware('role');
    Route::post('submit/question/response' , "StudentController@questionResponse")->name('question.response')->middleware('role');
    Route::post('clearQuestion','StudentController@clearQuestion')->name('clearQuestion')->middleware('role');
    Route::post('resumeExam','StudentController@resumeExam')->name('resumeExam')->middleware('role');
    Route::get('submit/exam','StudentController@submitExam')->name('submit.paper')->middleware('role');
    Route::post('updateTimer','StudentController@updateTimer')->name('updateTimer')->middleware('role');

    /* Report Home Page */
    //Route::get('report/{studentId?}','ReportController@index')->name('report.home')->middleware(['role','mobilecheck']);
    Route::get('report/{studentId?}','ReportController@index')->name('report.home')->middleware(['role']);
    Route::post('report/{teacherId?}','ReportController@ajaxHome')->name('ajax.google.classrooms')->middleware(['role']);

    // Route::get('class/report/{paperId?}','ReportController@classReport')->name('class.report')->middleware(['role','mobilecheck']);
    Route::get('class/report/{paperId?}','ReportController@classReport')->name('class.report')->middleware(['role']);
    // Route::get('assessment/report/{paperId?}','ReportController@studentReport')->name('assessment.report')->middleware(['role','mobilecheck']);
    Route::get('assessment/report/{paperId?}','ReportController@studentReport')->name('assessment.report')->middleware(['role']);
    // Route::get('assessment/result/{paperId?}','ReportController@studentResult')->name('assessment.report-result')->middleware(['role','mobilecheck']);
    Route::get('assessment/result/{paperId?}','ReportController@studentResult')->name('assessment.report-result')->middleware(['role']);
    Route::post('student/answersheet','ReportController@answerSheet')->name('answersheet')->middleware('role');

    /* Dashboard pagination listings */
    Route::get('ajax/class/room/list','DashboardController@ajaxClassroom')->name('ajax.classroom.list');
    Route::get('ajax/assessment/list','DashboardController@ajaxAssessmentList')->name('ajax.assessment.list');
    Route::get('refresh/class/room/list','DashboardController@refreshClassroom')->name('refresh.class.list');
    
    Route::get('global/report/{eventid?}/{encodedId?}', 'BoardReportController@index')->name('class.board.report');
    Route::get('global/assessment/{assessmentId?}','BoardReportController@subjectReport')->name('class.subject.report');
});

?>