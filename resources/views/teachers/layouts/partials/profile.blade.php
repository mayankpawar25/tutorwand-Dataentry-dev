    <div class="header-right">
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
                    <h4>{{ Session::get('profile')['firstName'] . ' '. Session::get('profile')['lastName'] }}</h4>
                    <P class="text-disable">{{ Session::get('profile')['emailId'] }}</P>
                    
                    <hr>
                    <a href="{{ route('flush.cache') }}" class="btn btn-outline-primary mb-2">{{ __('teachers.signOut') }}</a>
                </div>
            </div>
        @php
            } else {
        @endphp
            <div>
                <a class="btn btn-outline-primary mt-2" href="{{ route('auth2') }}" style="box-shadow: none !important;">{{ __('teachers.login') }}</a>
            </div>
        @php
            }
        @endphp
    </div>

