<?php
include '../includes/admin_auth.php';
include '../includes/db.php';
$sql = "SELECT questions.*, courses.course_name FROM questions JOIN courses ON questions.course_id = courses.id ORDER BY questions.id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCQ Database Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="admin-shell">
    <div class="responsive-sidebar">
        <div class="sidebar-brand-wrapper mb-4"><span class="text-white">🛠️ Management Console</span></div>
        <div class="d-flex flex-column gap-1">
            <a href="dashboard.php" class="sidebar-nav-link">📊 System Overview</a>
            <a href="manage_courses.php" class="sidebar-nav-link">📚 Course Fields</a>
            <a href="manage_questions.php" class="sidebar-nav-link active">📝 MCQ Repositories</a>
            <a href="manage_users.php" class="sidebar-nav-link">👥 User Accounts</a>
            <a href="analytics.php" class="sidebar-nav-link">📈 Metrics Stream</a>
        </div>
    </div>

    <div class="main-content-window p-3 p-sm-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold m-0">Active MCQ Repositories</h2>
                <p class="text-muted small m-0">Perform runtime evaluation matrix checks or drop question vectors from production indexes.</p>
            </div>
            <a href="upload_json.php" class="btn btn-modern-primary d-flex align-items-center gap-2">+ Import Bulk Assets</a>
        </div>

        <div class="card card-modern overflow-hidden">
            <div class="table-responsive">
                <table class="table table-modern align-middle table-hover">
                    <thead>
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th style="width: 200px;">Course Category Map Target</th>
                            <th>Question Content Core String Layout</th>
                            <th style="width: 80px; text-align:center;">Key</th>
                            <th style="width: 100px; text-align:center;">Action Interface</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()){ ?>
                            <tr>
                                <td class="text-muted font-monospace fw-bold">#<?= $row['id'] ?></td>
                                <td><span class="badge bg-light text-dark border px-2.5 py-1.5 fw-semibold"><?= htmlspecialchars($row['course_name']) ?></span></td>
                                <td class="text-wrap fw-medium text-dark" style="max-width: 420px;"><?= htmlspecialchars($row['question']) ?></td>
                                <td class="text-center"><span class="badge bg-success-subtle text-success px-3 py-1.5 fs-6 fw-bold border border-success"><?= htmlspecialchars($row['answer']) ?></span></td>
                                <td class="text-center">
                                    <a href="delete_question.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger px-2.5 py-1.5 fw-semibold" onclick="return confirm('Drop database entity parameter mapping loop definitively?')">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>