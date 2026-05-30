<?php
include '../includes/admin_auth.php';
include '../includes/db.php';
$message = "";

if(isset($_POST['add_course'])){
    $course = $conn->real_escape_string($_POST['course_name']);
    $sql = "INSERT INTO courses(course_name) VALUES('$course')";
    if($conn->query($sql)){
        $message = "New faculty target path registered successfully.";
    }else{
        $message = "Write error: Name conflict constraint violation matched inside tables.";
    }
}
$courses = $conn->query("SELECT * FROM courses ORDER BY course_name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Structure Engine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="admin-shell">
    <div class="responsive-sidebar">
        <div class="sidebar-brand-wrapper mb-4"><span class="text-white">🛠️ Management Console</span></div>
        <div class="d-flex flex-column gap-1">
            <a href="dashboard.php" class="sidebar-nav-link">📊 System Overview</a>
            <a href="manage_courses.php" class="sidebar-nav-link active">📚 Course Fields</a>
            <a href="manage_questions.php" class="sidebar-nav-link">📝 MCQ Repositories</a>
            <a href="manage_users.php" class="sidebar-nav-link">👥 User Accounts</a>
            <a href="analytics.php" class="sidebar-nav-link">📈 Metrics Stream</a>
        </div>
    </div>

    <div class="main-content-window p-3 p-sm-5">
        <div class="mb-4">
            <h2 class="fw-bold m-0 text-dark">Course Curriculum Matrix</h2>
            <p class="text-muted small">Construct departments or label target parameters required for graduation profiles.</p>
        </div>

        <?php if($message){ ?>
            <div class="alert alert-info border-0 py-3 mb-4 small fw-medium"><?= htmlspecialchars($message) ?></div>
        <?php } ?>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card card-modern p-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3 text-dark">Add New Subject</h5>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Full Qualification Title</label>
                                <input type="text" name="course_name" class="form-control" placeholder="e.g. Advanced Operating Systems" required style="border-radius: var(--radius-sm); padding: 0.6rem 0.8rem;">
                            </div>
                            <button type="submit" name="add_course" class="btn btn-modern-primary w-100 py-2">Commit Record Entry</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card card-modern overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-modern m-0 table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 120px;">Internal Index</th>
                                    <th>Registered System Course Designation String</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($course = $courses->fetch_assoc()){ ?>
                                    <tr>
                                        <td class="text-muted font-monospace fw-bold">#<?= $course['id'] ?></td>
                                        <td class="fw-semibold text-dark"><?= htmlspecialchars($course['course_name']) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>