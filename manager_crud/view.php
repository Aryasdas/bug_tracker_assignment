<?php
include '../config/db.php';
include '../config/session.php';
include '../includes/functions.php';

// Manager only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: /jphp22/Bug_Tracker/operations/pages/login.php");
    exit();
}

// Validate bug ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid bug ID.";
    header("Location: view_bugs.php");
    exit();
}

$bug_id = (int)$_GET['id'];

// Fetch bug details
$stmt = $conn->prepare("SELECT b.*, 
    d.username AS developer_name, 
    t.username AS tester_name 
    FROM bugs b 
    LEFT JOIN users d ON b.assigned_to = d.id 
    LEFT JOIN users t ON b.reported_by = t.id 
    WHERE b.id = ?");


$stmt->bind_param("i", $bug_id);
$stmt->execute();
$result = $stmt->get_result();
$bug = $result->fetch_assoc();

if (!$bug) {
    $_SESSION['error'] = "Bug not found.";
    header("Location: view_bugs.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bug Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Bug Details</h2>

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            Bug #<?= htmlspecialchars($bug['id']) ?> - <?= htmlspecialchars($bug['title']) ?>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($bug['description'])) ?></p>
            <p><strong>Status:</strong> <span class="badge bg-info text-dark"><?= ucfirst(htmlspecialchars($bug['status'])) ?></span></p>
            <p><strong>Priority:</strong> <span class="badge bg-danger"><?= ucfirst(htmlspecialchars($bug['severity'])) ?></span></p>
            <p><strong>Created At:</strong> <?= htmlspecialchars($bug['created_at']) ?></p>
            <p><strong>Assigned Developer:</strong> <?= $bug['developer_name'] ? htmlspecialchars($bug['developer_name']) : '<em>Not assigned</em>' ?></p>
            <p><strong>Reported By Tester:</strong> <?= $bug['tester_name'] ? htmlspecialchars($bug['tester_name']) : '<em>Unknown</em>' ?></p>
        </div>
        <div class="card-footer text-end">
            <a href="view_bugs.php" class="btn btn-secondary">Back</a>
            <a href="edit.php?id=<?= $bug['id'] ?>" class="btn btn-primary">Edit</a>
            <a href="delete.php?id=<?= $bug['id'] ?>" class="btn btn-danger"
               onclick="return confirm('Are you sure you want to delete this bug?')">Delete</a>
        </div>
    </div>
</div>
</body>
</html>
