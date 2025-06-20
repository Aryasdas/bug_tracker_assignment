<?php include('../config/session.php'); ?>


<?php
session_start();
require '../config/db.php';
require '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'tester') {
    header("Location: ../pages/login.php");
    exit;
}

$reportedBugs = getBugsReportedByUser($conn, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tester Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../dashboard/navbar.php'; ?>

    <main class="container mt-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tester Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a href="../tester_crud/create.php" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Report New Bug
                    </a>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Reported Bugs</h5>
                        <p class="card-text display-6"><?php echo count($reportedBugs); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Open</h5>
                        <p class="card-text display-6"><?php echo count(array_filter($reportedBugs, fn($bug) => $bug['status'] === 'Open')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Resolved</h5>
                        <p class="card-text display-6"><?php echo count(array_filter($reportedBugs, fn($bug) => $bug['status'] === 'Resolved')); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Recently Reported Bugs</h5>
            </div>
            <div class="card-body">
                <?php if (empty($reportedBugs)): ?>
                    <div class="alert alert-info">You haven't reported any bugs yet.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Severity</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($reportedBugs, 0, 5) as $bug): ?>
                                <tr>
                                    <td><?php echo $bug['id']; ?></td>
                                    <td><?php echo htmlspecialchars($bug['title']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo severityColor($bug['severity']); ?>">
                                            <?php echo $bug['severity']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo statusColor($bug['status']); ?>">
                                            <?php echo $bug['status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $bug['assigned_to_name'] ?? 'Unassigned'; ?></td>
                                    <td>
                                        <a href="../bugs/view.php?id=<?php echo $bug['id']; ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="../bugs/edit.php?id=<?php echo $bug['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="../bugs/my_reported.php" class="btn btn-primary">View All My Reported Bugs</a>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>