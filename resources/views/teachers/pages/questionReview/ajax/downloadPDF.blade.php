<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>TutorWand</title>
        
        <!-- <style type="text/css">
            * { 
                font-size:13px;
	    		font-family: 'freeserif', sans-serif;
            }
        </style> -->
    <style type="text/css">
        * {
            font-size: 13px;
            font-family: Arial, Helvetica, sans-serif;
            /* font-family: 'freeserif', sans-serif; */
            margin: 0px;
            padding: 0px;
        }

        body {
            font-size: 13px;
        }
        
        .question-block {
            position: relative;
            margin-top: 12px;
            margin-bottom: 12px;
        }
        
        .w-100 {
            width: 100% !important;
        }
       
        .question-list {
            display: block;
            
            padding-right: 0px;
            position: relative;
            padding-top: 0px;
            word-break: break-word;
            
            word-wrap: anywhere;
        }
        
        .question-list .q-serial {
            border: 1px solid #212121;
            text-align: center;
            padding: 1px 2px;
            
            width: 30px;
            height:16px;
            font-size: inherit;
            color: #484644;
            float: left;
            margin-right: 0px;
        }
        
        .q-content {
            float: left;
           
            margin-bottom: 12px;
        }
        
        .q-content p {
            display: inline-block;
            font-size: inherit;
            white-space: revert;
            word-wrap: anywhere;
            margin-bottom: 0px;
            padding-top: 2px;
            margin: 0px;
            float: left;
            padding-left: 0px;
        }
        
        .row {
            width: 100%;
            float: left;
        }
        
        .col-sm-12,
        .col-md-12,
        .col-lg-12 {
            max-width: 100%;
            width: 100%;
            float: left;
        }
        
        .option-list:last-child {
            margin-bottom: 0px;
        }
        
        .option-list {
            display: table;
            margin-left: 84px;
            margin-bottom: 6px;
            word-break: break-all;
        }
        
        .option-list .opt-num {
            width: 18px;
            vertical-align: top;
            display: table-cell;
            float: left;
        }
        
        .option-list .opt-content {
            font-size: inherit;
            word-wrap: anywhere;
            line-height: 1.1;
            margin: 2px 0px 4px 12px;
            width: 500px;
            float: left;
        }

        .option-list .opt-num p {
            font-size: inherit;
            margin: 0px;
            padding: 0px;
        }
        
        .option-list .opt-content p {
            font-size: inherit;
            margin: 0px;
            padding: 0px;
        }

        .opt-num {
            border: 1px solid #484644;
            height: 16px;
            overflow: hidden;
            text-align: center;
            border-radius: 100%;
            font-size: 10px;
            margin-top: 0px;
            line-height: 16px;
            margin-right: 12px;
        }
        
        .canvas-area {
            max-width: 800px;
            margin: 15px auto;
        }
        
        .point-badge {
            background-color: transparent;
            color: #178D8D;
            font-size: inherit;
            text-align: center;
            /* width: 28px; */
            height: 28px;
            /* border-radius: 0; */
            padding: 1px 0px 0px 0px;
            margin-top: 0px;
            cursor: default !important;
           
            /* display: grid; */
            float: right;
        }

        .point-badge small {
            font-size: 10px;
            display: block;
        }

        
        .q-action-block {
            float: right;
            width: 35px;
            vertical-align: top;
        }
                
        /* .point-badge p {
            margin:0px;
            padding:0px;
        } */
    
        .mb-1, .my-1 {
            margin-bottom: .25rem!important;
        }
        .main-body{
            width:680px;
            margin:0px auto;
        }
        .table{
            border:1px solid #707070; font-size:12px;
            margin-bottom:15px;
        }
        .table tr td, .table tr th{
            border:1px solid #707070;

        }
    </style>
    </head>
    <body>
        <div class="main-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-lg-12">

                        <div class="canvas-area">
                            <table width="100%">
                                <tbody>
                                    <tr>
                                       <td><strong>{{ __('students.class') }}: {{ $postData['header']['class']['gradeName'] }}</strong></td>
                                       <td align="right" >{{ __('students.maxmarks') }}: {{ $postData['header']['maximumMarks'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('students.subject') }}: {{ $postData['header']['subject']['subjectName'] }}</strong></td>
                                        <td align="right">
                                            @if($postData['header']['testDuration'] > 0)
                                                {{ __('students.time') }}: {{ $postData['header']['testDuration'] }} {{ __('teachers.schedule.minutes') }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>

                            <!-- Instructions Section -->
                            <h4 style="margin-top:0px; margin-bottom:0px">{{ __('teachers.downloadPDF.instructions') }}: </h4>
                            {!! $postData['instructions'] !!}
                            <div class="">
                                <table width="100%" class="table"  cellpadding="5" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('teachers.assessment.questionNumbers') }}</th>
                                            <th scope="col">{{ __('teachers.assessment.questionType') }}</th>
                                            <th scope="col">{{ __('teachers.assessment.count') }}</th>
                                            <th scope="col">{{ __('teachers.assessment.pointsPerQuestions') }}</th>
                                            <th scope="col">{{ __('teachers.assessment.total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @if(isset($canvasData['formatModels']))
                                            @foreach($canvasData['formatModels'] as $key => $questionFormat)
                                                <tr>
                                                    <th  scope="row" align="left">{{ $questionFormat['range'] }}</th>
                                                    <td align="left">{{ getTemplateName($questionFormat['questionTypeId']) }}</td>
                                                    <td align="right">{{ $questionFormat['numberOfQuestion'] }}</td>
                                                    <td align="right">{{ $questionFormat['weightage'] }}</td>
                                                    <td align="right">{{ $questionFormat['weightage'] * $questionFormat['numberOfQuestion'] }}</td>
                                                </tr>
                                                @php
                                                    $total += $questionFormat['weightage'] * $questionFormat['numberOfQuestion'];
                                                @endphp
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" align="left">{{ __('teachers.assessment.grandTotal') }}</th>
                                            <td align="right">{{ $total }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                           </div>
                           
                            <!-- Instructions Section -->
                            <table width="100%">
                                <tbody>
                                    @php
                                        $question_number = 1;
                                        $data_id = 0;
                                        $allowedQuestionTypes = ['529kWMwg', 'HH9Tu7BZ', 'nOFiSUZ8', 'Tqg3XB1M', '4NcrZAcU'];
                                    @endphp
                                    @if (isset($canvasData['questions']) && !empty($canvasData['questions']))
                                        @foreach ($canvasData['questions'] as $id => $question)
                                            @php
                                                $question = decryptBlobData($question);
                                            @endphp
                                            @if (in_array($question['questionTypeId'], $allowedQuestionTypes))
                                                <tr>
                                                    <td>
                                                        <div class="item" style="page-break-inside: auto" id="question{{ $id }}" data-id="{{ $data_id }}" data-swapId="{{ $id }}" data-questionid="{{ $question['id'] }}" data-paperid="{{ $canvasData['questionPaperId'] }}" data-questionnumber="{{ $question_number }}">
                                                            <table class="question-list">
                                                            <tr >
                                                            <td align="left" valign="top" style="width:30px"> <div class="q-serial">{{ $question_number }}. </div></td>
                                                            <td align="left" style="width:615px"><div class="q-content">{!! $question['questionText'] !!}</div></td>
                                                            <td align="right" valign="top" style="width:35px">
                                                                <button class="btn point-badge ">{{ $question['weightage'] }}
                                                                    <small>{{ pointText($question['weightage']) }}</small>
                                                                </button>
                                                            </td>
                                                            </tr>
                                                            </table>
                                                            <div class="question-block question{{ $id }}" data-id="{{ $id }}" data-questionid="{{ $question['id'] }}" data-paperid="{{ $canvasData['questionPaperId'] }}">
                                                               <table>
                                                                
                                                                
                                                                    @if ($question['questionTypeId'] == config("constants.mcqId") || $question['questionTypeId'] == config("constants.trueFalseId")) 
                                                                        @php
                                                                            $alphabet = 'A';
                                                                        @endphp
                                                                        @foreach ($question['answerBlock']['options'] as $pid => $option) 
                                                                          <tr>
                                                                            <td align="right" valign="top" style="width:30px; padding-left:30px; padding-right:8px">{{ $alphabet }})</td>
                                                                            <td align="left" style="width:100%">{!! $option['optionText'] !!}</td>
                                                                            
                                                                        </tr>
                                                                            @php
                                                                                $alphabet++;
                                                                            @endphp
                                                                        @endforeach
                                                                    @endif
                                                                
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php
                                                    $question_number++;
                                                    $data_id++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
