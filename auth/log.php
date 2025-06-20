<?php
session_start();
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            switch ($user['role']) {
                case 'developer':
                    header("Location: ../dashboard/developer_dashboard.php");
                    break;
                case 'tester':
                    header("Location: ../dashboard/tester_dashboard.php");
                    break;
                case 'manager':
                    header("Location: ../dashboard/manager_dashboard.php");
                    break;
                default:
                    echo "<script>alert('Unknown role');</script>";
            }
            exit();
        } else {
            echo "<script>alert('Invalid password'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
