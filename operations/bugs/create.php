<?php
session_start();
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $steps = $_POST['steps_to_reproduce'] ?? '';
    $severity = $_POST['severity'];
    $assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : null;
    $due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : null;
    $reported_by = $_SESSION['user_id'];

    try {
        $stmt = $conn->prepare("INSERT INTO bugs 
            (title, description, steps_to_reproduce, status, severity, assigned_to, reported_by, due_date, created_at) 
            VALUES (?, ?, ?, 'Open', ?, ?, ?, ?, NOW())");

        $stmt->bind_param("ssssiis", $title, $description, $steps, $severity, $assigned_to, $reported_by, $due_date);
        $stmt->execute();

        $_SESSION['success'] = "Bug created successfully.";
        header("Location: ../../dashboard/manager_dashboard.php");
        exit();
    } catch (Exception $e) {
        error_log("Error creating bug: " . $e->getMessage());
        $_SESSION['error'] = "Error creating bug. Please try again.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../../dashboard/manager_dashboard.php");
    exit();
}
