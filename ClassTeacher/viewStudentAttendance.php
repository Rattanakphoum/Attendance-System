<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/School-logo.webp" rel="icon">
  <title>Dashboard</title>

  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <style>
    /* Modern Red Theme */
    body {
        background-color: #f8f0f0;
        font-family: 'Segoe UI', sans-serif;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border: none;
        transition: all 0.3s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .card-header {
        background: linear-gradient(90deg, #dc3545, #a71d2a);
        color: #fff;
        font-weight: 600;
        border-radius: 15px 15px 0 0;
    }

    .btn-primary {
        background-color: #dc3545;
        border: none;
        border-radius: 50px;
        padding: 8px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background-color: #a71d2a;
    }

    select.form-control {
        border-radius: 50px;
        border: 1px solid #dc3545;
    }

    label.form-control-label {
        font-weight: 600;
        color: #a71d2a;
    }

    table.dataTable thead th {
        background-color: #dc3545 !important;
        color: #fff !important;
        font-weight: 600;
        border-radius: 5px;
    }

    table.dataTable tbody tr:hover {
        background-color: #ffe6e6;
    }

    table.dataTable tbody td {
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .status-present {
        background-color: #28a745;
        color: #fff;
        font-weight: 600;
        border-radius: 50px;
        padding: 5px 10px;
        text-align: center;
        display: inline-block;
    }

    .status-absent {
        background-color: #dc3545;
        color: #fff;
        font-weight: 600;
        border-radius: 50px;
        padding: 5px 10px;
        text-align: center;
        display: inline-block;
    }

    .breadcrumb-item a {
        color: #dc3545 !important;
    }

    .breadcrumb-item.active {
        color: #a71d2a !important;
        font-weight: 600;
    }
  </style>

  <script>
    function typeDropDown(str) {
      if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else { 
        var xmlhttp;
        if (window.XMLHttpRequest) {
          xmlhttp = new XMLHttpRequest();
        } else {
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET","ajaxCallTypes.php?tid="+str,true);
        xmlhttp.send();
      }
    }
  </script>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "Includes/sidebar.php";?>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php";?>

        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Student Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Student Attendance</li>
            </ol>
          </div>

          <!-- Filter Card -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 text-white">Filter Student Attendance</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-row">
                      <div class="col-md-6 mb-3">
                        <label class="form-control-label">Select Student<span class="text-danger ml-2">*</span></label>
                        <?php
                        $qry= "SELECT * FROM tblstudents where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' ORDER BY firstName ASC";
                        $result = $conn->query($qry);
                        if ($result->num_rows > 0){
                          echo '<select required name="admissionNumber" class="form-control">';
                          echo '<option value="">--Select Student--</option>';
                          while ($rows = $result->fetch_assoc()){
                            echo '<option value="'.$rows['admissionNumber'].'">'.$rows['firstName'].' '.$rows['lastName'].'</option>';
                          }
                          echo '</select>';
                        }
                        ?>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-control-label">Type<span class="text-danger ml-2">*</span></label>
                        <select required name="type" onchange="typeDropDown(this.value)" class="form-control">
                          <option value="">--Select--</option>
                          <option value="1">All</option>
                          <option value="2">By Single Date</option>
                          <option value="3">By Date Range</option>
                        </select>
                      </div>
                    </div>
                    <div id="txtHint"></div>
                    <button type="submit" name="view" class="btn btn-primary mt-3">View Attendance</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Attendance Table -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header">
                  <h6 class="m-0 text-white">Class Attendance</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Other Name</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Class Arm</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if(isset($_POST['view'])){
                        $admissionNumber = $_POST['admissionNumber'];
                        $type = $_POST['type'];
                        // Your PHP query logic here
                        // Status styling
                        if($rows['status'] == '1'){
                          $status = "Present"; $badge = "status-present";
                        } else {
                          $status = "Absent"; $badge = "status-absent";
                        }
                        echo "<tr>
                          <td>".$sn."</td>
                          <td>".$rows['firstName']."</td>
                          <td>".$rows['lastName']."</td>
                          <td>".$rows['otherName']."</td>
                          <td>".$rows['admissionNumber']."</td>
                          <td>".$rows['className']."</td>
                          <td>".$rows['classArmName']."</td>
                          <td>".$rows['sessionName']."</td>
                          <td>".$rows['termName']."</td>
                          <td class='".$badge."'>".$status."</td>
                          <td>".$rows['dateTimeTaken']."</td>
                        </tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php include "Includes/footer.php";?>
    </div>
  </div>

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
