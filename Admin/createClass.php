<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------
if(isset($_POST['save'])){
    $className = $_POST['className'];
    $query = mysqli_query($conn,"SELECT * FROM tblclass WHERE className ='$className'");
    $ret = mysqli_fetch_array($query);

    if($ret > 0){ 
        $statusMsg = "<div class='alert alert-danger'>This Class Already Exists!</div>";
    } else {
        $query = mysqli_query($conn,"INSERT INTO tblclass(className) VALUE('$className')");
        $statusMsg = $query 
            ? "<div class='alert alert-success'>Created Successfully!</div>"
            : "<div class='alert alert-danger'>An error Occurred!</div>";
    }
}

//------------------------EDIT--------------------------------------------------
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
    $Id = $_GET['Id'];
    $query = mysqli_query($conn,"SELECT * FROM tblclass WHERE Id ='$Id'");
    $row = mysqli_fetch_array($query);

    if(isset($_POST['update'])){
        $className = $_POST['className'];
        $query = mysqli_query($conn,"UPDATE tblclass SET className='$className' WHERE Id='$Id'");
        if ($query) {
            echo "<script>window.location='createClass.php'</script>"; 
        } else {
            $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>";
        }
    }
}

//------------------------DELETE--------------------------------------------------
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
    $Id = $_GET['Id'];
    $query = mysqli_query($conn,"DELETE FROM tblclass WHERE Id='$Id'");
    if ($query) {
        echo "<script>window.location='createClass.php'</script>";  
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
  <title>Create Class</title>
  <link href="img/School-logo.webp" rel="icon">
  <?php include 'includes/title.php'; ?>
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
      body { background-color: #f8f9fa; }
      .card { border-radius: 1rem; }
      .btn { border-radius: 50px; padding: 0.5rem 1.5rem; }
      .table thead { background-color: #fd0d0dff; color: #fff; }
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
          <h3>Create Class</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Create Class</li>
          </ol>
        </div>

        <!-- Form -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <h6 class="mb-0">Add / Update Class</h6>
            <?php if(isset($statusMsg)) echo $statusMsg; ?>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="mb-3">
                <label class="form-label">Class Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="className" value="<?php echo $row['className'] ?? ''; ?>" placeholder="Enter class name" required>
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
            <h6 class="mb-0">All Classes</h6>
          </div>
          <div class="table-responsive p-3">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Class Name</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $query = "SELECT * FROM tblclass";
                $rs = $conn->query($query);
                $sn = 0;
                if($rs->num_rows > 0){
                    while($rows = $rs->fetch_assoc()){
                        $sn++;
                        echo "<tr>
                                <td>$sn</td>
                                <td>{$rows['className']}</td>
                                <td><a href='?action=edit&Id={$rows['Id']}' class='btn btn-sm btn-info'><i class='fas fa-edit'></i> Edit</a></td>
                                <td><a href='?action=delete&Id={$rows['Id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\");'><i class='fas fa-trash'></i> Delete</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center text-muted'>No records found</td></tr>";
                }
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <?php include "Includes/footer.php"; ?>
      <!-- Footer -->
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
