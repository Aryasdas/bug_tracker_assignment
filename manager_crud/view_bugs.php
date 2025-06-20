<?php
include '../config/db.php';
include '../config/session.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: ../auth/login.php");
    exit();
}

// Get all bugs (you can customize to show bugs reported by or assigned to this manager)
$bugs = getAllBugs($conn); // This function should return all bugs from DB
?>

<?php include '../dashboard/common_header.php'; ?>

<div class="container mt-4">
    <h3 class="mb-4">My Bugs</h3>

    <?php if (empty($bugs)): ?>
        <p class="text-muted">No bugs found.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Severity</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bugs as $bug): ?>
                <tr>
                    <td><?= $bug['id'] ?></td>
                    <td><?= htmlspecialchars($bug['title']) ?></td>
                    <td><span class="badge bg-<?= severityColor($bug['severity']) ?>"><?= $bug['severity'] ?></span></td>
                    <td><span class="badge bg-<?= statusColor($bug['status']) ?>"><?= $bug['status'] ?></span></td>
                    <td><?= date('M d, Y', strtotime($bug['created_at'])) ?></td>
                    <td>
                        <a href="view.php?id=<?= $bug['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> View
                            
                            <a href="../manager_crud/edit.php?id=<?php echo $bug['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="../manager_crud/delete.php?id=<?php echo $bug['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../dashboard/common_footer.php'; ?>
