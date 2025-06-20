<?php include('../config/session.php'); ?>

<?php
require '../config/db.php';
require '../includes/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'developer') {
    header("Location: ../pages/login.php");
    exit;
}

$assignedBugs = getBugsAssignedToUser($conn, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include '../dashboard/navbar.php'; ?>

    <main class="container mt-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Developer Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Assigned Bugs</h5>
                        <p class="card-text display-6"><?php echo count($assignedBugs); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">In Progress</h5>
                        <p class="card-text display-6"><?php echo count(array_filter($assignedBugs, fn($bug) => $bug['status'] === 'In Progress')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Resolved</h5>
                        <p class="card-text display-6"><?php echo count(array_filter($assignedBugs, fn($bug) => $bug['status'] === 'Resolved')); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">My Assigned Bugs</h5>
            </div>
            <div class="card-body">
                <?php if (empty($assignedBugs)): ?>
                    <div class="alert alert-info">No bugs currently assigned to you.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Severity</th>
                                    <th>Status</th>
                                    <th>Reported By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignedBugs as $bug): ?>
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
                                    <td><?php echo $bug['reported_by_name']; ?></td>
                                    <td>
                                        <a href="../developer_crud/view_bug.php?id=<?= $bug['id'] ?>" class="btn btn-info btn-sm">
    <i class="fas fa-eye"></i> View
</a>

                                        
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../dashboard/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>