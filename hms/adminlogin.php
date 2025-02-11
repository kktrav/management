<?php
session_start();
include("include/connection1.php");

if (isset($_POST['login'])) {
    $username = $_POST['uname'];
    $password = $_POST['pass'];

    $error = array();

    if (empty($username)) {
        $error['login'] = "Enter Username";
    } else if (empty($password)) {
        $error['login'] = "Enter Password";
    }

    if (count($error) == 0) {
        $query = "SELECT * FROM admin WHERE username=? AND password=?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            echo "<script>alert('You have Login As admin');</script>";
            $_SESSION['admin'] = $username;
            header("Location:admin/index.php");
            exit();
        } else {
            echo "<script>alert('Invalid Username or Password');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login Page</title>
</head>
<body style="background-image: url(img/hospital.jpg); background-size: cover;">

    <?php include("include/header.php"); ?>

    <div style="margin-top: 20px;"></div>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 mt-4 p-4 bg-light text-black rounded">
                    <center>
                        <i class="fa-solid fa-users-gear fa-2xl my-3" style="color: black;"></i>
                    </center>
                    <form method="post" class="my-2">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username">
                        </div>
                        <div style="margin-top: 10px;"></div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="pass" class="form-control">
                        </div>
                        <div style="margin-top: 10px;"></div>
                        <div>
                            <?php
                            if (isset($error['login'])) {
                                $sh = $error['login'];
                                echo "<h6 class='alert alert-danger' role='alert'>$sh</h6>";
                            }
                            ?>
                        </div>
                        <div style="margin-top: 20px;"></div>
                        <input type="submit" name="login" class="btn btn-success" value="Login">
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</body>
</html>
