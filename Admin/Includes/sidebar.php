<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="css/sidebar-modern.css" rel="stylesheet" type="text/css">


<!-- ===========================
     Sidebar (Modern Red Design)
=========================== -->

<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <!-- Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="img/School-logo.webp" alt="Logo" style="width:40px; border-radius:50%;">
    </div>
    <div class="sidebar-brand-text mx-3">IT STEP</div>
  </a>

  <hr class="sidebar-divider my-0">

  <!-- Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Managed</div>

  <!-- Manage Classes -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClass" aria-expanded="true">
      <i class="fas fa-chalkboard"></i>
      <span>Manage Classes</span>
    </a>
    <div id="collapseClass" class="collapse" data-parent="#accordionSidebar">
      <div class="collapse-inner">
        <a class="collapse-item" href="createClass.php">Create Class</a>
      </div>
    </div>
  </li>

  <!-- Manage Class Arms -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArms" aria-expanded="true">
      <i class="fas fa-code-branch"></i>
      <span>Manage Class Number</span>
    </a>
    <div id="collapseArms" class="collapse" data-parent="#accordionSidebar">
      <div class="collapse-inner">
        <a class="collapse-item" href="createClassArms.php">Create Class Room</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Teachers</div>

  <!-- Manage Teachers -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeachers" aria-expanded="true">
      <i class="fas fa-chalkboard-teacher"></i>
      <span>Manage Teachers</span>
    </a>
    <div id="collapseTeachers" class="collapse" data-parent="#accordionSidebar">
      <div class="collapse-inner">
        <a class="collapse-item" href="createClassTeacher.php">Create Class Teachers</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Students</div>

  <!-- Manage Students -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents" aria-expanded="true">
      <i class="fas fa-user-graduate"></i>
      <span>Manage Students</span>
    </a>
    <div id="collapseStudents" class="collapse" data-parent="#accordionSidebar">
      <div class="collapse-inner">
        <a class="collapse-item" href="createStudents.php">Create Students</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Session & Term</div>

  <!-- Manage Session & Term -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSession" aria-expanded="true">
      <i class="fa fa-calendar-alt"></i>
      <span>Manage Session & Term</span>
    </a>
    <div id="collapseSession" class="collapse" data-parent="#accordionSidebar">
      <div class="collapse-inner">
        <a class="collapse-item" href="createSessionTerm.php">Create Session & Term</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">
</ul>

<!-- ========== Sidebar CSS (Modern Red Theme) ========== -->
<style>
.sidebar {
  background: linear-gradient(180deg, #b71c1c 0%, #8b0000 100%) !important;
  color: #fff;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  font-weight: 500;
  box-shadow: 3px 0 10px rgba(0, 0, 0, 0.15);
}

.sidebar .sidebar-brand {
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
  border-radius: 0 20px 0 0;
  font-size: 1.3rem;
  font-weight: bold;
  padding: 15px;
  text-transform: uppercase;
  letter-spacing: 1px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.sidebar .sidebar-brand img {
  width: 40px;
  border-radius: 50%;
}

.sidebar .nav-item {
  margin: 6px 10px;
}

.sidebar .nav-link {
  color: #fff !important;
  font-size: 0.95rem;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 20px;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.sidebar .nav-link:hover {
  background: rgba(255, 255, 255, 0.15) !important;
  transform: translateX(5px);
  color: #fff !important;
}

.sidebar .nav-item.active .nav-link {
  background: rgba(255, 255, 255, 0.2);
  color: #fff !important;
  font-weight: 600;
}

.sidebar .collapse-inner {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  padding: 10px;
  margin: 5px 20px;
}

.sidebar .collapse-inner .collapse-item {
  color: #ffcccc;
  display: block;
  font-size: 0.9rem;
  padding: 6px 15px;
  border-radius: 6px;
  transition: all 0.3s;
}

.sidebar .collapse-inner .collapse-item:hover {
  background-color: #a31515;
  color: #fff;
}

.sidebar-divider {
  border-top: 1px solid rgba(255, 255, 255, 0.25) !important;
  margin: 1rem 0;
}

.sidebar-heading {
  color: #ffcccc !important;
  font-size: 0.8rem;
  text-transform: uppercase;
  padding-left: 20px;
  letter-spacing: 1px;
}

.sidebar i {
  font-size: 1.1rem;
}
</style>

