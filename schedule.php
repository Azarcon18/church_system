<?php 
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
                $categories = $conn->query("SELECT * FROM `schedule_type` WHERE `status` = 1 ORDER BY `sched_type` ASC ");
                while($row = $categories->fetch_assoc()):
                    $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
            ?>
            <div class="col mb-6 mb-2 text-light item">
                <a href="javascript:void(0)" class="card sched-item text-decoration-none" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['sched_type'] ?>">
                    <div class="card-body p-4">
                        <div class="">
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

<style>
    .sched-item {
        background: rgba(255, 255, 255, 0.1); 
        background-color: #21252970; 
        color: black; 
        border-radius: 10px; 
        backdrop-filter: blur(10px); 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        transition: background-color 0.3s ease, box-shadow 0.3s ease; 
        position: relative;
    }

    .sched-item:hover,
    .sched-item:active {
        background-color: #72aee6; 
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); 
    }

    .sched-item:active {
        background-color: #5a8fd4; 
        transform: scale(0.98); 
    }

    .sched-item:active::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2); 
        border-radius: 10px;
        pointer-events: none; 
        z-index: 1; 
    }

    .sched-item .card-body h5,
    .sched-item .card-body p {
        color: black; 
    }

    .sched-item .card-body {
        text-align: center; 
    }

    .sched-item .card-body h5 {
        margin: 0; 
    }

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
            uni_modal("Create an Appointment Request for " + name, "create_appointment.php?sched_type_id=" + id, "mid-large");
        });
        $('#search').on('input', function(){
            var _txt = $(this).val().toLowerCase();
            $('#sched-type-list .item').each(function(){
                var _contain = $(this).text().toLowerCase().trim();
                if(_contain.includes(_txt)){
                    $(this).removeClass('fade-out').addClass('fade-in').show();
                } else {
                    $(this).removeClass('fade-in').addClass('fade-out').hide();
                }
            });
            check_result();
        });
    });

    function check_result(){
        if($('#sched-type-list .item:visible').length <= 0){
            $('#noResult').removeClass('fade-out').addClass('fade-in').show();
        } else {
            $('#noResult').removeClass('fade-in').addClass('fade-out').hide();
        }
    }
</script>
