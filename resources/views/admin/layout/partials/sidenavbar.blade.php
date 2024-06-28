<!-- Sidebar -->

<div id="sidebar-wrapper" class="waves-effect" data-simplebar>

  <div class="slide-nav-logo">
      <a class="" href="{{ route('admin.dashboard') }}">
          <img class="logo" alt="Free test paper generator" src="https://tutorwand.com/images/tutorwand-logo.png">
      </a>

  </div>

  <div class="navbar-default sidebar" role="navigation" style="height: 70vh; overflow-y: auto">

      <div class="sidebar-nav navbar-collapse">

          <ul class="nav" id="side-menu">

              <li class="@if(request()->path() == 'admin/dashboard') active-link @endif">

                <a href="{{ route('admin.dashboard') }}"><i class="material-icons">dashboard</i>{{ __('admin.dashboard') }}</a>

              </li>

              <li class="@if(request()->path() == 'admin/create/form') active-link @endif"><a href="{{ route('admin.form') }}"><i class="material-icons">assignment_turned_in</i>{{ __('admin.questionIngestion') }}</a></li>

            @php

                $allowedArray = ['Review (all status)', 'Review Screen(status except approved)'];

                $userRoleArr = array_map('trim',explode(',', session()->get('user_session')['role']['description']));

                $isAllowedArr = array_intersect($userRoleArr, $allowedArray);

                $adminAllowedArray = ['Dashboard', 'Review (all status)', 'Data Entry Edit'];

                $isAdminAllowedArr = array_intersect($userRoleArr, $adminAllowedArray);

                if(count($isAllowedArr) > 0) {

            @endphp
                    
                    <li class="@if(request()->path() == 'admin/review/filter' || request()->path() == 'admin/review/question') active-link @endif"><a href="{{ route('review.filter') }}"><i class="material-icons">assignment_turned_in</i>{{ __('admin.questionReview') }}</a></li>

            @php

                } 
                
                if(count($isAdminAllowedArr) > 0) {
            
            @endphp
                
                    <li class="@if(request()->path() == 'admin/coupon') active-link @endif"><a href="{{ route('admin.coupon') }}"><i class="material-icons">discount</i>{{ __('admin.couponDashboard') }}</a></li>
                    
                    <li class="@if(request()->path() == 'admin/analytics') active-link @endif"><a href="{{ route('admin.analytics') }}"><i class="material-icons">equalizer</i>{{ __('admin.analytics') }}</a></li>

                    <li class="@if(request()->path() == 'admin/demorequest') active-link @endif"><a href="{{ route('admin.demorequest') }}"><i class="material-icons">event</i>{{ __('admin.demoRequest') }}</a></li>

                    <li class="@if(request()->path() == 'admin/demoleads') active-link @endif"><a href="{{ route('admin.demoleads') }}"><i class="material-icons">list</i>{{ __('admin.demoLeads') }}</a></li>

                    <li class="@if(request()->path() == 'admin/bulkrequest') active-link @endif"><a href="{{ route('admin.bulkrequest') }}"><i class="material-icons">event</i>{{ __('admin.bulkRequest') }}</a></li>

                    <li class="@if(request()->path() == 'admin/contact') active-link @endif"><a href="{{ route('admin.contact') }}"><i class="material-icons">contact_support</i>{{ __('admin.contact') }}</a></li>

                    <li class="@if(request()->path() == 'admin/subscription') active-link @endif"><a href="{{ route('admin.subscription') }}"><i class="material-icons">rocket_launch</i>{{ __('admin.subscription') }}</a></li>

                    <li class="@if(request()->path() == 'admin/poll') active-link @endif"><a href="{{ route('admin.poll') }}"><i class="material-icons">poll</i>{{ __('admin.poll') }}</a></li>

                    <li class="@if(request()->path() == 'admin/competition') active-link @endif"><a href="{{ route('admin.competition') }}"><i class="material-icons">show_chart</i>{{ __('admin.competition') }}</a></li>

                    <li class="@if(request()->path() == 'admin/planrequest') active-link @endif"><a href="{{ route('admin.planrequest') }}"><i class="material-icons">upgrade</i>{{ __('admin.planRequest') }}</a></li>

                    <li class="@if(request()->path() == 'admin/competition/dashboard') active-link @endif"><a href="{{ route('admin.competition.dashboard') }}"><i class="material-icons">dashboard</i>{{ __('admin.competitionDashboard') }}</a></li>

            @php
                }
            @endphp

          </ul>

          <!-- ./sidebar-nav -->

      </div>

      <!-- ./sidebar -->

  </div>

  <!-- ./sidebar-nav -->

</div>