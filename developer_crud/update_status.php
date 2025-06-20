<?php
include '../config/db.php';
include '../config/session.php';
include '../includes/functions.php';

if ($_SESSION['role'] !== 'developer') {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bug_id'])) {
    $bug_id = $_POST['bug_id'];
    $status = $_POST['status'];
    $developer_notes = trim($_POST['developer_notes']);

    $stmt = $conn->prepare("UPDATE bugs SET status=?, developer_notes=? WHERE id=? AND assigned_to=?");
    $stmt->bind_param("ssii", $status, $developer_notes, $bug_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Bug status updated";
    } else {
        $_SESSION['error'] = "Error updating bug status";
    }
    header("Location: ../../dashboard/developer/my_bugs.php");
    exit();
}
?>