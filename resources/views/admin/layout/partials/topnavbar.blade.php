<!--navbar top-->


<nav class="navbar navbar-inverse fixed-top">


  <!-- Logo -->


  <a id="menu-toggle">


      <i class="material-icons">view_headline</i>


  </a>


  <h3>{{ __('admin.dashboard') }} 


    @if(strpos(config('constants.ExtAPIUrl'), 'magicband-dev-api') !== false )


      {{ __('admin.test') }}


    @endif


  </h3>


  <div class="navbar-custom-menu hidden-xs">





      <ul class="navbar navbar-right">





          <!--user profile-->


          <li class="dropdown">


              <a class='dropdown-button user-pro' href='#' data-activates='dropdown-user'>


                  <img src="{{ asset('assets/images/admin/avatar5.png') }}" class="img-circle" height="45" width="50" alt="User Image">


              </a>


              <ul id='dropdown-user' class='dropdown-content dropdown-menu-right'>


                  <li>


                      <a href="#!"><i class="material-icons">perm_identity</i>{{ __('admin.viewProfile') }}</a>


                  </li>


                  <li>


                      <a href="#!"><i class="material-icons">settings</i>{{ __('admin.settings') }}</a>


                  </li>


                  <li>


                      <a href="{{ route('admin.logout') }}"><i class="material-icons">lock</i>{{ __('admin.logout') }}</a>


                  </li>


              </ul>


          </li>


          <!-- /.user profile -->


      </ul>

        <input type="hidden" name="contentProviderId" id="contentProviderId" value="{{__(Session::get('user_session')['contentProviderId'])}}"/>
  </div>


</nav>