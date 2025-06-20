<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: /jphp22/Bug_Tracker/pages/login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid bug ID.";
    header("Location: view_bugs.php");
    exit();
}

$bug_id = (int)$_GET['id'];

// Fetch existing bug
$stmt = $conn->prepare("SELECT * FROM bugs WHERE id = ?");
$stmt->bind_param("i", $bug_id);
$stmt->execute();
$bug = $stmt->get_result()->fetch_assoc();

if (!$bug) {
    $_SESSION['error'] = "Bug not found.";
    header("Location: view_bugs.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $priority = $_POST['priority'];
    $status = $_POST['status'];

    if (empty($title) || empty($description)) {
        $_SESSION['error'] = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE bugs SET title = ?, description = ?, severity = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $title, $description, $priority, $status, $bug_id);

        if ($stmt->execute()) {
            logActivity($conn, $_SESSION['user_id'], "Edited bug #$bug_id: $title");
            $_SESSION['success'] = "Bug updated successfully.";
            header("Location: view_bugs.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to update bug.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Bug</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Bug</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Bug Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($bug['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($bug['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Severity</label>
            <select name="priority" class="form-select" required>
                <option value="low" <?= $bug['severity'] === 'low' ? 'selected' : '' ?>>Low</option>
                 <option value="low" <?= $bug['severity'] === 'low' ? 'selected' : '' ?>>Low</option>
                <option value="high" <?= $bug['severity'] === 'high' ? 'selected' : '' ?>>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="open" <?= $bug['status'] === 'open' ? 'selected' : '' ?>>Open</option>
                <option value="in progress" <?= $bug['status'] === 'in progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="closed" <?= $bug['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Bug</button>
        <a href="view_bugs.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
