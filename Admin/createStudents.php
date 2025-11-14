<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------
if(isset($_POST['save'])){
    $firstName=$_POST['firstName'];
    $lastName=$_POST['lastName'];
    $otherName=$_POST['otherName'];
    $admissionNumber=$_POST['admissionNumber'];
    $classId=$_POST['classId'];
    $classArmId=$_POST['classArmId'];
    $dateCreated = date("Y-m-d");

    $query=mysqli_query($conn,"select * from tblstudents where admissionNumber ='$admissionNumber'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 
        $statusMsg = "<div class='alert alert-danger'>This Admission Number Already Exists!</div>";
    }
    else{
        $query=mysqli_query($conn,"insert into tblstudents(firstName,lastName,otherName,admissionNumber,password,classId,classArmId,dateCreated) 
        value('$firstName','$lastName','$otherName','$admissionNumber','12345','$classId','$classArmId','$dateCreated')");

        $statusMsg = $query 
            ? "<div class='alert alert-success'>Created Successfully!</div>"
            : "<div class='alert alert-danger'>An error Occurred!</div>";
    }
}

//------------------------EDIT--------------------------------------------------
if (isset($_GET['Id'], $_GET['action']) && $_GET['action'] == "edit") {
    $Id= $_GET['Id'];
    $query=mysqli_query($conn,"select * from tblstudents where Id ='$Id'");
    $row=mysqli_fetch_array($query);

    if(isset($_POST['update'])){
        $firstName=$_POST['firstName'];
        $lastName=$_POST['lastName'];
        $otherName=$_POST['otherName'];
        $admissionNumber=$_POST['admissionNumber'];
        $classId=$_POST['classId'];
        $classArmId=$_POST['classArmId'];

        $query=mysqli_query($conn,"update tblstudents set firstName='$firstName', lastName='$lastName',
            otherName='$otherName', admissionNumber='$admissionNumber', password='12345', classId='$classId',classArmId='$classArmId'
            where Id='$Id'");
        
        if ($query) {
            echo "<script>window.location='createStudents.php'</script>"; 
        } else {
            $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>";
        }
    }
}

//------------------------DELETE--------------------------------------------------
if (isset($_GET['Id'], $_GET['action']) && $_GET['action'] == "delete") {
    $Id= $_GET['Id'];
    $query = mysqli_query($conn,"DELETE FROM tblstudents WHERE Id='$Id'");
    if ($query == TRUE) {
        echo "<script>window.location='createStudents.php'</script>";
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
<title>Create Students</title>
<link href="img/School-logo.webp" rel="icon">
<?php include 'includes/title.php';?>
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="css/ruang-admin.min.css" rel="stylesheet">
<style>
    body { background-color: #f8f9fa; }
    .card { border-top: 4px solid #dc3545; border-radius: 1rem; }
    .btn-primary { background-color: #dc3545; border-color: #dc3545; border-radius: 50px; }
    .btn-primary:hover { background-color: #c82333; border-color: #bd2130; }
    .btn-warning { background-color: #fd7e14; border-color: #fd7e14; border-radius: 50px; }
    .btn-warning:hover { background-color: #e8590c; border-color: #d9480f; }
    .table thead { background-color: #dc3545; color: #fff; }
</style>
<script>
function classArmDropdown(str) {
    if (str == "") { document.getElementById("txtHint").innerHTML = ""; return; }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState==4 && this.status==200){
            document.getElementById("txtHint").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","ajaxClassArms2.php?cid="+str,true);
    xmlhttp.send();
}
</script>
</head>
<body>
<div class="d-flex" id="wrapper">
<?php include "Includes/sidebar.php";?>
<div id="content-wrapper" class="flex-grow-1">
<?php include "Includes/topbar.php";?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Create Students</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Create Students</li>
        </ol>
    </div>

    <!-- Form -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Add / Update Student</h6>
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
                        <label class="form-label">Other Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="otherName" value="<?php echo $row['otherName'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Admission Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="admissionNumber" value="<?php echo $row['admissionNumber'] ?? ''; ?>" required>
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
            <h6 class="mb-0">All Students</h6>
        </div>
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle" id="dataTableHover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Other Name</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Class Room</th>
                        <th>Date Created</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT s.Id, s.firstName, s.lastName, s.otherName, s.admissionNumber, s.dateCreated, c.className, a.classArmName
                              FROM tblstudents s
                              INNER JOIN tblclass c ON c.Id = s.classId
                              INNER JOIN tblclassarms a ON a.Id = s.classArmId";
                    $rs = $conn->query($query);
                    $sn=0;
                    if($rs->num_rows>0){
                        while($rows=$rs->fetch_assoc()){
                            $sn++;
                            echo "<tr>
                                    <td>{$sn}</td>
                                    <td>{$rows['firstName']}</td>
                                    <td>{$rows['lastName']}</td>
                                    <td>{$rows['otherName']}</td>
                                    <td>{$rows['admissionNumber']}</td>
                                    <td>{$rows['className']}</td>
                                    <td>{$rows['classRoom']}</td>
                                    <td>{$rows['dateCreated']}</td>
                                    <td><a href='?action=edit&Id={$rows['Id']}' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a></td>
                                    <td><a href='?action=delete&Id={$rows['Id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\");'><i class='fas fa-trash'></i></a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center text-muted'>No Record Found!</td></tr>";
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
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function () {
    $('#dataTableHover').DataTable();
});
</script>
</body>
</html>
