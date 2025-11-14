<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------
if(isset($_POST['save'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNo = $_POST['phoneNo'];
    $classId = $_POST['classId'];
    $classArmId = $_POST['classArmId'];
    $dateCreated = date("Y-m-d");

    $query = mysqli_query($conn,"SELECT * FROM tblclassteacher WHERE emailAddress='$emailAddress'");
    $ret = mysqli_fetch_array($query);

    $sampPass = "pass123";
    $sampPass_2 = md5($sampPass);

    if($ret > 0){ 
        $statusMsg = "<div class='alert alert-danger'>This Email Address Already Exists!</div>";
    } else {
        $query = mysqli_query($conn,"INSERT INTO tblclassteacher(firstName,lastName,emailAddress,password,phoneNo,classId,classArmId,dateCreated) 
                                    VALUES('$firstName','$lastName','$emailAddress','$sampPass_2','$phoneNo','$classId','$classArmId','$dateCreated')");
        if($query){
            $qu = mysqli_query($conn,"UPDATE tblclassarms SET isAssigned='1' WHERE Id='$classArmId'");
            $statusMsg = $qu 
                ? "<div class='alert alert-success'>Created Successfully!</div>" 
                : "<div class='alert alert-danger'>An error Occurred!</div>";
        } else {
            $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>";
        }
    }
}

//------------------------EDIT--------------------------------------------------
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action']=="edit") {
    $Id = $_GET['Id'];
    $query = mysqli_query($conn,"SELECT * FROM tblclassteacher WHERE Id='$Id'");
    $row = mysqli_fetch_array($query);

    if(isset($_POST['update'])){
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $emailAddress = $_POST['emailAddress'];
        $phoneNo = $_POST['phoneNo'];
        $classId = $_POST['classId'];
        $classArmId = $_POST['classArmId'];

        $query = mysqli_query($conn,"UPDATE tblclassteacher SET firstName='$firstName', lastName='$lastName', 
                                    emailAddress='$emailAddress', phoneNo='$phoneNo', classId='$classId', classArmId='$classArmId' 
                                    WHERE Id='$Id'");
        if($query){
            echo "<script>window.location='createClassTeacher.php'</script>";
        } else {
            $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>";
        }
    }
}

//------------------------DELETE--------------------------------------------------
if(isset($_GET['Id'], $_GET['classArmId'], $_GET['action']) && $_GET['action']=="delete"){
    $Id = $_GET['Id'];
    $classArmId = $_GET['classArmId'];

    $query = mysqli_query($conn,"DELETE FROM tblclassteacher WHERE Id='$Id'");
    if($query){
        $qu = mysqli_query($conn,"UPDATE tblclassarms SET isAssigned='0' WHERE Id='$classArmId'");
        if($qu){
            echo "<script>window.location='createClassTeacher.php'</script>";
        } else {
            $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>";
        }
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
  <title>Create Class Teachers</title>
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
  <script>
    function classArmDropdown(str) {
        if(str==""){ document.getElementById("txtHint").innerHTML=""; return; }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200){
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxClassArms.php?cid="+str,true);
        xmlhttp.send();
    }
  </script>
</head>
<body>
<div class="d-flex" id="wrapper">
    <?php include "Includes/sidebar.php"; ?>
    <div id="page-content-wrapper" class="flex-grow-1">
        <?php include "Includes/topbar.php"; ?>

        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Create Class Teachers</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active">Create Class Teachers</li>
                </ol>
            </div>

            <!-- Form -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Add / Update Class Teacher</h6>
                    <?php if(isset($statusMsg)) echo $statusMsg; ?>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="firstName" value="<?php echo $row['firstName'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lastName" value="<?php echo $row['lastName'] ?? ''; ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="emailAddress" value="<?php echo $row['emailAddress'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone No <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phoneNo" value="<?php echo $row['phoneNo'] ?? ''; ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Select Class <span class="text-danger">*</span></label>
                                <?php
                                $qry= "SELECT * FROM tblclass ORDER BY className ASC";
                                $result = $conn->query($qry);
                                if ($result->num_rows > 0){
                                    echo '<select required name="classId" onchange="classArmDropdown(this.value)" class="form-select">';
                                    echo '<option value="">--Select Class--</option>';
                                    while($rows = $result->fetch_assoc()){
                                        $selected = (isset($row['classId']) && $row['classId']==$rows['Id']) ? "selected" : "";
                                        echo '<option value="'.$rows['Id'].'" '.$selected.'>'.$rows['className'].'</option>';
                                    }
                                    echo '</select>';
                                }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Class Room <span class="text-danger">*</span></label>
                                <div id="txtHint"><?php echo $row['classArmId'] ?? ''; ?></div>
                            </div>
                        </div>

                        <button type="submit" name="<?php echo isset($Id)?'update':'save'; ?>" class="btn <?php echo isset($Id)?'btn-warning':'btn-primary'; ?>">
                            <?php echo isset($Id)?'Update':'Save'; ?>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0">All Class Teachers</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-hover align-middle" id="dataTableHover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone No</th>
                                <th>Class</th>
                                <th>Class Room</th>
                                <th>Date Created</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT t.Id, t.firstName, t.lastName, t.emailAddress, t.phoneNo, t.dateCreated, 
                                         c.className, a.classArmName, a.Id AS classArmId
                                  FROM tblclassteacher t
                                  INNER JOIN tblclass c ON c.Id = t.classId
                                  INNER JOIN tblclassarms a ON a.Id = t.classArmId";
                        $rs = $conn->query($query);
                        $sn=0;
                        if($rs->num_rows>0){
                            while($rows=$rs->fetch_assoc()){
                                $sn++;
                                echo "<tr>
                                        <td>{$sn}</td>
                                        <td>{$rows['firstName']}</td>
                                        <td>{$rows['lastName']}</td>
                                        <td>{$rows['emailAddress']}</td>
                                        <td>{$rows['phoneNo']}</td>
                                        <td>{$rows['className']}</td>
                                        <td>{$rows['classArmName']}</td>
                                        <td>{$rows['dateCreated']}</td>
                                        <td><a href='?action=delete&Id={$rows['Id']}&classArmId={$rows['classArmId']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\");'><i class='fas fa-trash'></i></a></td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center text-muted'>No records found</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php include "Includes/footer.php"; ?>
    </div>
</div>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTableHover').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
</body>
</html>
