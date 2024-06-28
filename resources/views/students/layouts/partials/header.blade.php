<div class="main-header">
    <div class="header-bg-strip">
        <div class="container-fluid">
            <div class="header-left">
                <span  class="float-left d-none d-lg-block d-md-block">{!! getEnvironment() !!}</span>
                <span  class="mob-logo d-block d-lg-none d-md-none">
                <img src="{{ asset('assets/images/students/logo-sm.svg')}}" class="small-logo">
                </span>
                @if(isset($questionData))
                    @if(!(request()->is('students/feedback')))
                        <button class="btn btn-outline-primary-v2 font-btn btn-lg pull-right mr-1" data-toggle="tooltip" data-placement="bottom" title="{{ __('students.fontResize') }}"> 
                            {!! config('constants.icons.font-size-svg') !!}
                        </button>
                        @if(!$questionData['header']['isUntimed'])
                            <button class="btn btn-outline-primary-v2 btn-lg mr-2 pull-right clock active">
                                <span class="time" id="timer">{{ $questionData['header']['testDuration'] }}:00</span>
                                <span class="time-left">{{ __('students.timeLeft') }}</span> <i class="fa fa-eye time-on" aria-hidden="true"></i> <i class="fa fa-low-vision time-of" aria-hidden="true"></i> 
                            </button>
                        @endif
                    @endif
                @endif
            </div>
            <div class="header-right">
                <div class="my-lg-0">
                    @php
                        if(Session::get('profile')) {
                            $session = Session::get('profile');
                            $photo = handleProfilePic($session['profilePicUrl']);
                            if (isset($photo) && !empty($photo) ) {
                                $profileMedia = '<img src="'.$photo.'" class="profile-dd-icon"/>';
                            } else {
                                $words = preg_split("/\s+/", $session['firstName'] . ' ' . $session['lastName']);
                                $acronym = "";
                                foreach ($words as $k => $w) {
                                    if($k < 2) {
                                        $acronym .= $w[0];
                                    }
                                }
                                $profileMedia = '<div class="name-title">' . $acronym. '</div>';
                            }
                    @endphp
                    <div class="user-icon dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                            {!! $profileMedia !!}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-menu text-center">
                            {!! $profileMedia !!}
                            <h4>{{ Session::get('profile')['firstName'] . ' '. Session::get('profile')['lastName']}}</h4>
                            <P class="text-disable">{{ Session::get('profile')['emailId'] }}</P>
                            <hr>
                            <a href="{{ route('flush.cache') }}" class="btn btn-outline-primary mb-2">{{ __('teachers.signOut') }}</a>
                        </div>
                    </div>
                    @php
                        } else {
                    @endphp
                        <div>
                            <a class="btn btn-outline-primary mt-2" href="{{route('auth2')}}" style="box-shadow: none !important;">{{ __('teachers.login') }}</a>
                        </div>
                    @php
                        }
                    @endphp
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid end -->

    @if(request()->is('students/assessment/report/*') || request()->is('students/global/assessment/*') || request()->is('students/assessment/result/*'))
        @include('students.layouts.partials.subheader')
    @endif

</div>
<!-- main header-end -->
