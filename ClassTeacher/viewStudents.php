<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT tblclass.className,tblclassarms.classArmName 
    FROM tblclassteacher
    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    Where tblclassteacher.Id = '$_SESSION[userId]'";

$rs = $conn->query($query);
$rrw = $rs->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Student Dashboard</title>
  <link href="img/School-logo.webp" rel="icon">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }

    /* Card headers and table */
    .card-header {
      background: linear-gradient(90deg, #dc3545, #a71d2a);
      color: #fff;
      font-weight: bold;
      font-size: 1rem;
    }

    table.dataTable thead {
      background: #dc3545;
      color: #fff;
    }

    table.dataTable tbody tr:hover {
      background-color: #f5c6cb !important;
    }

    /* Buttons and links */
    .btn-primary {
      background: #dc3545;
      border: none;
    }
    .btn-primary:hover {
      background: #a71d2a;
    }

    /* Breadcrumbs */
    .breadcrumb-item a {
      color: #dc3545;
    }
    .breadcrumb-item.active {
      color: #a71d2a;
    }

    /* Modern box shadow for cards */
    .card {
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      border-radius: 12px;
    }
  </style>

  <script>
    function classArmDropdown(str) {
      if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else { 
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp = new XMLHttpRequest();
        else xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET","ajaxClassArms2.php?cid="+str,true);
        xmlhttp.send();
      }
    }
  </script>
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
            <h1 class="h3 mb-0 text-gray-800">
              All Students in (<?php echo $rrw['className'].' - '.$rrw['classArmName'];?>)
            </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">All Students</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0">Student List</h6>
                </div>
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
                        <th>Class room</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $query = "SELECT tblstudents.Id,tblclass.className,tblclassarms.classArmName,tblstudents.firstName,
                                tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber
                                FROM tblstudents
                                INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                                INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
                                WHERE tblstudents.classId = '$_SESSION[classId]' 
                                  AND tblstudents.classArmId = '$_SESSION[classArmId]'";
                      $rs = $conn->query($query);
                      $sn = 0;
                      if($rs->num_rows > 0) { 
                        while ($rows = $rs->fetch_assoc()) {
                          $sn++;
                          echo "<tr>
                                  <td>".$sn."</td>
                                  <td>".$rows['firstName']."</td>
                                  <td>".$rows['lastName']."</td>
                                  <td>".$rows['otherName']."</td>
                                  <td>".$rows['admissionNumber']."</td>
                                  <td>".$rows['className']."</td>
                                  <td>".$rows['classArmName']."</td>
                                </tr>";
                        }
                      } else {
                        echo "<tr><td colspan='7' class='text-center text-danger'>No Records Found</td></tr>";
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
