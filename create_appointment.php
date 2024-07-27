<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Appointment Form</title>
</head>
<body>
    <div class="container-fluid">
        <form action="" id="appointment-form">
            <input type="hidden" name="id">
            <input type="hidden" name="sched_type_id" value="<?php echo $_GET['sched_type_id'] ?>">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullname" class="control-label"><i class="fas fa-user"></i> Full Name</label>
                            <input type="text" name="fullname" id="fullname" class="form-control rounded-0" required>
                        </div>
                        <div class="form-group">
                            <label for="contact" class="control-label"><i class="fas fa-phone"></i> Contact</label>
                            <input type="text" name="contact" id="contact" class="form-control rounded-0" required maxlength="11" pattern="\d{11}" title="Please enter exactly 11 digits">
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label"><i class="fas fa-map-marker-alt"></i> Address</label>
                            <textarea type="text" name="address" id="address" class="form-control rounded-0" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="schedule" class="control-label"><i class="fas fa-calendar-alt"></i> Desired Schedule</label>
                            <input type="datetime-local" name="schedule" id="schedule" class="form-control rounded-0" required>
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="control-label"><i class="fas fa-comments"></i> Remarks</label>
                            <textarea type="text" name="remarks" id="remarks" class="form-control rounded-0" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function(){
            $('#appointment-form').submit(function(e){
                e.preventDefault();
                var _this = $(this);
                $('.err-msg').remove();

                // Get the current date and time
                var currentDate = new Date();
                // Get the selected date and time from the input
                var selectedDate = new Date($('#schedule').val());

                // Check if the selected date is in the past
                if (selectedDate < currentDate) {
                    var el = $('<div>');
                    el.addClass("alert alert-danger err-msg").text("The desired schedule cannot be in the past.");
                    _this.prepend(el);
                    el.show('slow');
                    $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                    return;
                }

                if (!_this[0].checkValidity()) {
                    _this[0].reportValidity();
                    return;
                }

                $.ajax({
                    url: _base_url_+"classes/Master.php?f=save_appointment_req",
                    data: new FormData(_this[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    dataType: 'json',
                    error: err => {
                        console.log(err);
                        alert("An error occurred");
                    },
                    success: function(resp){
                        if (typeof resp == 'object' && resp.status == 'success'){
                            setTimeout(() => {
                                uni_modal('', 'success_msg.php');
                            }, 200);
                        } else if (resp.status == 'failed' && !!resp.msg){
                            var el = $('<div>');
                            el.addClass("alert alert-danger err-msg").text(resp.msg);
                            _this.prepend(el);
                            el.show('slow');
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                        } else {
                            alert("An error occurred");
                            console.log(resp);
                        }
                    }
                });
            });

            // Validate the contact input
            $('#contact').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 11) {
                    this.value = this.value.slice(0, 11);
                }
            });
        });
    </script>
</body>
</html>
