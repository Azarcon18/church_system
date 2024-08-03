<?php
session_start(); // Make sure session is started

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'];

// Provide default values if session variables are not set
$user_fullname = isset($_SESSION['user_fullname']) ? htmlspecialchars($_SESSION['user_fullname']) : '';
$user_contact = isset($_SESSION['user_contact']) ? htmlspecialchars($_SESSION['user_contact']) : '';
$user_address = isset($_SESSION['user_address']) ? htmlspecialchars($_SESSION['user_address']) : '';
?>

<div class="container-fluid">
    <form action="" id="appointment-form">
        <input type="hidden" name="id">
        <input type="hidden" name="sched_type_id" value="<?php echo htmlspecialchars($_GET['sched_type_id']); ?>">
        
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fullname" class="control-label">Full Name</label>
                        <input type="text" name="fullname" id="fullname" class="form-control rounded-0" 
                               <?php if ($isLoggedIn): ?> 
                                   value="<?php echo $user_fullname; ?>" 
                                   readonly
                               <?php endif; ?>
                               required>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="control-label">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control rounded-0" 
                               <?php if ($isLoggedIn): ?> 
                                   value="<?php echo $user_contact; ?>" 
                                   
                               <?php endif; ?>
                               pattern="09[0-9]{9}" maxlength="11" required>
                        <small class="form-text text-muted">Format: 09xxxxxxxxx</small>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea name="address" id="address" class="form-control rounded-0" 
                                  <?php if ($isLoggedIn): ?> 
                                      
                                  <?php endif; ?>
                                  required>
                          <?php echo $user_address; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="schedule" class="control-label">Desired Schedule</label>
                        <input type="datetime-local" name="schedule" id="schedule" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="control-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control rounded-0" required></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!$isLoggedIn): ?>
            <div class="alert alert-danger mt-3">You need to be logged in to schedule an appointment.</div>
        <?php endif; ?>
        
        <!-- <button type="submit" class="btn btn-primary mt-3" <?//php if (!$isLoggedIn): ?> disabled <?//php endif; ?>>Submit</button> -->
    </form>
</div>

<script>
    $(function(){
        $('#appointment-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_appointment_req",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp === 'object' && resp.status === 'success') {
                        end_loader();
                        setTimeout(() => {
                            uni_modal('', 'success_msg.php');
                        }, 200);
                    } else if (resp.status === 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({ scrollTop: _this.closest('.container-fluid').offset().top }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });
    });
</script>
