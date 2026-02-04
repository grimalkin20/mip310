<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

requireLogin();

$page_title = "Manage Results";

// Fetch results
$results = [];
$query = "SELECT * FROM results ORDER BY created_at DESC";
$res = $conn->query($query);
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $results[] = $row;
    }
}
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
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div
                                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Manage Examination Results</h5>
                                    <a href="add.php" class="btn btn-sm btn-light">
                                        <i class="fas fa-plus me-1"></i>Upload New Result
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Course</th>
                                                    <th>Year</th>
                                                    <th>Sem/Part</th>
                                                    <th>Type</th>
                                                    <th>Date Uploaded</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($results)): ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4 text-muted">
                                                            <i class="fas fa-info-circle me-2"></i>No results found. Start
                                                            by uploading one!
                                                        </td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($results as $result): ?>
                                                        <tr id="row-<?php echo $result['id']; ?>">
                                                            <td><?php echo $result['id']; ?></td>
                                                            <td><span
                                                                    class="badge bg-info text-dark"><?php echo $result['course']; ?></span>
                                                            </td>
                                                            <td><?php echo $result['year']; ?></td>
                                                            <td><?php echo $result['semester']; ?></td>
                                                            <td><?php echo $result['result_type']; ?></td>
                                                            <td><?php echo date('d M Y', strtotime($result['created_at'])); ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="../../<?php echo $result['file_path']; ?>"
                                                                        class="btn btn-outline-primary" target="_blank"
                                                                        title="View PDF">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <button class="btn btn-outline-info edit-btn"
                                                                        data-id="<?php echo $result['id']; ?>"
                                                                        data-course="<?php echo $result['course']; ?>"
                                                                        data-year="<?php echo $result['year']; ?>"
                                                                        data-semester="<?php echo $result['semester']; ?>"
                                                                        data-type="<?php echo $result['result_type']; ?>"
                                                                        title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button class="btn btn-outline-danger delete-btn"
                                                                        data-id="<?php echo $result['id']; ?>" title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Result Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="editResultForm" enctype="multipart/form-data">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Result Information</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_course" class="form-label">Course</label>
                            <select class="form-select" id="edit_course" name="course" required>
                                <option value="D.Pharma">D.Pharma</option>
                                <option value="B.Pharma">B.Pharma</option>
                                <option value="M.Pharma">M.Pharma</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="edit_year" name="year" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_semester" class="form-label">Semester / Part</label>
                            <select class="form-select" id="edit_semester" name="semester" required>
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
                        <div class="mb-3">
                            <label for="edit_result_type" class="form-label">Result Type</label>
                            <select class="form-select" id="edit_result_type" name="result_type" required>
                                <option value="Regular">Regular</option>
                                <option value="Supplementary">Supplementary</option>
                                <option value="Revaluation">Revaluation</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_result_file" class="form-label">Change PDF (Optional)</label>
                            <input class="form-control" type="file" id="edit_result_file" name="result_file"
                                accept=".pdf">
                            <div class="form-text">Leave blank to keep existing file.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info text-white" id="editSubmitBtn">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this result? This action cannot be undone and the file will be
                        permanently removed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Permanently</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo getAssetUrl('js/admin.js'); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Edit Functionality
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            const editForm = document.getElementById('editResultForm');

            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('edit_id').value = this.dataset.id;
                    document.getElementById('edit_course').value = this.dataset.course;
                    document.getElementById('edit_year').value = this.dataset.year;
                    document.getElementById('edit_semester').value = this.dataset.semester;
                    document.getElementById('edit_result_type').value = this.dataset.type;
                    editModal.show();
                });
            });

            editForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const submitBtn = document.getElementById('editSubmitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

                const formData = new FormData(editForm);
                fetch('../api/edit-result.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong. Please try again.');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerText = 'Save Changes';
                    });
            });

            // Delete Functionality
            let resultIdToDelete = null;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    resultIdToDelete = this.getAttribute('data-id');
                    deleteModal.show();
                });
            });

            confirmDeleteBtn.addEventListener('click', function () {
                if (!resultIdToDelete) return;

                confirmDeleteBtn.disabled = true;
                confirmDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Deleting...';

                fetch('../api/delete-result.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${resultIdToDelete}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const row = document.getElementById(`row-${resultIdToDelete}`);
                            if (row) row.remove();
                            alert(data.message);
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                location.reload();
                            }
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong. Please try again.');
                    })
                    .finally(() => {
                        confirmDeleteBtn.disabled = false;
                        confirmDeleteBtn.innerText = 'Delete Permanently';
                        deleteModal.hide();
                        resultIdToDelete = null;
                    });
            });
        });
    </script>
</body>

</html>