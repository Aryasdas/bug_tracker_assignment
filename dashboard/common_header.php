<?php
include '../config/db.php';
include '../config/session.php';


if ($_SESSION['role'] !== 'manager') {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BugTrack - <?php echo ucfirst($_SESSION['role'] ?? 'User'); ?> Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-bug me-2"></i>BugTrack
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $_SESSION['role'] ?>../dashboard/manager_dashboard.php">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    </li>
                    <?php if ($_SESSION['role'] === 'manager' || $_SESSION['role'] === 'tester'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../manager_crud/create.php">
                            <i class="fas fa-plus-circle me-1"></i> Report Bug
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if ($_SESSION['role'] === 'manager'): ?>
                    
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'User'; ?>

                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-1"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="../pages/logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo $_SESSION['role'] ?>../dashboard/manager_dashboard.php">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                        <?php if ($_SESSION['role'] === 'manager'): ?>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../manager_crud/view_bugs.php">
                                <i class="fas fa-bug me-1"></i> My Bugs
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 ms-sm-auto px-md-4">