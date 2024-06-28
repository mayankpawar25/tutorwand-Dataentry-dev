<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $__env->make('admin.layout.partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </head>

  <body class="app sidebar-mini data-injetion">
    <div id="wrapper" class="<?php if(request()->path() == 'admin/dashboard'): ?> active <?php endif; ?>">

      <?php if ($__env->exists('admin.layout.partials.topnavbar')) echo $__env->make('admin.layout.partials.topnavbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <?php if ($__env->exists('admin.layout.partials.sidenavbar')) echo $__env->make('admin.layout.partials.sidenavbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <?php echo $__env->yieldContent('content'); ?>

    </div>

    <?php if ($__env->exists('admin.layout.partials.scripts')) echo $__env->make('admin.layout.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('onPageJs'); ?>

  </body>

</html>
<?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/layout/master.blade.php ENDPATH**/ ?>