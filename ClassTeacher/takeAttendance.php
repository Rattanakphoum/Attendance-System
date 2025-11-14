<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT tblclass.className,tblclassarms.classArmName 
    FROM tblclassteacher
    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    WHERE tblclassteacher.Id = '$_SESSION[userId]'";
$rs = $conn->query($query);
$rrw = $rs->fetch_assoc();

// Session and Term
$querey=mysqli_query($conn,"SELECT * FROM tblsessionterm WHERE isActive ='1'");
$rwws=mysqli_fetch_array($querey);
$sessionTermId = $rwws['Id'];

$dateTaken = date("Y-m-d");

$qurty=mysqli_query($conn,"SELECT * FROM tblattendance WHERE classId = '$_SESSION[classId]' AND classArmId = '$_SESSION[classArmId]' AND dateTimeTaken='$dateTaken'");
$count = mysqli_num_rows($qurty);

if($count == 0){
    $qus=mysqli_query($conn,"SELECT * FROM tblstudents WHERE classId = '$_SESSION[classId]' AND classArmId = '$_SESSION[classArmId]'");
    while ($ros = $qus->fetch_assoc()) {
        mysqli_query($conn,"INSERT INTO tblattendance(admissionNo,classId,classArmId,sessionTermId,status,dateTimeTaken) 
                           VALUES('$ros[admissionNumber]','$_SESSION[classId]','$_SESSION[classArmId]','$sessionTermId','0','$dateTaken')");
    }
}

if(isset($_POST['save'])){
    $admissionNo=$_POST['admissionNo'];
    $check=$_POST['check'];
    $N = count($admissionNo);
    $qurty=mysqli_query($conn,"SELECT * FROM tblattendance WHERE classId = '$_SESSION[classId]' AND classArmId = '$_SESSION[classArmId]' AND dateTimeTaken='$dateTaken' AND status = '1'");
    $count = mysqli_num_rows($qurty);

    if($count > 0){
        $statusMsg = "<div class='alert alert-danger text-center'>Attendance has been taken for today!</div>";
    } else {
        for($i = 0; $i < $N; $i++){
            if(isset($check[$i])){
                $qquery=mysqli_query($conn,"UPDATE tblattendance SET status='1' WHERE admissionNo = '$check[$i]'");
                $statusMsg = $qquery ? 
                    "<div class='alert alert-success text-center'>Attendance Taken Successfully!</div>" : 
                    "<div class='alert alert-danger text-center'>An error occurred!</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Take Attendance</title>
  <link href="img/School-logo.webp" rel="icon">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }

    /* Card headers */
    .card-header {
      background: linear-gradient(90deg, #dc3545, #a71d2a);
      color: #fff;
      font-weight: bold;
      font-size: 1rem;
    }

    /* Table header & hover */
    table.dataTable thead {
      background: #dc3545;
      color: #fff;
    }
    table.table-hover tbody tr:hover {
      background-color: #f5c6cb !important;
    }

    /* Buttons */
    .btn-primary {
      background: #dc3545;
      border: none;
      border-radius: 6px;
    }
    .btn-primary:hover {
      background: #a71d2a;
    }

    /* Breadcrumbs */
    .breadcrumb-item a { color: #dc3545; }
    .breadcrumb-item.active { color: #a71d2a; }

    /* Modern card shadow */
    .card { box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 12px; }

    /* Status message style */
    .alert { border-radius: 8px; }
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
          <h1 class="h3 mb-0 text-gray-800">Take Attendance (<?php echo date("m-d-Y"); ?>)</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Take Attendance</li>
          </ol>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <form method="post">
              <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h6>Students in (<?php echo $rrw['className'].' - '.$rrw['classArmName'];?>)</h6>
                  <span class="text-warning"><i>Click checkboxes to mark attendance</i></span>
                </div>
                <div class="table-responsive p-3">
                  <?php echo $statusMsg ?? ''; ?>
                  <table class="table table-hover table-striped table-bordered" id="dataTableHover">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Other Name</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Class Arm</th>
                        <th>Check</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $query = "SELECT tblstudents.Id,tblstudents.admissionNumber,tblclass.className,tblclassarms.classArmName,
                               tblstudents.firstName,tblstudents.lastName,tblstudents.otherName
                               FROM tblstudents
                               INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                               INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
                               WHERE tblstudents.classId = '$_SESSION[classId]' AND tblstudents.classArmId = '$_SESSION[classArmId]'";
                      $rs = $conn->query($query);
                      $sn=0;
                      if($rs->num_rows > 0){
                        while($rows = $rs->fetch_assoc()){
                          $sn++;
                          echo "<tr>
                                  <td>{$sn}</td>
                                  <td>{$rows['firstName']}</td>
                                  <td>{$rows['lastName']}</td>
                                  <td>{$rows['otherName']}</td>
                                  <td>{$rows['admissionNumber']}</td>
                                  <td>{$rows['className']}</td>
                                  <td>{$rows['classroomnumber']}</td>
                                  <td><input name='check[]' type='checkbox' value='{$rows['admissionNumber']}' class='form-control'></td>
                                </tr>";
                          echo "<input name='admissionNo[]' value='{$rows['admissionNumber']}' type='hidden'>";
                        }
                      } else {
                        echo "<tr><td colspan='8' class='text-center text-danger'>No Records Found</td></tr>";
                      }
                    ?>
                    </tbody>
                  </table>
                  <button type="submit" name="save" class="btn btn-primary mt-3">Take Attendance</button>
                </div>
              </div>
            </form>
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
