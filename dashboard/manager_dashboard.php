<?php include('../config/session.php'); ?>
<?php
include '../config/session.php';
include '../config/db.php';
require_once '../includes/functions.php';

$manager_id = $_SESSION['user_id'];
$bugs = getBugsReportedByUser($conn, $manager_id);
?>

<?php


include '../config/session.php';
include '../config/db.php';
require_once '../includes/functions.php';

// Only allow managers
if ($_SESSION['role'] !== 'manager') {
    header("Location: unauthorized.php");
    exit();
}

$bugs = getAllBugs($conn);
$users = getAllUsers($conn);
?>

<?php include '../dashboard/common_header.php'; ?>


<main class="px-4 py-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manager Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="../manager_crud/create.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> New Bug
                </a>
                <a href="manage_users.php" class="btn btn-sm btn-success">
                    <i class="fas fa-users-cog me-1"></i> View Bugs
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Open Bugs</h5>
                    <p class="card-text display-6"><?php echo count(array_filter($bugs, fn($bug) => $bug['status'] === 'Open')); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <p class="card-text display-6"><?php echo count(array_filter($bugs, fn($bug) => $bug['status'] === 'In Progress')); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Resolved</h5>
                    <p class="card-text display-6"><?php echo count(array_filter($bugs, fn($bug) => $bug['status'] === 'Resolved')); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Critical</h5>
                    <p class="card-text display-6"><?php echo count(array_filter($bugs, fn($bug) => $bug['severity'] === 'Critical')); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">All Bugs</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover bug-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Reported</th>
                        <th>Assigned To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bugs as $bug): ?>
                    <tr>
                        <td><?php echo $bug['id']; ?></td>
                        <td><?php echo htmlspecialchars($bug['title']); ?></td>
                        <td>
                            <span class="badge bg-<?php 
                                echo match($bug['severity']) {
                                    'Critical' => 'danger',
                                    'High' => 'warning',
                                    'Medium' => 'primary',
                                    'Low' => 'secondary'
                                };
                            ?>">
                                <?php echo $bug['severity']; ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?php 
                                echo match($bug['status']) {
                                    'Open' => 'info',
                                    'In Progress' => 'warning',
                                    'Resolved' => 'success',
                                    'Closed' => 'secondary'
                                };
                            ?>">
                                <?php echo $bug['status']; ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($bug['created_at'])); ?></td>
                        <td><?php echo $bug['assigned_to_name'] ?? 'Unassigned'; ?></td>
                        <td>
                            <a href="./manager_crud/view.php?id=<?php echo $bug['id']; ?>" class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="../manager_crud/edit.php?id=<?php echo $bug['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="../manager_crud/delete.php?id=<?php echo $bug['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include '../dashboard/common_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.bug-table').DataTable({
                responsive: true,
                order: [[4, 'desc']] // Sort by created date by default
            });
        });
    </script>
    
</body>
</html>