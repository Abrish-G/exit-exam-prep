<?php
include '../includes/admin_auth.php';
include '../includes/db.php';
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication Management Control</title>
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
            <a href="manage_questions.php" class="sidebar-nav-link">📝 MCQ Repositories</a>
            <a href="manage_users.php" class="sidebar-nav-link active">👥 User Accounts</a>
            <a href="analytics.php" class="sidebar-nav-link">📈 Metrics Stream</a>
        </div>
    </div>

    <div class="main-content-window p-3 p-sm-5">
        <div class="mb-4">
            <h2 class="fw-bold m-0 text-dark">User Administration Profiles</h2>
            <p class="text-muted small">Verify authorization layers, audit account strings, and verify access levels.</p>
        </div>

        <div class="card card-modern overflow-hidden">
            <div class="table-responsive">
                <table class="table table-modern m-0 table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Authenticated Member Fullname</th>
                            <th>Endpoint Communication Email</th>
                            <th style="width: 140px; text-align:center;">Role Clearence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($user = $users->fetch_assoc()){ ?>
                            <tr>
                                <td class="text-muted font-monospace fw-bold">#<?= $user['id'] ?></td>
                                <td class="fw-bold text-dark"><?= htmlspecialchars($user['fullname']) ?></td>
                                <td class="text-muted small font-monospace"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3 py-1.5 font-monospace text-uppercase fw-bold <?= $user['role'] == 'admin' ? 'bg-danger-subtle text-danger border border-danger' : 'bg-primary-subtle text-primary border border-primary' ?>" style="font-size: 11px;">
                                        <?= htmlspecialchars($user['role']) ?>
                                    </span>
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