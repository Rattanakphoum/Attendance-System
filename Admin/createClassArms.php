<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------
if(isset($_POST['save'])){
    $classId = $_POST['classId'];
    $classArmName = $_POST['classArmName'];

    $query = mysqli_query($conn,"SELECT * FROM tblclassarms WHERE classArmName ='$classArmName' AND classId='$classId'");
    $ret = mysqli_fetch_array($query);

    if($ret > 0){ 
        $statusMsg = "<div class='alert alert-danger'>This Class Arm Already Exists!</div>";
    } else {
        $query = mysqli_query($conn,"INSERT INTO tblclassarms(classId,classArmName,isAssigned) VALUE('$classId','$classArmName','0')");
        $statusMsg = $query 
            ? "<div class='alert alert-success'>Created Successfully!</div>"
            : "<div class='alert alert-danger'>An error Occurred!</div>";
    }
}

//------------------------EDIT--------------------------------------------------
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
    $Id = $_GET['Id'];
    $query = mysqli_query($conn,"SELECT * FROM tblclassarms WHERE Id ='$Id'");
    $row = mysqli_fetch_array($query);

    if(isset($_POST['update'])){
        $classId = $_POST['classId'];
        $classArmName = $_POST['classArmName'];

        $query = mysqli_query($conn,"UPDATE tblclassarms SET classId='$classId', classArmName='$classArmName' WHERE Id='$Id'");
        if ($query) {
            echo "<script>window.location='createClassArms.php'</script>"; 
        } else {
            $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>";
        }
    }
}

//------------------------DELETE--------------------------------------------------
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
    $Id = $_GET['Id'];
    $query = mysqli_query($conn,"DELETE FROM tblclassarms WHERE Id='$Id'");
    if ($query) {
        echo "<script>window.location='createClassArms.php'</script>";  
    } else {
        $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Class Room</title>
  <link href="img/School-logo.webp" rel="icon">
  <?php include 'includes/title.php'; ?>
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
      body { background-color: #f8f9fa; }
      .card { border-radius: 1rem; border-top: 4px solid #dc3545; }
      .btn { border-radius: 50px; padding: 0.5rem 1.5rem; }
      .btn-primary { background-color: #dc3545; border-color: #dc3545; }
      .btn-primary:hover { background-color: #c82333; border-color: #bd2130; }
      .btn-warning { background-color: #fd7e14; border-color: #fd7e14; }
      .btn-warning:hover { background-color: #e8590c; border-color: #d9480f; }
      .table thead { background-color: #dc3545; color: #fff; }
  </style>
</head>

<body>
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>
    <!-- Sidebar -->

    <div id="page-content-wrapper" class="flex-grow-1">
      <!-- TopBar -->
      <?php include "Includes/topbar.php"; ?>
      <!-- Topbar -->

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3>Create Class Room</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Create Class Room-Number</li>
          </ol>
        </div>

        <!-- Form -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Add / Update Class Number</h6>
            <?php if(isset($statusMsg)) echo $statusMsg; ?>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label">Select Class <span class="text-danger">*</span></label>
                  <?php
                  $qry= "SELECT * FROM tblclass ORDER BY className ASC";
                  $result = $conn->query($qry);
                  if ($result->num_rows > 0){
                      echo '<select required name="classId" class="form-select mb-3">';
                      echo '<option value="">--Select Class--</option>';
                      while ($rows = $result->fetch_assoc()){
                          $selected = (isset($row['classId']) && $row['classId'] == $rows['Id']) ? "selected" : "";
                          echo '<option value="'.$rows['Id'].'" '.$selected.'>'.$rows['className'].'</option>';
                      }
                      echo '</select>';
                  }
                  ?>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Class Number <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="classArmName" value="<?php echo $row['classArmName'] ?? ''; ?>" placeholder="Class Room-Number" required>
                </div>
              </div>
              <button type="submit" name="<?php echo isset($Id) ? 'update' : 'save'; ?>" class="btn <?php echo isset($Id) ? 'btn-warning' : 'btn-primary'; ?>">
                <?php echo isset($Id) ? 'Update' : 'Save'; ?>
              </button>
            </form>
          </div>
        </div>

        <!-- Classes Table -->
        <div class="card shadow-sm mb-4">
          <div class="card-header">
            <h6 class="mb-0">All Class Number</h6>
          </div>
          <div class="table-responsive p-3">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Class Name</th>
                  <th>Class Room-Number</th>
                  <th>Status</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $query = "SELECT ca.Id, ca.isAssigned, c.className, ca.classArmName 
                          FROM tblclassarms ca
                          INNER JOIN tblclass c ON c.Id = ca.classId";
                $rs = $conn->query($query);
                $sn = 0;
                if($rs->num_rows > 0){
                    while($rows = $rs->fetch_assoc()){
                        $sn++;
                        $status = ($rows['isAssigned'] == '1') ? "Assigned" : "UnAssigned";
                        echo "<tr>
                                <td>$sn</td>
                                <td>{$rows['className']}</td>
                                <td>{$rows['classArmName']}</td>
                                <td>{$status}</td>
                                <td><a href='?action=edit&Id={$rows['Id']}' class='btn btn-sm btn-info'><i class='fas fa-edit'></i> Edit</a></td>
                                <td><a href='?action=delete&Id={$rows['Id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\");'><i class='fas fa-trash'></i> Delete</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center text-muted'>No records found</td></tr>";
                }
              ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <!-- Footer -->
      <?php include "Includes/footer.php"; ?>
    </div>
  </div>

  <!-- JS -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap5.min.js"></script>
  <script>
      $(document).ready(function() {
          $('table').DataTable({
              "paging": true,
              "searching": true,
              "ordering": true
          });
      });
  </script>
</body>
</html>
