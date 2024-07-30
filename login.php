<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php'); ?>
<body class="dark-mode">
<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif; ?>
<?php require_once('inc/topBarNav.php'); ?>
<style>
    #uni_modal .modal-content>.modal-footer, #uni_modal .modal-content>.modal-header {
        display: none;
    }
</style>
<div class="container-fluid mb-5 mt-2">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-4">
            <h3 class="text-center">Login</h3>
            <hr>
            <form id="user-login-frm" action="" method="post">
    <div class="form-group">
        <label for="email" class="control-label">Email</label>
        <input type="email" class="form-control form" name="email" required>
    </div>
    <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input type="password" class="form-control form" name="password" required>
    </div>
    <div class="row mb-4">
        <button type="submit" class="btn btn-primary float-end" name="login_btn">Login</button>
    </div>
    <div class="row">
        <a class="btn btn-success text-center" data-toggle="modal" data-target="#signupModal">Create Account</a>
    </div>
</form>

        </div>
    </div>
</div>

<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Create Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="signup-form" action="classes/register.php" method="POST">
                    <div class="form-group">
                        <label for="name" class="control-label">Full Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="user_name" class="control-label">Username</label>
                        <input type="text" class="form-control" name="user_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_no" class="control-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_no" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea class="form-control" name="address" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('inc/footer.php'); ?>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
    $(document).ready(function(){
        // Login
        $('#user-login-frm').submit(function(e){
            e.preventDefault();
            start_loader();
            if($('.err_msg').length > 0)
                $('.err_msg').remove();
            $.ajax({
                url: _base_url_+'classes/UserLogin.php?f=login_user',
                method: 'POST',
                data: $(this).serialize(),
                error: err=>{
                    console.log(err);
                },
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp);
                        if(resp.status == 'success'){
                            location.replace(_base_url_+'dashboard.php');
                        }else if(resp.status == 'incorrect'){
                            var _frm = $('#user-login-frm');
                            var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Incorrect email or password</div>";
                            _frm.prepend(_msg);
                            _frm.find('input').addClass('is-invalid');
                            $('[name="email"]').focus();
                        }
                        end_loader();
                    }
                }
            });
        });
    });
</script>

</body>
</html>
