<?php 
require_once('db_connect.php'); // Include your database connection file
$title = "Schedule Request";
$sub_title = "";
?>

<!-- Header-->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo $title ?></h1>
        </div>
    </div>
</header>

<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <p><i>Select the type of Appointment you desire to create a schedule request.</i></p>
        <hr>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search Here.." aria-label="Search Here.." aria-describedby="basic-addon2" id="search">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gx-2 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-3 justify-content-center" id='sched-type-list'>
            <?php 
                $categories = $conn->query("SELECT * FROM `schedule_type` where `status` = 1 order by `sched_type` asc ");
                while($row = $categories->fetch_assoc()):
                    foreach($row as $k=> $v){
                        $row[$k] = trim(stripslashes($v));
                    }
                    $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
            ?>
            <div class="col mb-6 mb-2 text-light item">
                <a href="javascript:void(0)" class="card sched-item text-decoration-none" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['sched_type'] ?>">
                    <div class="card-body p-4">
                        <div class="">
                            <!-- Product name-->
                            <h5 class="fw-bolder border-bottom border-primary"><?php echo $row['sched_type'] ?></h5>
                        </div>
                        <p class="m-0 truncate"><?php echo $row['description'] ?></p>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
            <center id="noResult" style="display:none"><b><i>No Result</i></b></center>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header-->
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Create an Appointment Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body-->
            <div class="modal-body">
                <form id="appointment-form">
                    <input type="hidden" name="sched_type_id" id="sched_type_id">
                    <div class="mb-3">
                        <label for="appointment-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="appointment-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointment-description" class="form-label">Description</label>
                        <textarea class="form-control" id="appointment-description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="appointment-date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="appointment-date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointment-time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="appointment-time" name="time" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointment-location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="appointment-location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointment-participants" class="form-label">Participants</label>
                        <input type="text" class="form-control" id="appointment-participants" name="participants" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Glass effect styles */
    .sched-item {
        background: rgba(255, 255, 255, 0.1); /* Slightly transparent white background */
        background-color: #21252970; /* Darker color on hover */
        color: black; /* Default text color */
        border-radius: 10px; /* Rounded corners */
        backdrop-filter: blur(10px); /* Apply the blur effect */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add subtle shadow for better depth */
        transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for background color and shadow */
        position: relative; /* Ensure proper positioning for touch effect */
    }

    .sched-item:hover,
    .sched-item:active {
        background-color: #72aee6; /* Darker color on hover */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Enhance shadow on hover */
    }

    .sched-item:active {
        background-color: #5a8fd4; /* Slightly darker color on touch */
        transform: scale(0.98); /* Slightly shrink the card on touch */
    }

    /* Additional touch feedback effect */
    .sched-item:active::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2); /* Light overlay for touch feedback */
        border-radius: 10px;
        pointer-events: none; /* Prevent the overlay from interfering with click events */
        z-index: 1; /* Ensure the overlay is on top */
    }

    /* Override text color within card */
    .sched-item .card-body h5,
    .sched-item .card-body p {
        color: black; /* Override text color within card */
    }

    .sched-item .card-body {
        text-align: center; /* Center text in the card body */
    }

    .sched-item .card-body h5 {
        margin: 0; /* Remove default margin */
    }

    /* Fade-in and fade-out effects */
    .fade-in {
        opacity: 0;
        transition: opacity 0.5s ease-in;
    }

    .fade-in.visible {
        opacity: 1;
    }

    .fade-out {
        opacity: 1;
        transition: opacity 0.5s ease-out;
    }

    .fade-out.hidden {
        opacity: 0;
    }
</style>

<script>
    $(function(){
        $('.sched-item').click(function(){
            var name = $(this).attr('data-name');
            var id = $(this).attr('data-id');
            $('#sched_type_id').val(id);
            $('#appointmentModalLabel').text("Create an Appointment Request for " + name);
            $('#appointmentModal').modal('show');
        });
        $('#search').on('input',function(){
            var _txt = $(this).val().toLowerCase();
            $('#sched-type-list .item').each(function(){
                var _contain = $(this).text().toLowerCase().trim();
                if(_contain.includes(_txt) === true){
                    $(this).removeClass('fade-out').addClass('fade-in').show();
                }else{
                    $(this).removeClass('fade-in').addClass('fade-out').hide();
                }
            });
            check_result();
        });
    });

    function check_result(){
        if($('#sched-type-list .item:visible').length <= 0){
            if($('#noResult').hasClass('fade-out')){
                $('#noResult').removeClass('fade-out').addClass('fade-in').show();
            }
        }else{
            if($('#noResult').hasClass('fade-in')){
                $('#noResult').removeClass('fade-in').addClass('fade-out').hide();
            }
        }
    }

    $('#appointment-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'save_appointment.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response){
                if(response == 1){
                    alert('Appointment request has been successfully created.');
                    location.reload();
                } else {
                    alert('Failed to create appointment request.');
                }
            }
        });
    });
</script>
