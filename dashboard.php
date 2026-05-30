<?php include 'includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand navbar-light bg-white border-bottom py-3">
    <div class="container">
        <span class="navbar-brand fw-semibold text-dark fs-5 tracking-tight">
            <span class="text-primary-gradient fw-bold">◆</span> Exit Exam Portal
        </span>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-muted small d-none d-sm-inline">Account: <span class="fw-semibold text-dark"><?= htmlspecialchars($_SESSION['fullname']) ?></span></span>
            <a href="logout.php" class="btn btn-logout-modern">Sign Out</a>
        </div>
    </div>
</nav>

<div class="container py-5" style="max-width: 1000px;">
    
    <div class="dashboard-hero p-4 p-md-5 mb-5 rounded-4 position-relative overflow-hidden">
        <div class="position-relative z-1" style="max-width: 600px;">
            <span class="badge badge-accent mb-3">Academic Evaluation Module</span>
            <h1 class="display-6 fw-bold text-dark tracking-tight mb-2">Welcome back, <?= htmlspecialchars($_SESSION['fullname']) ?></h1>
            <p class="text-secondary m-0 fs-6">Select a runtime environment below to construct your question matrix and initiate your evaluation assessment.</p>
        </div>
        <div class="hero-bg-decoration"></div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card card-premium h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="icon-shape bg-primary-soft text-primary mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        </div>
                        <h4 class="fw-bold text-dark tracking-tight mb-2">Practice & Prep Mode</h4>
                        <p class="text-secondary small lh-relaxed mb-4">
                            Go through core curriculum targets at your own pace. Includes instantaneous feedback with descriptive answer answer keys and contextual review loops.
                        </p>
                    </div>
                    <a href="select_exam.php?default_mode=prep" class="btn btn-premium-primary w-100" >
                        Launch Practice Stream
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-premium h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="icon-shape bg-danger-soft text-danger mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <h4 class="fw-bold text-dark tracking-tight mb-2">Live Exam Simulation</h4>
                        <p class="text-secondary small lh-relaxed mb-4">
                            Simulate uniform graduation test environments. Builds a strict standard 100-question multi-course assessment pool with formal final review submission criteria.
                        </p>
                    </div>
                    <a href="select_exam.php?default_mode=exam" class="btn btn-premium-dark w-100">
                        Begin Live Simulation
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>