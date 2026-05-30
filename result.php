<?php
include 'includes/auth.php';
$score = $_SESSION['final_score'] ?? 0;
$total = $_SESSION['final_total'] ?? 1;
$percentage = ($score / $total) * 100;
$passed = $percentage >= 50;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Analysis Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container my-5" style="max-width: 600px;">
    <div class="card card-modern overflow-hidden">
        <div class="p-4 p-sm-5 text-center">
            <h3 class="fw-bold text-dark mb-2">Performance Summary</h3>
            <p class="text-muted small">Exit examination scorecard tracking logs metrics pipeline</p>

            <div class="d-inline-flex align-items-center justify-content-center my-4 position-relative" style="width: 150px; height: 150px;">
                <div class="position-absolute w-100 h-100 rounded-circle border border-5 opacity-25 <?= $passed ? 'border-success' : 'border-danger' ?>"></div>
                <div>
                    <h2 class="display-5 fw-bold m-0 tracking-tight"><?= round($percentage, 1) ?>%</h2>
                    <small class="text-uppercase text-muted fw-bold tracking-wider d-block" style="font-size: 9px;">Score Index</small>
                </div>
            </div>

            <div class="row g-2 bg-light rounded-3 p-3 my-4">
                <div class="col-6 border-end">
                    <span class="text-muted small d-block">Correct Computations</span>
                    <span class="fs-3 fw-bold text-dark"><?= $score ?></span>
                </div>
                <div class="col-6">
                    <span class="text-muted small d-block">Total Items Run</span>
                    <span class="fs-3 fw-bold text-dark"><?= $total ?></span>
                </div>
            </div>

            <?php if($passed){ ?>
                <div class="alert alert-success border-0 py-3 fw-bold text-uppercase tracking-wider small mb-4">
                    🎉 Evaluation Outcome: PASS / VERIFIED
                </div>
            <?php } else { ?>
                <div class="alert alert-danger border-0 py-3 fw-bold text-uppercase tracking-wider small mb-4">
                    ⚠️ Evaluation Outcome: UNSATISFACTORY / FAILS CRITERIA
                </div>
            <?php } ?>

            <div class="d-grid gap-2 pt-2">
                <a href="select_exam.php" class="btn btn-modern-primary py-2.5 fw-semibold">Initialize New Test Session</a>
                <a href="dashboard.php" class="btn btn-outline-secondary py-2.5 fw-medium" style="border-radius: var(--radius-sm);">Return to Home Hub</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>