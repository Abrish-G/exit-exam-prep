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
        // Redirect directly to login page on success
        header("Location: login.php");
        exit();
    }else{
        $message = "Email already exists";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0284c7;
            --primary-hover: #0369a1;
            --bg-gradient: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%);
            --card-bg: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .auth-card {
            background: var(--card-bg);
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        .auth-header h3 {
            color: var(--text-main);
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .form-label {
            color: var(--text-main);
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.625rem 0.875rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1);
            outline: 0;
        }

        .btn-modern {
            background-color: var(--primary-color);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .btn-modern:hover {
            background-color: var(--primary-hover);
            color: #ffffff;
        }

        .alert-custom {
            border-radius: 8px;
            border: none;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .switch-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .switch-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 col-sm-8 col-md-6 col-lg-5">

            <div class="card auth-card p-3 p-sm-4">
                <div class="card-body">

                    <div class="auth-header text-center mb-4">
                        <h3>Create Account</h3>
                        <p class="text-muted small m-0">Join the registration network portal</p>
                    </div>

                    <?php if($message){ ?>
                        <div class="alert alert-custom alert-danger text-danger bg-danger-subtle text-center mb-4 py-2.5">
                            <?= $message ?>
                        </div>
                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text"
                                   name="fullname"
                                   class="form-control"
                                   placeholder="John Doe"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="name@university.edu"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="••••••••"
                                   required>
                        </div>

                        <button type="submit"
                                name="register"
                                class="btn btn-modern w-100">
                            Register Account
                        </button>

                    </form>

                    <div class="mt-4 text-center">
                        <span class="text-muted small">Already have an account?</span>
                        <a href="login.php" class="switch-link small ms-1">
                            Sign In
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>