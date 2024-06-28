<?php

Route::group([ "domain" => config('constants.ExtAPIUrl') ], function () {



    Route::group(['prefix' => 'api'], function(){



        Route::group(['prefix' => 'Filter'], function(){

            Route::get("FetchBoards")->name("select_board");

            Route::get("FetchGrades")->name("select_grade");

            Route::get("FetchSubject")->name("select_subject");

            Route::get("FetchTopics")->name("select_topic");

        });



        Route::post('QuestionPage/CreateQuestion')->name('create.question');

        

        Route::group(['prefix' => 'FastTrack'], function(){

            Route::get("GetQuestionTypes")->name("get.question.types");

            Route::post("GetTeachersQuestionPaper")->name("post.questions");

            Route::get("SwapQuestion")->name("get.swap.question");

            Route::get("GetFastTrackConfiguration")->name("get.fastTrackConfiguration");

            Route::post("FlagQuestion")->name("post.report.question");

            Route::get("GetQuestionPaper")->name("get.QuestionPaper");

            Route::get("GetQuestionPaperById")->name("get.getQuestionPaperById");

            Route::get("SaveQuestionPaperAsFile")->name("post.savequestionpaper");

        });



        Route::group(['prefix' => 'AssignmentFormat'], function(){

            Route::get("GetDefaultAssignmentFormats")->name("get.default.templates");

            Route::post("UpdateAssignmentFormat")->name("update.template");

            Route::post("CreateRecentlyUsedAssignmentFormat")->name("assign.template");

        });

        

        /* Admin QuestionInjection API */

        Route::group(['prefix' => 'QuestionIngestion' ] , function(){

            Route::get("GetBoards")->name("swagger.boards"); 

            Route::get("GetGrades")->name("swagger.grades"); 

            Route::get("GetSubjectsByGradeId")->name("swagger.subjects");

            Route::post("AddQuestion")->name('swagger.store.question');

            Route::get('GetQuestionIngestionFilter')->name('swagger.ingestion.filters');

            Route::post("UploadFileFromCKEditor")->name("upload.image.ckeditor");

            Route::post("UploadFileFromUrl")->name("upload.url.ckeditor");

        });

        /* Admin QuestionInjection API */



        Route::group(['prefix' => 'QuestionReview'] , function(){

            Route::get("GetReviewFilter")->name("get.review.filters");

            Route::patch("EditQuestion")->name('swagger.update.question');

            // Route::post("GetUnApprovedQuestion")->name('get.review.question');

            Route::post("GetQuestionByFilter")->name('get.review.question');

            Route::post("ReviewQuestion")->name('admin.question.review');

            Route::get('GetQuestionByFilterWithPaging')->name('swagger.question.pagination');

            Route::get('GetReviewDashboardQuestionCount')->name('review.dashboard.count');

        });

        

        Route::group(['prefix' => 'Student'] , function(){

            Route::post("UploadFiles")->name('post.upload.file');

            Route::delete("DeleteFile")->name('post.remove.file');

            Route::post("AddResponse")->name('submit.question.response');

            Route::patch("UpdateResponse")->name('update.question.response');

            Route::patch("ClearResponse")->name('clear.question');

            Route::get("ResumeExam")->name('resume.exam');

            Route::put("SubmitResponse")->name('submit.exam');

            Route::patch("UpdateTimer")->name('updatetimer');

            Route::get("GetMyQuestionPaper")->name("get.getQuestionPaper");

            Route::get("GetStudentQuestionPapers")->name("studentQuestionPaper");

        });



        Route::group(['prefix' => 'Classroom'] , function(){

            Route::get("GetClassRoomByRole")->name('get.getclassroom');

            Route::post("AssignExamination")->name('assign.examination');

            Route::post("OnboardUser")->name('set.refreshToken');

            Route::post("CreateClassAndInviteStudents")->name('create.classroom');

            Route::post("InviteStudents")->name('invite.students');

            Route::get("ClassStudentList")->name('class.student.lists');

        });



        Route::group(['prefix' => 'Identity'] , function(){

            Route::get("GetUserProfile")->name('get.userprofile');

            Route::get("GetMyAssignmentFormats")->name("get.my.templates");

            Route::post("AddAssignmentFormat")->name("post.template");

            Route::post("GetFastTrackQuestionPapers")->name("get.previous.questions");

            Route::post("UpdateUserRole")->name("update.user.role");

        });

        

        Route::group(['prefix' => 'Grading'] , function(){

            Route::get("GetGradingAssessments")->name('get.grading.assessments');

            Route::get("GetStudentResponseStatus")->name('get.student.response.status');

            Route::get("GetStudentResponseWithSolution")->name('get.student.response.solution');

            Route::patch("SaveStudentsGradingMarks")->name('save.student.grade');

            Route::post("PublishResult")->name('publish.result');

            Route::patch("GradeAllStudentsOfAutoGradedAssessment")->name("grade.all.api");

        });



        Route::group(['prefix' => 'InernalUserIdentity'], function(){

            Route::get("AuthorizeAndGetRole")->name('get.admin.auth');

        });



        Route::group(['prefix' => 'Reporting'], function(){

            Route::get("GetStudentReport")->name('get.student.report'); // S1

            Route::get("GetClassAssessmentReport")->name('get.assessment.report'); // S2

            

            Route::get("GetReportHome")->name('get.report.home'); // Report Home

            Route::get("GetStudentReportHome")->name('student.report.home'); // Report Home

            

            Route::get("GetClassReportBySubject")->name('class.report.by.subject'); // Scenerio 4

            Route::get("GetStudentReportBySubject")->name('student.report.by.subject'); // Scenerio 3



            Route::get('GetStudentAssessmentReport')->name('student.assessment.report');



            Route::get('GetStudentReport')->name('api.reporting.student.report');

            

            Route::get('GetGlobalAssessmentReport')->name('api.global.assessment.reporting');

            Route::get('GetGlobalStudentAssessmentReport')->name('api.global.student.assessment.reporting');

            Route::get('GetGlobalClassAssessmentReport')->name('api.subject.assessment');



        });

        Route::group(['prefix' => 'MagicBand'] , function(){

            Route::get('GetUsers')->name('api.get.users');
        
        });

        Route::group(['prefix' => 'Telemetry'] , function(){

            Route::get('GetTelemetry')->name('api.get.telemetry');
        
        });

        Route::group(['prefix' => 'Monetization'] , function(){

            Route::get('GetCoupons')->name('api.get.coupon');

            Route::post('CreateCoupon')->name('api.add.coupon');
        
        });


    });



});

// Note that the “domain” url could be put in the .env file.

