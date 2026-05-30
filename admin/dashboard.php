<?php include '../includes/admin_auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin System Terminal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="admin-shell">
    <div class="responsive-sidebar">
        <div class="sidebar-brand-wrapper mb-4">
            <span class="text-white">🛠️ Management Console</span>
        </div>
        <div class="d-flex flex-column gap-1">
            <a href="dashboard.php" class="sidebar-nav-link active">📊 System Overview</a>
            <a href="manage_courses.php" class="sidebar-nav-link">📚 Course Fields</a>
            <a href="manage_questions.php" class="sidebar-nav-link">📝 MCQ Repositories</a>
            <a href="manage_users.php" class="sidebar-nav-link">👥 User Accounts</a>
            <a href="analytics.php" class="sidebar-nav-link">📈 Metrics Stream</a>
            <a href="../logout.php" class="btn btn-sm btn-outline-danger w-100 mt-4 text-start d-flex align-items-center gap-2" style="border-radius: var(--radius-sm);">🚪 Disconnect Admin</a>
        </div>
    </div>

    <div class="main-content-window p-3 p-sm-5">
        <div class="row mb-5">
            <div class="col text-center text-md-start">
                <h1 class="fw-bold tracking-tight m-0">Administrative Hub</h1>
                <p class="text-muted">Maintain curriculum paths, import structured schema metrics, and monitor student accounts data paths.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-sm-6 col-lg-4">
                <div class="card card-modern h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="fs-2 mb-2 text-primary">📥</div>
                            <h5 class="fw-bold">Ingest JSON Dataset</h5>
                            <p class="text-muted small m-0">Bulk map externally parsed multi-choice arrays into standard table relational configurations smoothly.</p>
                        </div>
                        <a href="upload_json.php" class="btn btn-modern-primary w-100 mt-4">Parse Local Files</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card card-modern h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="fs-2 mb-2 text-warning">✏️</div>
                            <h5 class="fw-bold">Review MCQ Banks</h5>
                            <p class="text-muted small m-0">Audit system database records, drop invalid text entries, or isolate test objects safely.</p>
                        </div>
                        <a href="manage_questions.php" class="btn btn-dark w-100 mt-4" style="border-radius: var(--radius-sm);">Modify Matrix Records</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="card card-modern h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="fs-2 mb-2 text-success">📚</div>
                            <h5 class="fw-bold">Maintain Course Paths</h5>
                            <p class="text-muted small m-0">Register structural disciplines, modify subject targets, and attach metadata labels dynamically.</p>
                        </div>
                        <a href="manage_courses.php" class="btn btn-success w-100 mt-4" style="border-radius: var(--radius-sm);">Inspect Faculty Fields</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>