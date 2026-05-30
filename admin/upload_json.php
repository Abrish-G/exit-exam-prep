<?php
include '../includes/admin_auth.php';
include '../includes/db.php';

$message = "";

if (isset($_POST['upload']) && isset($_FILES['json_file'])) {

    $label = trim($_POST['label']); // e.g. "2026 exam"
    $file = $_FILES['json_file']['tmp_name'];
    $jsonData = file_get_contents($file);
    $questions = json_decode($jsonData, true);

    if (json_last_error() === JSON_ERROR_NONE && is_array($questions)) {
        foreach ($questions as $q) {
            // 1. COURSE AUTO CREATE / FETCH
            $course_name = $q['course'];

            $stmt = $conn->prepare("SELECT id FROM courses WHERE course_name=?");
            $stmt->bind_param("s", $course_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $course_id = $result->fetch_assoc()['id'];
            } else {
                $stmt = $conn->prepare("INSERT INTO courses(course_name) VALUES(?)");
                $stmt->bind_param("s", $course_name);
                $stmt->execute();
                $course_id = $stmt->insert_id;
            }

            // 2. OPTIONS PARSE
            $options = $q['options'];
            $question = $q['question'];
            $a = $options['A'];
            $b = $options['B'];
            $c = $options['C'];
            $d = $options['D'];
            $answer = $q['answer'];
            $explanation = $q['explanation'];

            // 3. CHECK IF EXISTS (MERGE)
            $check = $conn->prepare("
                SELECT id FROM questions
                WHERE label=? AND course_id=? AND question=?
            ");
            $check->bind_param("sis", $label, $course_id, $question);
            $check->execute();
            $existing = $check->get_result();

            if ($existing->num_rows > 0) {
                // UPDATE existing (MERGE)
                $id = $existing->fetch_assoc()['id'];

                $update = $conn->prepare("
                    UPDATE questions
                    SET option_a=?, option_b=?, option_c=?, option_d=?, answer=?, explanation=?
                    WHERE id=?
                ");
                $update->bind_param("ssssssi", $a, $b, $c, $d, $answer, $explanation, $id);
                $update->execute();
            } else {
                // INSERT new
                $insert = $conn->prepare("
                    INSERT INTO questions
                    (course_id, label, question, option_a, option_b, option_c, option_d, answer, explanation)
                    VALUES (?,?,?,?,?,?,?,?,?)
                ");
                $insert->bind_param("issssssss", $course_id, $label, $question, $a, $b, $c, $d, $answer, $explanation);
                $insert->execute();
            }
        }
        $message = "Upload '$label' processed successfully (merged where needed).";
    } else {
        $message = "Invalid JSON format.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload JSON Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #334155;
        }
        .form-card {
            background: #ffffff;
            border-radius: 16px;
            border: none;
        }
        /* Custom styled drag-and-drop file containment block */
        .file-drop-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background-color: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            position: relative;
        }
        .file-drop-zone:hover {
            border-color: #6366f1;
            background-color: #eef2ff;
        }
        .file-drop-zone input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .upload-icon {
            font-size: 2.5rem;
            color: #94a3b8;
            margin-bottom: 0.75rem;
            display: inline-block;
            transition: color 0.2s ease;
        }
        .file-drop-zone:hover .upload-icon {
            color: #6366f1;
        }
        .btn-indigo {
            background-color: #4f46e5;
            color: white;
            font-weight: 500;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .btn-indigo:hover {
            background-color: #4338ca;
            color: white;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            
            <div class="card form-card shadow-lg p-4 p-md-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark m-0">Upload Question Dataset</h3>
                    <p class="text-muted small mt-1">Import or automatically merge structured question sheets into the active database.</p>
                </div>

                <?php if ($message) { ?>
                    <div class="alert alert-info border-0 shadow-sm p-3 rounded-3 mb-4 text-center <?= strpos($message, 'successfully') !== false ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>">
                        <?= $message ?>
                    </div>
                <?php } ?>

                <form method="POST" enctype="multipart/form-data">

                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark small">Dataset Label</label>
                        <input type="text" 
                               name="label" 
                               class="form-control form-control-lg fs-6 rounded-3 border-secondary-subtle" 
                               placeholder="e.g. 2026 exit exam" 
                               required>
                        <div class="form-text text-muted small">This identifier maps individual matrix items directly back to a custom dataset block.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark small">Select Target Matrix File</label>
                        <div class="file-drop-zone">
                            <span class="upload-icon">📂</span>
                            <h6 class="fw-semibold text-dark m-0" id="file-label-text">Choose JSON file or drag here</h6>
                            <p class="text-muted small m-0 mt-1">Only files matching explicit structured <code>.json</code> schemas are permitted.</p>
                            <input type="file" name="json_file" accept=".json" id="file-input" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-indigo w-100 border-0 mt-2 fs-6 shadow-sm" name="upload">
                        ✨ Start Batch Process Execution
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
    // File upload field contextual string synchronization layer
    const fileInput = document.getElementById('file-input');
    const labelText = document.getElementById('file-label-text');

    fileInput.addEventListener('change', function(e) {
        if(e.target.files.length > 0) {
            labelText.innerText = `Selected: ${e.target.files[0].name}`;
            labelText.style.color = '#4f46e5';
        } else {
            labelText.innerText = "Choose JSON file or drag here";
            labelText.style.color = '';
        }
    });
</script>
</body>
</html>