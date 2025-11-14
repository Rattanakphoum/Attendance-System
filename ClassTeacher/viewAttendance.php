<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Class Attendance</title>
  <link href="img/School-logo.webp" rel="icon">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <style>
    body { background-color: #f8f9fa; }

    /* Card header modern red theme */
    .card-header {
      background: linear-gradient(90deg, #dc3545, #a71d2a);
      color: #fff;
      font-weight: bold;
      font-size: 1rem;
      border-radius: 0.5rem 0.5rem 0 0;
    }

    /* Table headers and hover effect */
    table.dataTable thead {
      background: #dc3545;
      color: #fff;
    }
    table.table-hover tbody tr:hover {
      background-color: #f5c6cb !important;
    }

    /* Buttons modern red */
    .btn-primary {
      background: #dc3545;
      border: none;
      border-radius: 6px;
    }
    .btn-primary:hover {
      background: #a71d2a;
    }

    /* Breadcrumb red theme */
    .breadcrumb-item a { color: #dc3545; }
    .breadcrumb-item.active { color: #a71d2a; }

    /* Card shadow */
    .card { box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 12px; }

    /* Attendance status colors */
    .status-present { background-color: #28a745; color: #fff; font-weight: bold; text-align:center; }
    .status-absent { background-color: #dc3545; color: #fff; font-weight: bold; text-align:center; }
  </style>
</head>

<body id="page-top">
<div id="wrapper">
  <!-- Sidebar -->
  <?php include "Includes/sidebar.php";?>
  <!-- Sidebar -->

  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
      <!-- TopBar -->
      <?php include "Includes/topbar.php";?>
      <!-- Topbar -->

      <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">View Class Attendance</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Class Attendance</li>
          </ol>
        </div>

        <!-- Select Date Form -->
        <div class="row">
          <div class="col-lg-6">
            <div class="card mb-4">
              <div class="card-header">Select Date to View Attendance</div>
              <div class="card-body">
                <form method="post">
                  <div class="form-group">
                    <label>Select Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="dateTaken" required>
                  </div>
                  <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Attendance Table -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="card-header">Class Attendance</div>
              <div class="table-responsive p-3">
                <table class="table table-hover table-striped table-bordered" id="dataTableHover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Other Name</th>
                      <th>Admission No</th>
                      <th>Class</th>
                      <th>Class Room</th>
                      <th>Session</th>
                      <th>Term</th>
                      <th>Status</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  if(isset($_POST['view'])){
                      $dateTaken = $_POST['dateTaken'];
                      $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblclass.className,
                                tblclassarms.classArmName, tblsessionterm.sessionName, tblterm.termName,
                                tblstudents.firstName, tblstudents.lastName, tblstudents.otherName, tblstudents.admissionNumber
                                FROM tblattendance
                                INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                                INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                                INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                                INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                                INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                                WHERE tblattendance.dateTimeTaken = '$dateTaken'
                                AND tblattendance.classId = '$_SESSION[classId]'
                                AND tblattendance.classArmId = '$_SESSION[classArmId]'";
                      $rs = $conn->query($query);
                      $sn = 0;
                      if($rs->num_rows > 0){
                        while($rows = $rs->fetch_assoc()){
                          $sn++;
                          $statusClass = $rows['status'] == '1' ? 'status-present' : 'status-absent';
                          $statusText = $rows['status'] == '1' ? 'Present' : 'Absent';
                          echo "<tr>
                                  <td>{$sn}</td>
                                  <td>{$rows['firstName']}</td>
                                  <td>{$rows['lastName']}</td>
                                  <td>{$rows['otherName']}</td>
                                  <td>{$rows['admissionNumber']}</td>
                                  <td>{$rows['className']}</td>
                                  <td>{$rows['classRoom']}</td>
                                  <td>{$rows['sessionName']}</td>
                                  <td>{$rows['termName']}</td>
                                  <td class='{$statusClass}'>{$statusText}</td>
                                  <td>{$rows['dateTimeTaken']}</td>
                                </tr>";
                        }
                      } else {
                        echo "<tr><td colspan='11' class='text-center text-danger'>No Record Found!</td></tr>";
                      }
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- Footer -->
      <?php include "Includes/footer.php";?>
      <!-- Footer -->
    </div>
  </div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/ruang-admin.min.js"></script>
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function () {
    $('#dataTableHover').DataTable();
  });
</script>
</body>
</html>
