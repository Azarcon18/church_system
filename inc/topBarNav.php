<style>
  .navbar {
    background: linear-gradient(90deg, #ff7f50, #1e90ff, #32cd32); /* Coral, DodgerBlue, LimeGreen */
    background-size: 600% 600%;
    animation: gradientBackground 10s ease infinite;
  }

  @keyframes gradientBackground {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  .navbar-nav .nav-item .nav-link {
    color: white; 
  }

  .navbar-nav .nav-item .nav-link:hover, 
  .navbar-nav .nav-item .nav-link:active {
    background-color: rgba(0, 0, 0, 0.1); /* Slight dark overlay on hover */
    color: white;
  }

  .dropdown-menu {
    background-color: white;
    display: none;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
  }

  .dropdown-menu .dropdown-item {
    color: white; 
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

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container px-4 px-lg-5">
    <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <a class="navbar-brand" href="<?php echo base_url ?>">
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
      <?php echo $_settings->info('short_name') ?>
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item"><a class="nav-link" aria-current="page" href="<?php echo base_url ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link" aria-current="page" href="<?php echo base_url ?>?p=events">Events</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" aria-current="page" href="<?php echo base_url ?>?p=view_topics">Topics</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php 
              $cat_qry = $conn->query("SELECT * FROM topics where status = 1 ");
              while($crow = $cat_qry->fetch_assoc()):
            ?>
            <a class="dropdown-item" href="<?php echo base_url ?>?p=articles&t=<?php echo md5($crow['id']) ?>"><?php echo $crow['name'] ?></a>
            <?php endwhile; ?>
          </div>
        </li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=schedule">Schedule</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=about">About Us</a></li>
      </ul>
      <div class="d-flex align-items-center"></div>
    </div>
    <form class="form-inline ml-4 mr-2 pl-2" id="search-form">
      <div class="input-group">
        <input class="form-control form-control-sm form" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>" aria-describedby="button-addon2">
        <div class="input-group-append">
          <button class="btn btn-outline-success btn-sm m-0" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
        </div>
      </div>
    </form>
  </div>
</nav>

<script>
  $(function(){
    $('#login-btn').click(function(){
      uni_modal("","login.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if($('body').offset.top == 0)
          $('#mainNav').removeClass('navbar-shrink')
    })

    $('#search-form').submit(function(e){
      e.preventDefault()
      var sTxt = $('[name="search"]').val()
      if(sTxt != '')
        location.href = './?p=search&search='+sTxt;
    })
    $('#donation').click(function(){
      uni_modal('Donation','donate.php')
    })
  })
</script>
