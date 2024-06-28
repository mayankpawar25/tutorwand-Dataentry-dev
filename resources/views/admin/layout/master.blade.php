<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.layout.partials.head')
  </head>

  <body class="app sidebar-mini data-injetion">
    <div id="wrapper" class="@if(request()->path() == 'admin/dashboard') active @endif">

      @includeif('admin.layout.partials.topnavbar')

      @includeif('admin.layout.partials.sidenavbar')

      @yield('content')

    </div>

    @includeif('admin.layout.partials.scripts')

    @yield('onPageJs')

  </body>

</html>
