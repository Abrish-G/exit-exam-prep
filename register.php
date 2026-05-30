<?php
include 'includes/db.php';

$message = "";

if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(fullname,email,password)
            VALUES('$fullname','$email','$password')";

    if($conn->query($sql)){
        $message = "Registration successful";
    }else{
        $message = "Email already exists";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header text-center">
                    <h3>Create Account</h3>
                </div>

                <div class="card-body">

                    <?php if($message){ ?>

                        <div class="alert alert-info">
                            <?= $message ?>
                        </div>

                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text"
                                   name="fullname"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit"
                                name="register"
                                class="btn btn-primary w-100">

                            Register

                        </button>

                    </form>

                    <div class="mt-3 text-center">

                        <a href="login.php">
                            Already have an account?
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>