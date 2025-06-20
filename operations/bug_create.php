<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Ensure tester is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'tester') {
    header("Location: /Bug_Tracker/pages/login.php");
    exit();
}

// Process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $steps = trim($_POST['steps_to_reproduce'] ?? '');
    $severity = $_POST['severity'] ?? 'Medium';
    $priority = $_POST['priority'] ?? 'Medium';
    $assigned_to = !empty($_POST['assigned_to']) ? (int)$_POST['assigned_to'] : null;
    $due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : null;
    $reported_by = (int)$_SESSION['user_id'];

    // Validate
    if (empty($title) || empty($description) || empty($severity)) {
        $_SESSION['error'] = 'Title, description, and severity are required.';
        header("Location: /Bug_Tracker/pages/tester/create.php");
        exit();
    }

    // Upload attachment if any
    $attachment_path = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'text/plain'];
        $max_size = 2 * 1024 * 1024; // 2MB
        if (in_array($_FILES['attachment']['type'], $allowed_types) && $_FILES['attachment']['size'] <= $max_size) {
            $upload_dir = __DIR__ . '/../uploads/bugs/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $ext;
            $destination = $upload_dir . $filename;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $destination)) {
                $attachment_path = $filename;
            }
        }
    }

    // Insert into DB
    try {
        $stmt = $conn->prepare("INSERT INTO bugs 
            (title, description, steps_to_reproduce, severity, priority, reported_by, assigned_to, due_date, attachment, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Open', NOW())");

        $stmt->bind_param("sssssiiss", 
            $title, $description, $steps, $severity, $priority, 
            $reported_by, $assigned_to, $due_date, $attachment_path
        );

        if ($stmt->execute()) {
            $bug_id = $conn->insert_id;
            logActivity($conn, $reported_by, "Reported bug #$bug_id: $title");
            $_SESSION['success'] = 'Bug reported successfully!';
            header("Location: /Bug_Tracker/pages/tester/view.php?id=$bug_id");
            exit();
        } else {
            throw new Exception("DB Error: " . $conn->error);
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
        header("Location: /Bug_Tracker/pages/tester/create.php");
        exit();
    }
} else {
    header("Location: /Bug_Tracker/pages/tester/create.php");
    exit();
}
