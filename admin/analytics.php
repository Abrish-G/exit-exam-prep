<?php
require_once '../includes/admin_auth.php';
require_once '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Diagnostic Analytics Pipeline</title>
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
            <a href="manage_users.php" class="sidebar-nav-link">👥 User Accounts</a>
            <a href="analytics.php" class="sidebar-nav-link active">📈 Metrics Stream</a>
        </div>
    </div>

    <div class="main-content-window p-3 p-sm-5">
        <div class="mb-4">
            <h2 class="fw-bold m-0 text-dark">Metrics Processing Pipeline</h2>
            <p class="text-muted small">Analyze system interaction trends and real-time performance logging streams.</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-modern p-5 text-center bg-white">
                    <div class="fs-1 mb-2 text-muted">📊</div>
                    <h5 class="fw-bold text-dark">Data Diagnostics Aggregator Engine</h5>
                    <p class="text-muted small mx-auto m-0" style="max-width: 480px;">Real-time grading matrices, trend tracking graphs, and distribution diagrams will stream here dynamically as platform exam telemetry data accumulates.</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>