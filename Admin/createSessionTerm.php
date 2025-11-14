<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------
if(isset($_POST['save'])){
    $sessionName=$_POST['sessionName'];
    $termId=$_POST['termId'];
    $dateCreated = date("Y-m-d");

    $query=mysqli_query($conn,"select * from tblsessionterm where sessionName ='$sessionName' and termId = '$termId'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 
        $statusMsg = "<div class='alert alert-danger'>This Session and Term Already Exists!</div>";
    } else {
        $query=mysqli_query($conn,"insert into tblsessionterm(sessionName,termId,isActive,dateCreated) 
                                   value('$sessionName','$termId','0','$dateCreated')");
        $statusMsg = $query 
            ? "<div class='alert alert-success'>Created Successfully!</div>"
            : "<div class='alert alert-danger'>An error Occurred!</div>";
    }
}

//------------------------EDIT--------------------------------------------------
if (isset($_GET['Id'], $_GET['action']) && $_GET['action'] == "edit") {
    $Id= $_GET['Id'];
    $query=mysqli_query($conn,"select * from tblsessionterm where Id ='$Id'");
    $row=mysqli_fetch_array($query);

    if(isset($_POST['update'])){
        $sessionName=$_POST['sessionName'];
        $termId=$_POST['termId'];

        $query=mysqli_query($conn,"update tblsessionterm set sessionName='$sessionName',termId='$termId',isActive='0' where Id='$Id'");
        if ($query) {
            echo "<script>window.location='createSessionTerm.php'</script>"; 
        } else {
            $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>";
        }
    }
}

//------------------------DELETE--------------------------------------------------
if (isset($_GET['Id'], $_GET['action']) && $_GET['action'] == "delete") {
    $Id= $_GET['Id'];
    $query = mysqli_query($conn,"DELETE FROM tblsessionterm WHERE Id='$Id'");
    if ($query) {
        echo "<script>window.location='createSessionTerm.php'</script>";  
    } else {
        $statusMsg = "<div class='alert alert-danger'>An error Occurred!</div>"; 
    }
}

//------------------------ACTIVATE--------------------------------------------------
if (isset($_GET['Id'], $_GET['action']) && $_GET['action'] == "activate") {
    $Id= $_GET['Id'];
    $query=mysqli_query($conn,"update tblsessionterm set isActive='0' where isActive='1'");
    if ($query) {
        $que=mysqli_query($conn,"update tblsessionterm set isActive='1' where Id='$Id'");
        if ($que) {
            echo "<script>window.location='createSessionTerm.php'</script>";  
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
<title>Create Session and Term</title>
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
</head>
<body>
<div class="d-flex" id="wrapper">
<?php include "Includes/sidebar.php";?>
<div id="content-wrapper" class="flex-grow-1">
<?php include "Includes/topbar.php";?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Create Session and Term</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Create Session and Term</li>
        </ol>
    </div>

    <!-- Form -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Add / Update Session & Term</h6>
            <?php if(isset($statusMsg)) echo $statusMsg; ?>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Session Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="sessionName" value="<?php echo $row['sessionName'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Term <span class="text-danger">*</span></label>
                        <?php
                        $qry= "SELECT * FROM tblterm ORDER BY termName ASC";
                        $result = $conn->query($qry);
                        if ($result->num_rows > 0){
                            echo '<select required name="termId" class="form-select">';
                            echo '<option value="">--Select Term--</option>';
                            while($rows = $result->fetch_assoc()){
                                $selected = (isset($row['termId']) && $row['termId']==$rows['Id']) ? "selected" : "";
                                echo '<option value="'.$rows['Id'].'" '.$selected.'>'.$rows['termName'].'</option>';
                            }
                            echo '</select>';
                        }
                        ?>
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
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">All Sessions & Terms</h6>
            <h6 class="text-danger mb-0">Note: <i>Click the check symbol to activate a session & term!</i></h6>
        </div>
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle" id="dataTableHover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Activate</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT s.Id,s.sessionName,s.isActive,s.dateCreated,t.termName
                              FROM tblsessionterm s
                              INNER JOIN tblterm t ON t.Id = s.termId";
                    $rs = $conn->query($query);
                    $sn=0;
                    if($rs->num_rows>0){
                        while($rows=$rs->fetch_assoc()){
                            $sn++;
                            $status = $rows['isActive']=='1' ? 'Active' : 'Inactive';
                            echo "<tr>
                                    <td>{$sn}</td>
                                    <td>{$rows['sessionName']}</td>
                                    <td>{$rows['termName']}</td>
                                    <td>{$status}</td>
                                    <td>{$rows['dateCreated']}</td>
                                    <td><a href='?action=activate&Id={$rows['Id']}' class='btn btn-sm btn-success'><i class='fas fa-check'></i></a></td>
                                    <td><a href='?action=edit&Id={$rows['Id']}' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a></td>
                                    <td><a href='?action=delete&Id={$rows['Id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\");'><i class='fas fa-trash'></i></a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center text-muted'>No Record Found!</td></tr>";
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
