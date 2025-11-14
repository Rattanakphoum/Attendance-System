<?php 
include 'Includes/dbcon.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>IT STEP - Login</title>
  <link href="img/logo/School-logo.webp" rel="icon">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

  <!-- Custom Modern Red Login CSS -->
  <style>
    :root {
      --primary: #ff0022;
      --primary-dark: #b20018;
      --light-red: #ff4d4d;
      --text-color: #fff;
      --bg-color: #0a0a0a;
      --input-bg: rgba(255, 255, 255, 0.1);
      --shadow: 0 8px 30px rgba(255, 0, 34, 0.3);
      --radius: 18px;
    }

    * {
      box-sizing: border-box;
      transition: all 0.3s ease;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: radial-gradient(circle at top left, #2b0008, #000);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      overflow: hidden;
    }

    .login-container {
      background: rgba(0, 0, 0, 0.85);
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: var(--shadow);
      border-radius: var(--radius);
      padding: 45px 40px;
      max-width: 420px;
      width: 100%;
      text-align: center;
      position: relative;
    }

    .login-container::before {
      content: "";
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      border-radius: var(--radius);
      background: linear-gradient(135deg, var(--primary), #ff5e62, #ff0022);
      z-index: -1;
      opacity: 0.3;
      filter: blur(25px);
    }

    .login-container img {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      border: 2px solid var(--primary);
      margin-bottom: 15px;
      box-shadow: 0 0 20px var(--primary);
    }

    h5 {
      font-weight: 700;
      color: var(--light-red);
      letter-spacing: 1px;
    }

    h1 {
      font-size: 1.6rem;
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 25px;
    }

    .form-control {
      background: var(--input-bg);
      color: var(--text-color);
      border: none;
      border-radius: 50px;
      padding: 12px 18px;
      font-size: 0.95rem;
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 0 10px var(--primary);
      outline: none;
    }

    select.form-control {
      cursor: pointer;
    }

    .btn-login {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #fff;
      border: none;
      border-radius: 50px;
      padding: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-top: 10px;
      width: 100%;
      box-shadow: 0 4px 15px rgba(255, 0, 34, 0.4);
    }

    .btn-login:hover {
      transform: translateY(-3px);
      background: var(--light-red);
      box-shadow: 0 6px 20px rgba(255, 0, 34, 0.5);
    }

    .alert {
      margin-top: 20px;
      border-radius: 10px;
      font-size: 0.9rem;
    }

    footer {
      text-align: center;
      color: rgba(255, 255, 255, 0.6);
      font-size: 0.85rem;
      margin-top: 20px;
    }

    @media (max-width: 480px) {
      .login-container {
        margin: 20px;
        padding: 35px 25px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h5>IT STEP ATTENDANCE</h5>
    <img src="img/logo/School-logo.webp" alt="Logo">
    <h1>Login Portal</h1>

    <form method="POST" action="">
      <div class="form-group mb-3">
        <select required name="userType" class="form-control">
          <option value="">-- Select User Role --</option>
          <option value="Administrator">Administrator</option>
          <option value="ClassTeacher">Class Teacher</option>
        </select>
      </div>

      <div class="form-group mb-3">
        <input type="text" class="form-control" required name="username" placeholder="Enter Email Address">
      </div>

      <div class="form-group mb-3">
        <input type="password" name="password" required class="form-control" placeholder="Enter Password">
      </div>

      <input type="submit" class="btn-login" value="Login" name="login" />
    </form>

    <?php
      if(isset($_POST['login'])){
        $userType = $_POST['userType'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        if($userType == "Administrator"){
          $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND password = '$password'";
          $rs = $conn->query($query);
          $num = $rs->num_rows;
          $rows = $rs->fetch_assoc();

          if($num > 0){
            $_SESSION['userId'] = $rows['Id'];
            $_SESSION['firstName'] = $rows['firstName'];
            $_SESSION['lastName'] = $rows['lastName'];
            $_SESSION['emailAddress'] = $rows['emailAddress'];
            echo "<script>window.location = 'Admin/index.php';</script>";
          } else {
            echo "<div class='alert alert-danger'>Invalid Username/Password!</div>";
          }
        }
        else if($userType == "ClassTeacher"){
          $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
          $rs = $conn->query($query);
          $num = $rs->num_rows;
          $rows = $rs->fetch_assoc();

          if($num > 0){
            $_SESSION['userId'] = $rows['Id'];
            $_SESSION['firstName'] = $rows['firstName'];
            $_SESSION['lastName'] = $rows['lastName'];
            $_SESSION['emailAddress'] = $rows['emailAddress'];
            $_SESSION['classId'] = $rows['classId'];
            $_SESSION['classArmId'] = $rows['classArmId'];
            echo "<script>window.location = 'ClassTeacher/index.php';</script>";
          } else {
            echo "<div class='alert alert-danger'>Invalid Username/Password!</div>";
          }
        } else {
          echo "<div class='alert alert-danger'>Invalid Username/Password!</div>";
        }
      }
    ?>

    <footer>© <?php echo date("Y"); ?> IT STEP | Attendance System</footer>
  </div>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
