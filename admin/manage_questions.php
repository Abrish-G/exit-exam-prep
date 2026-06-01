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
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="mobile-header">
    <div class="d-flex align-items-center gap-2 text-white fw-bold">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1.5rem; height:1.5rem; color: var(--primary-color);">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.827m11.379-8.16l1.15-.827M8.14 21.27l.707-1.03m7.45-.808l.707-1.03M12 3v1.5m0 15V21m4.743-10l-1.149-.827M7.365 5.835l-1.148-.827M18.293 8.293l-1.414 1.414M7.121 16.879l-1.414 1.414M12 12M12 12h.008v.008H12V12z" />
        </svg>
        <span>Admin Panel</span>
    </div>
    <button class="btn border-0 text-white p-1" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1.75rem; height:1.75rem;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>
</div>

<div class="admin-shell">
    <div class="collapse responsive-sidebar justify-content-between" id="sidebarMenu">
        <div>
            <div class="sidebar-brand-wrapper mb-3 mb-md-4 text-white d-none d-md-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1.5rem; height:1.5rem; color: var(--primary-color);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.827m11.379-8.16l1.15-.827M8.14 21.27l.707-1.03m7.45-.808l.707-1.03M12 3v1.5m0 15V21m4.743-10l-1.149-.827M7.365 5.835l-1.148-.827M18.293 8.293l-1.414 1.414M7.121 16.879l-1.414 1.414M12 12M12 12h.008v.008H12V12z" />
                </svg>
                <span>Admin Panel</span>
            </div>
            
            <div class="d-flex flex-column gap-1">
                <a href="dashboard.php" class="sidebar-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                    </svg>
                    Dashboard
                </a>
                <a href="manage_courses.php" class="sidebar-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    Courses
                </a>
                <a href="manage_questions.php" class="sidebar-nav-link active">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    Questions
                </a>
                <a href="manage_users.php" class="sidebar-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A12.48 12.48 0 0 1 6 18.719m0 0a8.967 8.967 0 0 1 3.741-.479 3 3 0 0 1-4.682-2.72m.94 3.198.002.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 0 12 21c2.17 0 4.207-.576 5.963-1.584A12.48 12.48 0 0 0 18 18.72m-12 0a9 9 0 0 0 12 0M12 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm7.428 3.58a3.36 3.36 0 0 0-3.428-3.58 3.36 3.36 0 0 0-3.428 3.58M4.572 15.58a3.36 3.36 0 0 1 3.428-3.58 3.36 3.36 0 0 1 3.428 3.58" />
                    </svg>
                    Users
                </a>
                <a href="analytics.php" class="sidebar-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>
                    Analytics
                </a>
            </div>
        </div>
        
        <div class="mt-4 pt-3 border-top border-secondary">
            <a href="../logout.php" class="sidebar-nav-link btn-modern-action btn-outline-danger-custom justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                Logout
            </a>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>