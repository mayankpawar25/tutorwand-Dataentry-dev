<!-- Sidebar -->

<div id="sidebar-wrapper" class="waves-effect" data-simplebar>

  <div class="slide-nav-logo">
      <a class="" href="<?php echo e(route('admin.dashboard')); ?>">
          <img class="logo" alt="Free test paper generator" src="https://tutorwand.com/images/tutorwand-logo.png">
      </a>

  </div>

  <div class="navbar-default sidebar" role="navigation" style="height: 70vh; overflow-y: auto">

      <div class="sidebar-nav navbar-collapse">

          <ul class="nav" id="side-menu">

              <li class="<?php if(request()->path() == 'admin/dashboard'): ?> active-link <?php endif; ?>">

                <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="material-icons">dashboard</i><?php echo e(__('admin.dashboard')); ?></a>

              </li>

              <li class="<?php if(request()->path() == 'admin/create/form'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.form')); ?>"><i class="material-icons">assignment_turned_in</i><?php echo e(__('admin.questionIngestion')); ?></a></li>

            <?php

                $allowedArray = ['Review (all status)', 'Review Screen(status except approved)'];

                $userRoleArr = array_map('trim',explode(',', session()->get('user_session')['role']['description']));

                $isAllowedArr = array_intersect($userRoleArr, $allowedArray);

                $adminAllowedArray = ['Dashboard', 'Review (all status)', 'Data Entry Edit'];

                $isAdminAllowedArr = array_intersect($userRoleArr, $adminAllowedArray);

                if(count($isAllowedArr) > 0) {

            ?>
                    
                    <li class="<?php if(request()->path() == 'admin/review/filter' || request()->path() == 'admin/review/question'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('review.filter')); ?>"><i class="material-icons">assignment_turned_in</i><?php echo e(__('admin.questionReview')); ?></a></li>

            <?php

                } 
                
                if(count($isAdminAllowedArr) > 0) {
            
            ?>
                
                    <li class="<?php if(request()->path() == 'admin/coupon'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.coupon')); ?>"><i class="material-icons">discount</i><?php echo e(__('admin.couponDashboard')); ?></a></li>
                    
                    <li class="<?php if(request()->path() == 'admin/analytics'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.analytics')); ?>"><i class="material-icons">equalizer</i><?php echo e(__('admin.analytics')); ?></a></li>

                    <li class="<?php if(request()->path() == 'admin/demorequest'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.demorequest')); ?>"><i class="material-icons">event</i><?php echo e(__('admin.demoRequest')); ?></a></li>

                    <li class="<?php if(request()->path() == 'admin/demoleads'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.demoleads')); ?>"><i class="material-icons">list</i><?php echo e(__('admin.demoLeads')); ?></a></li>

                    <li class="<?php if(request()->path() == 'admin/bulkrequest'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.bulkrequest')); ?>"><i class="material-icons">event</i><?php echo e(__('admin.bulkRequest')); ?></a></li>

                    <li class="<?php if(request()->path() == 'admin/contact'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.contact')); ?>"><i class="material-icons">contact_support</i><?php echo e(__('admin.contact')); ?></a></li>

                    <li class="<?php if(request()->path() == 'admin/subscription'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.subscription')); ?>"><i class="material-icons">rocket_launch</i><?php echo e(__('admin.subscription')); ?></a></li>

                    <li class="<?php if(request()->path() == 'admin/poll'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.poll')); ?>"><i class="material-icons">poll</i><?php echo e(__('admin.poll')); ?></a></li>

                    <li class="<?php if(request()->path() == 'admin/competition'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.competition')); ?>"><i class="material-icons">show_chart</i><?php echo e(__('admin.competition')); ?></a></li>

                    <li class="<?php if(request()->path() == 'admin/planrequest'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.planrequest')); ?>"><i class="material-icons">upgrade</i><?php echo e(__('admin.planRequest')); ?></a></li>

                    <li class="<?php if(request()->path() == 'admin/competition/dashboard'): ?> active-link <?php endif; ?>"><a href="<?php echo e(route('admin.competition.dashboard')); ?>"><i class="material-icons">dashboard</i><?php echo e(__('admin.competitionDashboard')); ?></a></li>

            <?php
                }
            ?>

          </ul>

          <!-- ./sidebar-nav -->

      </div>

      <!-- ./sidebar -->

  </div>

  <!-- ./sidebar-nav -->

</div><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/layout/partials/sidenavbar.blade.php ENDPATH**/ ?>