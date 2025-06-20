<?php
session_start();
require '../config/db.php';
require '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'tester') {
    header("Location: ../pages/login.php");
    exit();
}

$users = getAllUsers($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report New Bug</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../dashboard/navbar.php'; ?>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Report New Bug</h4>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="./operations/bug_create.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="reported_by" value="<?= $_SESSION['user_id'] ?>">

                            <!-- Rest of your form fields remain the same -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" required 
                                               placeholder="Brief description of the issue" maxlength="255">
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="description" name="description" rows="6" required
                                                  placeholder="Detailed explanation of the bug"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="steps_to_reproduce" class="form-label">Steps to Reproduce</label>
                                        <textarea class="form-control" id="steps_to_reproduce" name="steps_to_reproduce" rows="4"
                                                  placeholder="Step-by-step instructions to recreate the issue"></textarea>
                                    </div>

                                   
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-0 shadow-none">
                                        <div class="card-body">
                                            <h5 class="mb-3">Bug Details</h5>

                                            <div class="mb-3">
                                                <label for="severity" class="form-label">Severity <span class="text-danger">*</span></label>
                                                <select class="form-select" id="severity" name="severity" required>
                                                    <option value="">Select Severity</option>
                                                    <option value="Critical">Critical</option>
                                                    <option value="High">High</option>
                                                    <option value="Medium" selected>Medium</option>
                                                    <option value="Low">Low</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="priority" class="form-label">Priority</label>
                                                <select class="form-select" id="priority" name="priority">
                                                    <option value="High">High</option>
                                                    <option value="Medium" selected>Medium</option>
                                                    <option value="Low">Low</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="assigned_to" class="form-label">Assign To</label>
                                                <select class="form-select" id="assigned_to" name="assigned_to">
                                                    <option value="">Unassigned</option>
                                                    <?php foreach ($users as $user): ?>
                                                        <?php if ($user['role'] === 'developer' || $user['role'] === 'manager'): ?>
                                                            <option value="<?= $user['id'] ?>">
                                                                <?= htmlspecialchars($user['username']) ?> (<?= $user['role'] ?>)
                                                            </option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="due_date" class="form-label">Due Date</label>
                                                <input type="date" class="form-control" id="due_date" name="due_date" 
                                                       min="<?= date('Y-m-d') ?>">
                                            </div>

                                            <div class="d-grid mt-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Submit Bug Report
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>