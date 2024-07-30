
<script>
    var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-navy">
    <div class="container px-4 px-lg-5">
        <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url ?>">
            <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            <?php echo $_settings->info('short_name') ?>
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?php echo base_url ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?php echo base_url ?>?p=events">Events</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link" aria-current="page" href="<?php echo base_url ?>?p=view_topics">Topics</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php 
                        $cat_qry = $conn->query("SELECT * FROM topics WHERE status = 1");
                        while ($crow = $cat_qry->fetch_assoc()):
                        ?>
                        <a class="dropdown-item" href="<?php echo base_url ?>?p=articles&t=<?php echo md5($crow['id']) ?>"><?php echo $crow['name'] ?></a>
                        <?php endwhile; ?>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=schedule">Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=about">About Us</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                  <li class="nav-item">
                      <div class="btn-group nav-link">
                            <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
                              <span><img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="User Image"></span>
                              <span class="ml-3"><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item" href="<?php echo base_url.'admin/?page=user' ?>"><span class="fa fa-user"></span> My Account</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?php echo base_url.'/classes/Login.php?f=logout' ?>"><span class="fas fa-sign-out-alt"></span> Logout</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                      
                    </li>
                <?php else: ?>
                <a href="login.php" class="btn btn-primary btn-sm">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<style>
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
    }
</style>
<script>
    $(function() {
        $('#login-btn').click(function() {
            uni_modal("", "login.php")
        })
        $('#navbarResponsive').on('show.bs.collapse', function() {
            $('#mainNav').addClass('navbar-shrink')
        })
        $('#navbarResponsive').on('hidden.bs.collapse', function() {
            if ($('body').offset.top == 0)
                $('#mainNav').removeClass('navbar-shrink')
        })
        $('#search-form').submit(function(e) {
            e.preventDefault()
            var sTxt = $('[name="search"]').val()
            if (sTxt != '')
                location.href = './?p=search&search=' + sTxt;
        })
        $('#donation').click(function() {
            uni_modal('Donation', 'donate.php')
        })
    })
</script>
