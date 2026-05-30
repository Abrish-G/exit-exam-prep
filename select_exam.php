<?php
include 'includes/auth.php';
include 'includes/db.php';

// Fetch courses ordered alphabetically exactly like your old code
$courses = $conn->query("SELECT * FROM courses ORDER BY course_name ASC");

// Fetch unique question dataset tags exactly like your old code
$labels = $conn->query("
    SELECT DISTINCT label 
    FROM questions 
    WHERE label IS NOT NULL 
    AND label != '' 
    ORDER BY label DESC
");

$pre_selected_mode = $_GET['default_mode'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configure Session Parameters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 680px;">

    <div class="mb-4">
        <a href="dashboard.php" class="text-muted text-decoration-none small d-inline-flex align-items-center gap-1">
            ← Back to Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4 p-sm-5">
            
            <div class="mb-4">
                <h3 class="fw-bold text-dark mb-1">Configure Assessment Parameters</h3>
                <p class="text-muted small">Establish evaluation behaviors and filter targeted curriculum clusters</p>
            </div>

            <form method="POST" action="start_exam.php">

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wider">Evaluation Profile</label>
                    <div class="row g-3">
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="mode" value="prep" id="mode_prep" autocomplete="off" required <?= $pre_selected_mode === 'prep' ? 'checked' : '' ?>>
                            <label class="btn w-100 p-3 text-start custom-grid-card" for="mode_prep">
                                <span class="d-block fw-bold text-dark mb-1 mode-title">Prep Mode</span>
                                <span class="text-muted d-block small lh-sm fw-normal">Dynamic Interactive Hints</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="mode" value="exam" id="mode_exam" autocomplete="off" required <?= $pre_selected_mode === 'exam' ? 'checked' : '' ?>>
                            <label class="btn w-100 p-3 text-start custom-grid-card" for="mode_exam">
                                <span class="d-block fw-bold text-dark mb-1 mode-title">Exam Mode</span>
                                <span class="text-muted d-block small lh-sm fw-normal">Graded Uniform Framework</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wider" for="label_select">Dataset Label</label>
                    <div class="position-relative">
                        <select name="label" id="label_select" class="form-select custom-select-premium py-2.5 px-3">
                            <option value="all">All Datasets (Randomized Global Pool)</option>
                            <?php while($label = $labels->fetch_assoc()){ ?>
                                <option value="<?= htmlspecialchars($label['label']) ?>">
                                    <?= htmlspecialchars($label['label']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-text text-muted small mt-2">Example: 2026 exam, 2025 mid, final mock, etc.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wider d-block mb-2">Course Module Targets</label>
                    
                    <div class="border rounded bg-white p-3 custom-scrollbar-box" style="max-height: 260px; overflow-y: auto;">
                        <?php while($course = $courses->fetch_assoc()){ ?>
                            <div class="form-check mb-2">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="courses[]" 
                                    value="<?= $course['id'] ?>" 
                                    id="course_<?= $course['id'] ?>"
                                >
                                <label class="form-check-label text-dark small fw-medium" for="course_<?= $course['id'] ?>">
                                    <?= htmlspecialchars($course['course_name']) ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-text text-muted small mt-2">Leaving courses unchecked uses all available courses.</div>
                </div>

                <div class="row g-3 pt-2 border-top mt-4">
                    <div class="col-6">
                        <a href="dashboard.php" class="btn btn-light border w-100 py-2 text-muted small fw-medium">
                            Cancel
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100 py-2 small fw-medium btn-brand-submit">
                            Construct Layout
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>