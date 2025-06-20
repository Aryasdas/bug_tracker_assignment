<?php
require_once '../config/db.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'developer') {
    header("Location: ../pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all bugs assigned to the logged-in developer
$query = "SELECT b.*, u.username AS reported_by 
          FROM bugs b 
          JOIN users u ON b.reported_by = u.id 
          WHERE b.assigned_to = ?
          ORDER BY b.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bugs = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Bugs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>All Assigned Bugs</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Severity</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Reported By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($bugs)): ?>
            <?php foreach ($bugs as $bug): ?>
                <tr>
                    <td><?= $bug['id'] ?></td>
                    <td><?= htmlspecialchars($bug['title']) ?></td>
                    <td><span class="badge bg-danger"><?= $bug['severity'] ?></span></td>
                    <td><span class="badge bg-secondary"><?= $bug['status'] ?></span></td>
                    <td><?= $bug['due_date'] ?? 'N/A' ?></td>
                    <td><?= htmlspecialchars($bug['reported_by']) ?></td>
                    <td>
                        <a href="view_bug.php?id=<?= $bug['id'] ?>" class="btn btn-sm btn-info">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">No bugs assigned to you.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="../dashboard/developer_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>
</body>
</html>
