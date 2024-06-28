@extends('teachers.layouts.default')
@section('content')
    
        <div id="smartwizard" class="sw-main sw-theme-arrows position-relative">
            <ul class="nav nav-tabs step-anchor">
                <li id="informationNav" class="nav-item active"><a href="#" class="nav-link">{{ __('teachers.general.general') }}
                    <small>{{ __('teachers.general.detaBlueprint') }}</small>
                </a></li>
                <li id="reviewNav" class="nav-item done"><a href="#" class="nav-link">{{ __('teachers.general.review') }}
                    <small>{{ __('teachers.general.reviewQuestions') }}</small>
                </a></li>
                <li id="scheduleNav" class="nav-item done"><a href="#" class="nav-link">{{ __('teachers.general.schedule') }}
                    <small>{{ __('teachers.general.scheduleAssignClass') }}</small>
                </a></li>
            </ul>
            <ul class="list-unstyled nav-112">
                <li class="pull-right">
                    <button class="btn btn-primary" data-href="review" id="reviewTab">{{ __('questionLayout.next') }} </button>
                    <a class="btn btn-outline-primary d-none mr-2" disabled data-href="information" id="reviewPreviousBtn" disabled> {{ __('questionLayout.previous') }}</a>
                    <button class="btn btn-outline-primary d-none mr-2" data-href="review" id="schedulePreviousTab">{{ __('questionLayout.previous') }}</button>
                    <button class="btn btn-primary d-none disabled" data-href="review" id="scheduleTab" disabled>{{ __('questionLayout.next') }} </button>
                    <button type="button" id="assign" class="btn btn-primary d-none"> {{ __('questionReview.assign') }}</button>
                </li>
            </ul>
        </div>
        <div class="tab-panel-outer position-relative">
            <!-- tab-panel-start -->
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="information">
                    <div id="informationDiv">
                        @include('teachers.pages.questionLayout.ajax.general')
                    </div>
                </div>
                <div class="tab-pane" id="reviewDiv" style="padding: 0px 15px 0px 0px;">
                    
                </div>
                <div class="tab-pane" id="review">
                    <div id="scheduleDiv"></div>
                </div>
            </div>
            <!-- tab panel end -->
        </div>
    </div>

    <!-- preview2-modal -->
    <div class="modal" id="preview2" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('teachers.general.createFormatBlueprint') }}
                    </h4>

                    <span class="enlarge-popup-btn mr-4 cursor-pointer text-disable" tabindex="1" role="button"> 
                        {!! config('constants.icons.enlarge-icon') !!}
                    </span>
                    <span class="pull-right mr-5 pr-5 text-brand">
                    
                    </span>
                    <button type="button" class="close" data-dismiss="modal" tabindex="1" role="button">
                        {!! config('constants.icons.close-icon') !!}
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-0">

                                {{-- Form Input component --}}

                                <x-forms.input type="text" class="form-control input-regular" placeholder="{{ __('teachers.createFormat.provideFromatName') }}" name="template_title"  maxlength="20"/>

                                {{-- Form Input component --}}

                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <button tabindex="1" role="button" class="btn btn-outline-primary mr-2" data-dismiss="modal">{{ __("teachers.button.cancel") }}</button>
                            <button tabindex="1" role="button" class="btn btn-primary" id="saveTemplate">{{ __("teachers.button.save") }}</button>
                        </div>
                    </div>
                    <hr>
                    <div class="overflow-y-auto">
                        <table class="table table-hover" id="sortTtable">
                            <thead>
                                <tr>
                                    <th scope="col" width="15px"></th>
                                    <th scope="col" width="65%">{{ __('questionLayout.questionType') }}</th>
                                    <th scope="col" width="10%" class="text-center">{{ __('questionLayout.count') }}</th>
                                    <th scope="col" width="10%" class="text-center">{{ __('questionLayout.marks') }}</th>
                                    <th scope="col" width="10%" class="text-center">{{ __('questionLayout.total') }}</th>
                                    <th scope="col" width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td>
                                        <x-select tabindex="0" role="select"  id="question-type" label="{{ __('questionLayout.selectQuestionType') }}" class="selectpicker add_question_type" data-live-search="true" name="question_type" options="{{ json_encode($questionLayout['questionVariationTypes']) }}" selected="" optionkey="questionTypeId" optionvalue="questionTypeName">
                                        </x-select>
                                    </td>
                                    <td>
                                        {{-- Form Input component --}}

                                        <x-forms.input type="text" class="form-control table-input is_number enter_counter" />

                                        {{-- Form Input component --}}
                                    </td>
                                    <td>
                                        {{-- Form Input component --}}

                                        <x-forms.input type="text" class="form-control table-input is_number enter_marks" />

                                        {{-- Form Input component --}}
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- question type table end -->
                    <table class="table table-hover total-table">
                        <thead>
                            <tr>
                                <th scope="col" width="15px">

                                </th>
                                <th scope="col" width="65%">{{ __('questionLayout.grandTotal') }}</th>
                                <th scope="col" width="10%" class="text-center total_count_value">0</th>
                                <th scope="col" width="10%"></th>
                                <th scope="col" width="10%" class="text-center all_totals">0</th>
                                <th scope="col" width="5%"></th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="modal confirm" id="confirm" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">

                    <h5>{{ __("teachers.general.submitAssessmentConfirm") }}</h5>
                    <!-- question type table end -->
                    <hr>
                    <button class="btn btn-outline-primary mr-2" data-dismiss="modal" id="close-confirm">{{ __("teachers.button.cancel") }}</button>
                    <button class="btn btn-primary assign-confirm">{{ __("teachers.button.confirm") }}</button>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
    </div>
    <!-- bootstrap js -->
@stop
