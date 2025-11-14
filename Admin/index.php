<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT tblclass.className,tblclassarms.classArmName 
    FROM tblclassteacher
    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    WHERE tblclassteacher.Id = '$_SESSION[userId]'";
    
$rs = $conn->query($query);
$num = $rs->num_rows;
$rrw = $rs->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/School-logo.webp" rel="icon">
  <title>Modern Dashboard</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Icons & Bootstrap -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
      color: #333;
    }

    h1, .breadcrumb-item a {
      color: #e63946;
    }

    .breadcrumb {
      background: none;
    }

    .card {
      border: none;
      border-radius: 18px;
      box-shadow: 0 6px 20px rgba(230, 57, 70, 0.15);
      transition: all 0.3s ease;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 25px rgba(230, 57, 70, 0.25);
    }

    .card-body {
      padding: 1.5rem;
    }

    .text-xs {
      font-size: 0.85rem;
      font-weight: 600;
      color: #e63946;
      letter-spacing: 1px;
    }

    .font-weight-bold.text-gray-800 {
      color: #d00000 !important;
    }

    .col-auto i {
      color: #e63946 !important;
      background: rgba(230, 57, 70, 0.1);
      padding: 15px;
      border-radius: 12px;
    }

    .navbar, .topbar {
      background-color: #e63946 !important;
      color: #fff !important;
    }

    .topbar .nav-link, .topbar .navbar-brand {
      color: white !important;
    }

    footer {
      background-color: #fff;
      border-top: 2px solid #e63946;
      text-align: center;
      padding: 1rem 0;
      font-size: 0.9rem;
      color: #555;
    }

    .scroll-to-top {
      background-color: #e63946;
    }

    .scroll-to-top:hover {
      background-color: #b81d2a;
    }

    @media (max-width: 768px) {
      h1.h3 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "Includes/sidebar.php";?>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php";?>

        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0">Administrator Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-4">

            <!-- Students -->
            <?php 
              $query1=mysqli_query($conn,"SELECT * from tblstudents");                       
              $students = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="text-xs text-uppercase mb-1">Students</div>
                      <div class="h5 font-weight-bold text-gray-800"><?php echo $students;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Classes -->
            <?php 
              $query1=mysqli_query($conn,"SELECT * from tblclass");                       
              $class = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="text-xs text-uppercase mb-1">Classes</div>
                      <div class="h5 font-weight-bold text-gray-800"><?php echo $class;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chalkboard fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Class Arms -->
            <?php 
              $query1=mysqli_query($conn,"SELECT * from tblclassarms");                       
              $classArms = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="text-xs text-uppercase mb-1">Class Arms</div>
                      <div class="h5 font-weight-bold text-gray-800"><?php echo $classArms;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-code-branch fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Attendance -->
            <?php 
              $query1=mysqli_query($conn,"SELECT * from tblattendance");                       
              $totAttendance = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="text-xs text-uppercase mb-1">Total Attendance</div>
                      <div class="h5 font-weight-bold text-gray-800"><?php echo $totAttendance;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <?php include 'includes/footer.php';?>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
