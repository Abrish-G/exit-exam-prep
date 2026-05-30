<?php
session_start();
include 'includes/db.php';

$message = "";

if(isset($_POST['login'])){

    $email    = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == 'admin'){

    header("Location: admin/dashboard.php");

}else{

    header("Location: dashboard.php");
}

exit();

        }else{
            $message = "Invalid password";
        }

    }else{
        $message = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-custom p-4">
                <div class="text-center my-3">
                    <h3 class="fw-bold tracking-tight">System Authentication</h3>
                    <p class="text-muted">Exit Exam Preparation System Gateway</p>
                </div>
                
                <?php if($message){ ?>
                    <div class="alert alert-danger border-0 shadow-sm small"><?= $message ?></div>
                <?php } ?>

                <form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Corporate Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg border-2" style="border-radius:8px;" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Security Access Password</label>
                        <input type="password" name="password" class="form-control form-control-lg border-2" style="border-radius:8px;" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-custom-primary w-100 py-2.5 fw-semibold fs-5">Authenticate Credentials</button>
                </form>

                <div class="mt-4 text-center">
                    <span class="text-muted small">New to the platform?</span> 
                    <a href="register.php" class="text-decoration-none fw-semibold text-primary ms-1">Create an Account</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>