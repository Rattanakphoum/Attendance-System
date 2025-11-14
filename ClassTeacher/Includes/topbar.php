<?php 
  $query = "SELECT * FROM tblclassteacher WHERE Id = ".$_SESSION['userId']."";
  $rs = $conn->query($query);
  $num = $rs->num_rows;
  $rows = $rs->fetch_assoc();
  $fullName = $rows['firstName']." ".$rows['lastName'];
?>
<nav class="navbar navbar-expand navbar-dark topbar mb-4 static-top" style="background: linear-gradient(90deg, #dc3545, #a71d2a); box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
  
  <!-- Sidebar Toggle -->
  <button id="sidebarToggleTop" class="btn btn-link text-white rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <!-- Optional Title or Spacer -->
  <div class="text-white font-weight-bold ml-3" style="font-size:1.2rem;"></div>

  <!-- Navbar Right -->
  <ul class="navbar-nav ml-auto">

    <!-- Search -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle text-white" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
        <form class="navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search..."
              aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-danger" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <div class="topbar-divider d-none d-sm-block bg-white"></div>

    <!-- User Info -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img class="img-profile rounded-circle border border-light" src="img/user-icn.png" style="max-width: 50px;">
        <span class="ml-2 d-none d-lg-inline small font-weight-bold">Welcome <?php echo $fullName;?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <!-- Optional Links -->
        <!-- <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a> -->
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="logout.php">
          <i class="fas fa-power-off fa-fw mr-2"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>

<style>
  /* Modern hover effects */
  .navbar .nav-link:hover {
    background-color: rgba(255,255,255,0.1);
    border-radius: 8px;
    transition: 0.3s;
  }

  .dropdown-menu a.dropdown-item:hover {
    background-color: #f8d7da;
    color: #a71d2a !important;
    transition: 0.2s;
  }

  .img-profile {
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  }
</style>
