<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(180deg, #9e0918ff, #ad0616ff);">
  
  <!-- Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="img/logo/School-logo.webp" style="max-width: 40px;">
    </div>
    <div class="sidebar-brand-text mx-3 text-white font-weight-bold">AMS</div>
  </a>

  <hr class="sidebar-divider my-0 bg-light">

  <!-- Dashboard -->
  <li class="nav-item active">
    <a class="nav-link text-white" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider bg-light">

  <!-- Students -->
  <div class="sidebar-heading text-white">Students</div>
  <li class="nav-item">
    <a class="nav-link collapsed text-white" href="#" data-toggle="collapse" data-target="#collapseStudents"
      aria-expanded="true" aria-controls="collapseStudents">
      <i class="fas fa-user-graduate"></i>
      <span>Manage Students</span>
    </a>
    <div id="collapseStudents" class="collapse" aria-labelledby="headingStudents" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Students</h6>
        <a class="collapse-item text-danger" href="viewStudents.php">View Students</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider bg-light">

  <!-- Attendance -->
  <div class="sidebar-heading text-white">Attendance</div>
  <li class="nav-item">
    <a class="nav-link collapsed text-white" href="#" data-toggle="collapse" data-target="#collapseAttendance"
      aria-expanded="true" aria-controls="collapseAttendance">
      <i class="fa fa-calendar-alt"></i>
      <span>Manage Attendance</span>
    </a>
    <div id="collapseAttendance" class="collapse" aria-labelledby="headingAttendance" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header text-danger">Manage Attendance</h6>
        <a class="collapse-item text-danger" href="takeAttendance.php">Take Attendance</a>
        <a class="collapse-item text-danger" href="viewAttendance.php">View Class Attendance</a>
        <a class="collapse-item text-danger" href="viewStudentAttendance.php">View Student Attendance</a>
        <a class="collapse-item text-danger" href="downloadRecord.php">Today's Report (xls)</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider bg-light">

</ul>

<style>
  /* Sidebar hover effect */
  .sidebar .nav-item .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-left: 4px solid #ff4d4d;
    transition: all 0.3s;
  }

  .sidebar .collapse-inner .collapse-item:hover {
    color: #dc3545 !important;
    font-weight: 600;
    transition: all 0.3s;
  }

  .sidebar .sidebar-heading {
    font-size: 0.85rem;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding-left: 1.25rem;
  }

  .sidebar .nav-item.active .nav-link {
    background-color: rgba(255, 255, 255, 0.2);
    border-left: 4px solid #ff4d4d;
  }
</style>
