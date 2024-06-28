 <div class="main-header">
     <div class="header-bg-strip">
            <div class="header-left">
                <span  class="float-left d-none d-lg-block d-md-block">{!! getEnvironment() !!}</span>
                <span  class="mob-logo d-block d-lg-none d-md-none">
                <img src="{{ asset('assets/images/students/logo-sm.svg')}}" class="small-logo">
                </span>
            </div>
         @include('teachers.layouts.partials.profile')
     </div>
     <!-- container-fluid end -->
 </div>
 <!-- main header-end -->