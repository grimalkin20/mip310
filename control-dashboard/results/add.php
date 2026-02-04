<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$page_title = "Upload Results";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo getAssetUrl('css/style.css'); ?>" rel="stylesheet">
</head>

<body data-theme="light">
    <div class="admin-layout">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/mip310/control-dashboard/includes/sidebar.php'; ?>
        <div class="main-content">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/mip310/control-dashboard/includes/header.php'; ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card shadow-sm">
                                <div
                                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i>Upload Examination Result
                                    </h5>
                                    <a href="index.php" class="btn btn-sm btn-light">
                                        <i class="fas fa-list me-1"></i>Manage Results
                                    </a>
                                </div>
                                <div class="card-body">
                                    <form id="uploadResultForm" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="course" class="form-label">Course <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="course" name="course" required>
                                                    <option value="" selected disabled>Select Course</option>
                                                    <option value="D.Pharma">D.Pharma</option>
                                                    <option value="B.Pharma">B.Pharma</option>
                                                    <option value="M.Pharma">M.Pharma</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="year" class="form-label">Year <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="year" name="year"
                                                    placeholder="e.g. 2024" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="semester" class="form-label">Semester / Part <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="semester" name="semester" required>
                                                    <option value="" selected disabled>Select Semester/Part</option>
                                                    <option value="Part I">Part I</option>
                                                    <option value="Part II">Part II</option>
                                                    <option value="Sem I">Sem I</option>
                                                    <option value="Sem II">Sem II</option>
                                                    <option value="Sem III">Sem III</option>
                                                    <option value="Sem IV">Sem IV</option>
                                                    <option value="Sem V">Sem V</option>
                                                    <option value="Sem VI">Sem VI</option>
                                                    <option value="Sem VII">Sem VII</option>
                                                    <option value="Sem VIII">Sem VIII</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="result_type" class="form-label">Result Type <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="result_type" name="result_type"
                                                    required>
                                                    <option value="Regular" selected>Regular</option>
                                                    <option value="Supplementary">Supplementary</option>
                                                    <option value="Revaluation">Revaluation</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="result_file" class="form-label">Result File (PDF Only) <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="file" id="result_file" name="result_file"
                                                accept=".pdf" required>
                                            <div class="form-text text-muted">Maximum file size: 10MB</div>
                                        </div>

                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="reset" class="btn btn-outline-secondary">Reset Form</button>
                                            <button type="submit" class="btn btn-primary px-5" id="submitBtn">
                                                <span id="btnText"><i class="fas fa-cloud-upload-alt me-2"></i>Upload
                                                    Result</span>
                                                <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"
                                                    role="status"></span>
                                            </button>
                                        </div>
                                    </form>

                                    <div id="responseMessage" class="mt-4 d-none"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const uploadForm = document.getElementById('uploadResultForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const responseMessage = document.getElementById('responseMessage');

            uploadForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Basic frontend validation
                const fileInput = document.getElementById('result_file');
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    if (file.type !== 'application/pdf') {
                        showMsg('Error: Only PDF files are allowed', 'danger');
                        return;
                    }
                    if (file.size > 10 * 1024 * 1024) {
                        showMsg('Error: File size exceeds 10MB limit', 'danger');
                        return;
                    }
                }

                // Show loading state
                submitBtn.disabled = true;
                btnText.classList.add('d-none');
                btnSpinner.classList.remove('d-none');
                responseMessage.classList.add('d-none');

                const formData = new FormData(uploadForm);

                fetch('../api/upload-result.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showMsg(data.message, 'success');
                            uploadForm.reset();
                        } else {
                            showMsg(data.message, 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMsg('Something went wrong. Please try again.', 'danger');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        btnText.classList.remove('d-none');
                        btnSpinner.classList.add('d-none');
                    });
            });

            function showMsg(msg, type) {
                responseMessage.innerHTML = `<div class="alert alert-${type} shadow-sm border-0 d-flex align-items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                <div>${msg}</div>
            </div>`;
                responseMessage.classList.remove('d-none');
            }
        });
    </script>
</body>

</html>