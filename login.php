<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>
<div class="container-fluid">
    
    <div class="row">
    <h3 class="float-right">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </h3>
        <div class="col-lg-12">
            <h3 class="text-center">Login</h3>
            <hr>
            <form action="" id="login-form">
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input type="email" class="form-control form" name="email" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form" name="password" required>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <a href="javascript:void()" id="create_account">Create Account</a>
                    <button class="btn btn-primary btn-flat">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
   $(function(){
    // When the "Create Account" link is clicked
    $('#create_account').click(function(){
        // This should open a modal with the registration form
        uni_modal("Create Account","registration.php","mid-large");
    });

    // When the login form is submitted
    $('#login-form').submit(function(e){
        e.preventDefault(); // Prevent the default form submission
        start_loader(); // Start the loader animation

        // Remove any previous error messages
        if($('.err-msg').length > 0)
            $('.err-msg').remove();

        // Send the form data to the server
        $.ajax({
            url: _base_url_ + "classes/Login.php?f=login_user",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            error: function(err){
                // Handle any AJAX errors
                console.log(err);
                alert_toast("An error occurred",'error');
                end_loader();
            },
            success: function(resp){
                // Handle the response from the server
                if(typeof resp == 'object' && resp.status == 'success'){
                    alert_toast("Login Successfully",'success');
                    setTimeout(function(){
                        location.reload(); // Reload the page
                    },2000);
                } else if(resp.status == 'incorrect'){
                    // Show an error message for incorrect credentials
                    var _err_el = $('<div>');
                    _err_el.addClass("alert alert-danger err-msg").text("Incorrect Credentials.");
                    $('#login-form').prepend(_err_el);
                    end_loader();
                } else {
                    // Handle any other server responses
                    console.log(resp);
                    alert_toast("An error occurred",'error');
                    end_loader();
                }
            }
        });
    });
});
 
</script>