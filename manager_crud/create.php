<?php
include '../config/db.php';
include '../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: ../pages/login.php");
    exit();
}

function getAllUsers($conn) {
    $users = [];
    $query = "SELECT id, username FROM users ORDER BY username ASC";
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

$users = getAllUsers($conn);
include '../dashboard/common_header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Report New Bug</h5>
                    <a href="manager_dashboard.php" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Cancel
                    </a>
                </div>
                <div class="card-body">
                    <form action="../operations/bugs/create.php" method="POST">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description" rows="5" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="steps_to_reproduce" class="form-label">Steps to Reproduce</label>
                                    <textarea class="form-control" name="steps_to_reproduce" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body">
                                    <h6>Bug Details</h6>
                                    <div class="mb-3">
                                        <label for="severity" class="form-label">Severity <span class="text-danger">*</span></label>
                                        <select name="severity" class="form-select" required>
                                            <option value="">Select Severity</option>
                                            <option value="Critical">Critical</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="assigned_to" class="form-label">Assign To</label>
                                        <select name="assigned_to" class="form-select">
                                            <option value="">Unassigned</option>
                                            <?php foreach ($users as $user): ?>
                                                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="due_date" class="form-label">Due Date</label>
                                        <input type="date" class="form-control" name="due_date" min="<?= date('Y-m-d') ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-save me-1"></i> Create Bug
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../dashboard/common_footer.php'; ?>
