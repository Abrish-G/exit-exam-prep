<?php
include 'includes/auth.php'; 
$questions = $_SESSION['exam_questions']; 
$mode = $_SESSION['exam_mode']; 
$exam_duration_minutes = 180; 
/**
 * Flags if a string payload contains block-level structures or syntax indicators
 * so we can isolate it into a code block layout container.
 */
function identify_content_type($text) { 
    if (strpos($text, '{') !== false && (strpos($text, ';') !== false || strpos($text, '}') !== false)) { 
        return 'contains-code'; 
    } 
    return 'standard-text'; 
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Assessment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-tomorrow.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    :root {
        --primary-accent: #4f46e5;
        --primary-accent-hover: #4338ca;
        --bg-light-gray: #f8fafc;
        --card-border: #e2e8f0;
    }

    body {
        background-color: var(--bg-light-gray);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #1e293b;
    }

    /* Isolate Dark Mode theme rules exclusively to assessment code blocks */
    pre.isolated-dark-code-block {
        background: #0f172a !important;
        border: 1px solid #1e293b !important;
        border-radius: 12px !important;
        padding: 18px !important;
        margin: 16px 0 !important;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        overflow-x: auto;
    }

    pre.isolated-dark-code-block code {
        font-family: 'Fira Code', 'Cascadia Code', Consolas, Monaco, monospace !important;
        font-size: 0.9rem !important;
        color: #f1f5f9 !important;
        text-shadow: none !important;
        white-space: pre-wrap !important;
        word-break: break-all !important;
    }

    .assessment-text-container {
        white-space: pre-wrap;
        line-height: 1.6;
        font-size: 1.1rem;
    }

    /* Polished Interactive MCQ Row Wrapper */
    .option-wrapper {
        border: 1px solid var(--card-border);
        background-color: #fff;
        transition: all 0.2s ease-in-out;
        margin-bottom: 0.75rem;
        padding: 12px 16px !important;
        border-radius: 10px;
        position: relative;
    }

    .option-wrapper:hover {
        border-color: #cbd5e1;
        background-color: #fcfdfe;
        transform: translateY(-1px);
    }

    .option-radio {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0;
        cursor: pointer;
        border: 2px solid #cbd5e1;
    }

    .option-radio:checked {
        background-color: var(--primary-accent);
        border-color: var(--primary-accent);
    }

    .sticky-bottom-panel {
        position: sticky;
        bottom: 0;
        z-index: 1020;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        border-top: 1px solid var(--card-border);
    }

    .btn-custom-danger {
        background-color: #ef4444;
        color: white;
        transition: all 0.2s ease;
    }

    .btn-custom-danger:hover {
        background-color: #dc2626;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }

    .question-footnote {
        font-size: 0.8rem;
        color: #64748b;
        border-top: 1px dashed #e2e8f0;
        padding-top: 0.5rem;
    }

    /* Interactive tracking grid transitions */
    .grid-matrix-cell {
        transition: all 0.15s ease-in-out;
        min-width: 0;
        /* Prevents text overflow breaking grid cell dimensions */
    }

    .grid-matrix-cell:hover {
        transform: scale(1.1);
        z-index: 2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
    }
    </style>
</head>

<body>

    <div class="container-fluid my-4 my-md-5 px-lg-4 px-xl-5">
        <div class="row g-4 position-relative">

            <div class="col-12 col-lg-7 col-xl-8">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 w-100">

    <div>
        <h4 class="fw-bold m-0 text-dark">
            Assessment In Progress
        </h4>

        <p class="text-muted small m-0 mt-1">
            Total allocated dataset depth:
            <span class="fw-semibold text-dark">
                <?= count($questions) ?> Items
            </span>
        </p>
    </div>

    <?php if($mode == 'exam'){ ?>
        <div class="text-end">
            <div class="badge bg-danger fs-6 px-3 py-2">
                 <span id="examTimer">00:00:00</span>
            </div>
        </div>
    <?php } ?>

</div>

                <form method="POST" action="submit_exam.php" id="assessmentForm">
                    <?php foreach($questions as $index => $q){ 
                    $qType = identify_content_type($q['question']);
                ?>
                    <div class="card mb-4 shadow-sm border-0 bg-white rounded-3 overflow-hidden question-card-element"
                        id="question_anchor_<?= $index ?>" data-index="<?= $index ?>">
                        <div class="card-header bg-white pt-4 px-4 border-0 pb-0">
                            <span
                                class="badge bg-slate-100 text-secondary border px-2.5 py-1.5 mb-2 rounded-2 fw-medium">Item
                                <?= $index + 1 ?></span>
                            <h5 class="fw-semibold text-slate-800 assessment-text-container render-math-target m-0 mt-1"
                                data-content-type="<?= $qType ?>"><?= htmlspecialchars($q['question']) ?></h5>
                        </div>

                        <div class="card-body px-4 pt-3 pb-4">
                            <div class="options-group d-flex flex-column">
                                <?php
                                $options = [
                                    'A' => $q['option_a'],
                                    'B' => $q['option_b'],
                                    'C' => $q['option_c'],
                                    'D' => $q['option_d']
                                ];
                                foreach($options as $key => $value){ 
                                    $option_id = "q_" . $q['id'] . "_" . $key;
                                ?>
                                <label class="form-check option-wrapper d-flex align-items-start m-0 mb-2"
                                    style="cursor: pointer;" for="<?= $option_id ?>">
                                    <input
                                        class="form-check-input option-radio flex-shrink-0 mt-1 me-3 align-self-center"
                                        type="radio" name="answers[<?= $q['id'] ?>]" value="<?= $key ?>"
                                        id="<?= $option_id ?>" data-question-index="<?= $index ?>"
                                        data-correct="<?= htmlspecialchars($q['answer']) ?>">

                                    <span
                                        class="d-none dynamic-explanation-source"><?= htmlspecialchars($q['explanation']) ?></span>

                                    <span class="form-check-label py-0.5 render-math-target text-secondary-emphasis"
                                        data-content-type="standard-text">
                                        <strong class="text-dark me-1"><?= $key ?>.</strong>
                                        <?= htmlspecialchars($value) ?>
                                    </span>
                                </label>
                                <?php } ?>
                            </div>

                            <?php if(!empty($q['course_name'])){ ?>
                            <div class="question-footnote mt-3 d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-muted">
                                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z" />
                                    <path d="M6 6h10M6 10h10" />
                                </svg>
                                <span>Course: <span
                                        class="fw-medium text-dark"><?= htmlspecialchars($q['course_name']) ?></span></span>
                            </div>
                            <?php } ?>

                            <?php if($mode == 'prep'){ ?>
                            <div class="result-box mt-2"></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if($mode == 'exam'){ ?>
                    <div class="p-3 sticky-bottom-panel rounded-3 shadow mt-5 mb-4 border border-light">
                        <button type="submit" class="btn btn-custom-danger w-100 py-3 fw-bold fs-5 rounded-3 border-0">
                            Submit Examination
                        </button>
                    </div>
                    <?php } ?>
                </form>
            </div>

            <div class="col-12 col-lg-5 col-xl-4">
                <div class="card shadow-sm border-0 sticky-top rounded-3 bg-white"
                    style="top: 24px; max-height: calc(100vh - 48px); overflow-y: auto;">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <h5 class="fw-bold m-0 text-dark">Answer Sheet Matrix</h5>
                        <p class="text-muted small m-0 mt-1">Click a cell item block to view or jump back to its
                            section.</p>
                    </div>

                    <div class="card-body px-3 px-sm-4 pb-4 pt-2">
                        <?php if($mode == 'prep') { ?>
                        <div
                            class="p-3 mb-3 bg-light rounded-3 d-flex justify-content-between align-items-center border border-light">
                            <div>
                                <span class="text-muted d-block small text-uppercase tracking-wider fw-bold"
                                    style="font-size:0.7rem;">Live Score Tracker</span>
                                <h3 class="m-0 fw-extrabold text-primary" id="liveScoreCounter">0 <span
                                        class="fs-6 text-muted fw-normal">/ <?= count($questions) ?></span></h3>
                            </div>
                            <div class="text-end">
                                <span
                                    class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 mb-1 d-inline-block"
                                    style="font-size:0.75rem;">Correct: <span id="liveCorrectCount">0</span></span>
                                <br>
                                <span
                                    class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 d-inline-block"
                                    style="font-size:0.75rem;">Wrong: <span id="liveIncorrectCount">0</span></span>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="d-grid gap-1" style="grid-template-columns: repeat(10, 1fr);">
                            <?php foreach($questions as $index => $q){ ?>
                            <button type="button"
                                class="btn btn-light border p-0 d-flex flex-column align-items-center justify-content-center grid-matrix-cell"
                                style="aspect-ratio: 1 / 1; font-size: 0.75rem; border-radius: 6px; font-weight: 700; min-height: 38px;"
                                id="matrix_cell_<?= $index ?>" title="Question <?= $index + 1 ?>"
                                onclick="scrollToQuestion(<?= $index ?>)">
                                <span class="text-muted opacity-70 font-monospace d-block mb-n1"
                                    style="font-size: 0.58rem; transform: scale(0.9);"><?= $index + 1 ?></span>
                                <span class="selected-token-label text-dark fs-6 font-monospace"
                                    style="font-size: 0.85rem;">-</span>
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/contrib/auto-render.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-core.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        const isPrepMode = <?= json_encode($mode === 'prep') ?>;

        // 1. GRID INTERACTION: VIEWPORT ANCHOR ENGINE WITH POSITION OVERLAYS
        window.scrollToQuestion = function(index) {
            const targetElement = document.getElementById(`question_anchor_${index}`);
            if (targetElement) {
                const offset = 24;
                const bodyRect = document.body.getBoundingClientRect().top;
                const elementRect = targetElement.getBoundingClientRect().top;
                const elementPosition = elementRect - bodyRect;
                const offsetPosition = elementPosition - offset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                // Subtle flash highlight overlay focus effect
                targetElement.style.transition = "all 0.15s ease";
                targetElement.style.boxShadow = "0 0 0 4px rgba(79, 70, 229, 0.35)";
                setTimeout(() => {
                    targetElement.style.boxShadow = "";
                }, 600);
            }
        };

        // 2. DATA EXTRACTION ENGINE (Wraps target code strings inside custom markup)
        function parseDatabaseCodeBlocks() {
            document.querySelectorAll('.render-math-target').forEach(block => {
                if (block.getAttribute('data-content-type') === 'contains-code') {
                    let rawCodeText = block.textContent || block.innerText;
                    block.innerHTML =
                        `<pre class="isolated-dark-code-block language-clike"><code class="language-clike">${escapeHtml(rawCodeText)}</code></pre>`;
                    block.classList.remove('fw-bold');
                }
            });
        }

        function escapeHtml(text) {
            return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
        }

        try {
            parseDatabaseCodeBlocks();
        } catch (e) {
            console.error("Code Block transformation matrix error:", e);
        }

        // 3. RENDERING COMPILER SEQUENCES (KaTeX Math + Prism Highlight Sync)
        function initializeSyntaxAndMathParsers(targetContainer = document.body) {
            if (typeof renderMathInElement === 'function') {
                renderMathInElement(targetContainer, {
                    delimiters: [{
                            left: '$$',
                            right: '$$',
                            display: true
                        },
                        {
                            left: '$',
                            right: '$',
                            display: false
                        },
                        {
                            left: '\\(',
                            right: '\\)',
                            display: false
                        },
                        {
                            left: '\\[',
                            right: '\\]',
                            display: true
                        }
                    ],
                    throwOnError: false
                });
            }
        }

        setTimeout(() => {
            initializeSyntaxAndMathParsers();
            if (typeof Prism !== 'undefined') {
                Prism.highlightAll();
            }
        }, 200);

        // 4. METRIC SCORE ENGINE UPDATER (Prep Mode Metric Compilation)
        function updateLiveScoreMetrics() {
            if (!isPrepMode) return;

            let totalCorrect = 0;
            let totalIncorrect = 0;

            document.querySelectorAll('.question-card-element').forEach(card => {
                const checkedRadio = card.querySelector('.option-radio:checked');
                if (checkedRadio) {
                    if (checkedRadio.value === checkedRadio.dataset.correct) {
                        totalCorrect++;
                    } else {
                        totalIncorrect++;
                    }
                }
            });

            const scoreElement = document.getElementById('liveScoreCounter');
            const correctElement = document.getElementById('liveCorrectCount');
            const incorrectElement = document.getElementById('liveIncorrectCount');

            if (scoreElement) scoreElement.innerHTML =
                `${totalCorrect} <span class="fs-6 text-muted fw-normal">/ ${document.querySelectorAll('.question-card-element').length}</span>`;
            if (correctElement) correctElement.innerText = totalCorrect;
            if (incorrectElement) incorrectElement.innerText = totalIncorrect;
        }

        // 5. INTERACTIVE MCQ SELECTION & TRACKING COUPLING HANDLERS
        document.querySelectorAll('.option-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                let parent = this.closest('.card-body');
                let resultBox = parent.querySelector('.result-box');
                let selected = this.value;
                let correct = this.dataset.correct;
                let qIndex = this.dataset.questionIndex;

                let explanation = this.closest('.option-wrapper').querySelector(
                    '.dynamic-explanation-source').innerHTML;

                parent.querySelectorAll('.option-wrapper').forEach(el => {
                    el.style.borderColor = "#e2e8f0";
                    el.style.backgroundColor = "#ffffff";
                });

                this.closest('.option-wrapper').style.borderColor = "#4f46e5";
                this.closest('.option-wrapper').style.backgroundColor = "#f5f3ff";

                // SQUASH SELECTION INTO THE 10x10 TARGET SHEET GRID CELL
                const trackingCell = document.getElementById(`matrix_cell_${qIndex}`);
                const tokenLabel = trackingCell.querySelector('.selected-token-label');
                tokenLabel.innerText = selected;

                if (isPrepMode) {
                    if (selected == correct) {
                        // Correct Matrix Cell Styling Override: Emerald Green Background
                        trackingCell.className =
                            "btn p-0 d-flex flex-column align-items-center justify-content-center grid-matrix-cell text-white border-0";
                        trackingCell.style.backgroundColor = "#10b981";
                        tokenLabel.className = "selected-token-label text-white fw-extrabold";

                        resultBox.innerHTML = `
                        <div class="alert alert-success border-0 shadow-sm mt-3 p-3 d-flex align-items-start gap-3 rounded-3" style="background-color: #f0fdf4; border: 1px solid #bbf7d0 !important;">
                            <span class="fs-4 lh-1">✅</span>
                            <div>
                                <strong class="d-block mb-1 text-success-emphasis">Excellent job! Correct Answer.</strong>
                                <div class="opacity-90 runtime-render-math text-secondary small">${explanation}</div>
                            </div>
                        </div>
                    `;
                    } else {
                        // Incorrect Answer State: Highlights red on tracking cell + counter calculation engine refresh
                        trackingCell.className =
                            "btn p-0 d-flex flex-column align-items-center justify-content-center grid-matrix-cell text-white border-0";
                        trackingCell.style.backgroundColor = "#ef4444";
                        tokenLabel.className = "selected-token-label text-white fw-extrabold";

                        resultBox.innerHTML = `
                        <div class="alert alert-danger border-0 shadow-sm mt-3 p-3 d-flex align-items-start gap-3 rounded-3" style="background-color: #fef2f2; border: 1px solid #fecaca !important;">
                            <span class="fs-4 lh-1">❌</span>
                            <div>
                                <strong class="d-block mb-1 text-danger-emphasis">Incorrect Response.</strong>
                                <div class="mb-2 small text-dark">Target value key identification: <span class="badge bg-danger rounded-2 px-2 py-1">${correct}</span></div>
                                <div class="opacity-90 runtime-render-math text-secondary small">${explanation}</div>
                            </div>
                        </div>
                    `;
                    }

                    updateLiveScoreMetrics();

                    const explanationBlock = resultBox.querySelector('.runtime-render-math');
                    if (explanation.includes('{') && explanation.includes(';')) {
                        let textRaw = explanationBlock.textContent || explanationBlock
                        .innerText;
                        explanationBlock.innerHTML =
                            `<pre class="isolated-dark-code-block language-clike"><code class="language-clike">${escapeHtml(textRaw)}</code></pre>`;
                        if (typeof Prism !== 'undefined') {
                            Prism.highlightAll();
                        }
                    } else {
                        initializeSyntaxAndMathParsers(resultBox);
                    }
                } else {
                    // Regular Exam Mode Layout Actions (Quiet validation without answer keys leaky triggers)
                    trackingCell.className =
                        "btn text-white border-0 p-0 d-flex flex-column align-items-center justify-content-center grid-matrix-cell";
                    trackingCell.style.backgroundColor = "#4f46e5";
                    tokenLabel.className = "selected-token-label text-white fw-bold";
                }
            });
        });

        // ======================================
        // EXAM TIMER
        // ======================================
        if (!isPrepMode) {

            const endTime =
                Date.now() +
                (<?= (int)$exam_duration_minutes ?> * 60 * 1000);

            function updateExamTimer() {

                let remaining =
                    Math.floor((endTime - Date.now()) / 1000);

                if (remaining <= 0) {

                    alert("Time is up. Your exam will now be submitted.");

                    document
                        .getElementById("assessmentForm")
                        .submit();

                    return;
                }

                const hours =
                    Math.floor(remaining / 3600);

                const minutes =
                    Math.floor((remaining % 3600) / 60);

                const seconds =
                    remaining % 60;

                document.getElementById("examTimer").textContent =
                    String(hours).padStart(2, "0") + ":" +
                    String(minutes).padStart(2, "0") + ":" +
                    String(seconds).padStart(2, "0");
            }

            updateExamTimer();
            setInterval(updateExamTimer, 1000);
        }
    });
    </script>
</body>

</html>