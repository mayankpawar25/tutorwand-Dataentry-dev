<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $__env->make('admin.layout.partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <style>
            .sign-title>h2 {
                text-align: left;
            }
            .sign-cont {
                background: #fff;
                padding: 20px 25px;
                border: 1px solid #f3f2f1;
                width: 550px;
                height: auto;
                box-sizing: border-box;
                position: relative;
                border-radius: 8px;
            }

            .sign-section {
                background: linear-gradient(to right, #f3f2f1 0%, #ffffff 100%);
                box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.10), 0 0.9375rem 1.40625rem rgba(4, 9, 20, 0.10), 0 0.25rem 0.53125rem rgba(4, 9, 20, 0.20), 0 0.125rem 0.1875rem rgba(4, 9, 20, 0.10);
            }
        </style>
    </head>
    <body class="sign-section">
        <div class="container sign-cont animated zoomIn">
            <p class="text-danger"><?php echo e(session()->get('message')); ?></p>
            <div class="sign-title">
                <h2 class="teal-text">Login</h2>
            </div>
            <div class="row sign-row">
                <form class="col s12" id="reg-form" action="<?php echo e(route('admin.login.submit')); ?>" autocomplete="off" method="post">
                    <?php echo e(csrf_field()); ?>

                    <div class="row sign-row">
                        <div class="input-field col s12">
                            <input id="email" type="email" name="username" class="validate" value="" required autocomplete="off">
                            <label for="email">Email ID</label>
                        </div>
                    </div>
                    <div class="row sign-row">
                        <div class="input-field col s12">
                            <input type="password" class="validate" name="password" value="" required autocomplete="off">
                            <label>Password</label>
                        </div>
                    </div>
                    <div class="row sign-row">
                        <div class="input-field col s6">
                            <div class="sign-confirm">
                                <input type="checkbox" id="sign-confirm" />
                                <label for="sign-confirm">Remember</label>
                            </div>
                        </div>
                        <div class="input-field col s6">
                            <button class="btn btn-large btn-register waves-effect waves-light teal" type="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>
            <a title="Login" class="sign-btn btn-floating btn-large waves-effect waves-light teal">
                <i class="material-icons">perm_identity</i>
            </a>
        </div>

        <!-- Start Core Plugins
                =====================================================================-->
        <!-- jQuery -->
        <script src="<?php echo e(asset('assets/js/jquery-3.2.1.min.js')); ?>" type="text/javascript"></script>
        <!-- materialize  -->
        <script src="<?php echo e(asset('assets/plugins/materialize/js/materialize.min.js')); ?>" type="text/javascript"></script>
        <!-- End Core Plugins
                =====================================================================-->
    </body>
</html><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/login.blade.php ENDPATH**/ ?>