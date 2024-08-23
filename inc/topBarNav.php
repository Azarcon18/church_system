<style>
  .navbar {
    position: relative;
    background-color: white; /* Set the background color of the navbar to white */
  }

  .navbar::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, #ff7f50, #1e90ff, #32cd32); /* Coral, DodgerBlue, LimeGreen */
    background-size: 600% 600%;
    animation: gradientBackground 10s ease infinite;
    z-index: -1;
  }

  @keyframes gradientBackground {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  .navbar-nav .nav-item .nav-link {
    color: black; 
  }

  .navbar-nav .nav-item .nav-link:hover, 
  .navbar-nav .nav-item .nav-link:active {
    background-color: rgba(0, 0, 0, 0.1); /* Slight dark overlay on hover */
    color: black;
  }

  .dropdown-menu {
    background-color: white;
    display: none;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
  }

  .dropdown-menu .dropdown-item {
    color: black; 
  }

  .dropdown-menu .dropdown-item:hover {
    background-color: #66a8ef; 
    color: white;
  }

  .nav-item.dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0);
  }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-seconda">
    <div class="container px-4 px-lg-5">
        <button class="navbar-toggler btn btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url ?>">
            <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" class="d-inline-white align-top" alt="" loading="lazy">
            <?php echo $_settings->info('short_name') ?>
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?php echo base_url ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?php echo base_url ?>?p=events">Events</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                        Topics
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php 
                        $cat_qry = $conn->query("SELECT * FROM topics WHERE status = 1");
                        while ($crow = $cat_qry->fetch_assoc()):
                        ?>
                        <li><a class="dropdown-item" href="<?php echo base_url ?>?p=articles&t=<?php echo md5($crow['id']) ?>"><?php echo $crow['name'] ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=schedule">Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=about">About Us</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle"
                         href="#" id="userDropdown" role="button" aria-expanded="false">
                            <img src="uploads/<?php echo htmlspecialchars($_SESSION['user_photo']); ?>" alt="User Photo" 
                            class="user-photo rounded-circle" style="width: 30px; height: 30px;">
                            <span class="user-name ms-2">Hi <?php echo htmlspecialchars($_SESSION['user_fullname']); ?>!</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" aria-current="page" href="<?php echo base_url ?>?p=profile">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary btn-sm">Login</a>
                <?php endif; ?>
                <button id="donation" class="btn btn-success btn-sm ms-3">Donate</button>
            </div>
        </div>
                </form>
    </div>
</nav>

<script>
  $(function(){
    $('#login-btn').click(function(){
      uni_modal("Login","login.php")
    });
    $('#donation').click(function(){
      uni_modal("Donate","donate.php")
    });
    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink')
    });
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if($('body').offset().top === 0)
          $('#mainNav').removeClass('navbar-shrink')
    });

    $('#search-form').submit(function(e){
      e.preventDefault();
      var sTxt = $('[name="search"]').val();
      if(sTxt !== '')
        location.href = './?p=search&search='+sTxt;
    });
  });

  function uni_modal(title, url) {
    // Your modal function implementation
  }
</script>
