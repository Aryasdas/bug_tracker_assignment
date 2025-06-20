<?php
require_once __DIR__ . '/../config/db.php';          
require_once __DIR__ . '/../config/session.php'; 
     
require_once __DIR__ . '/../includes/functions.php';

// Only managers can delete bugs
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: /jphp22/Bug_Tracker/pages/login.php");
    exit();
}

// Check if bug ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid bug ID";
    header("Location: view_bugs.php");
    exit();
}

$bug_id = (int)$_GET['id'];

try {
    // First log who deleted the bug (optional)
    $stmt = $conn->prepare("SELECT title FROM bugs WHERE id = ?");
    $stmt->bind_param("i", $bug_id);
    $stmt->execute();
    $bug = $stmt->get_result()->fetch_assoc();
    
    // Delete the bug
    $stmt = $conn->prepare("DELETE FROM bugs WHERE id = ?");
    $stmt->bind_param("i", $bug_id);
    
    if ($stmt->execute()) {
        // Log the activity
        logActivity($conn, $_SESSION['user_id'], "Deleted bug #$bug_id: {$bug['title']}");
        
        $_SESSION['success'] = "Bug #$bug_id deleted successfully";
    } else {
        throw new Exception("Failed to delete bug");
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error deleting bug: " . $e->getMessage();
}

header("Location: view_bugs.php");
exit();
?>