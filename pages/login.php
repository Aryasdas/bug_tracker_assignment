<?php
session_start();
$errors = [];

// Optional: Handle flash messages from session
if (isset($_SESSION['error'])) {
    $errors[] = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login | Bug Tracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet">
</head>
<body>
  <?php include '../includes/header.php'; ?>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h3>Login to Bug Tracker</h3>
          </div>
          <div class="card-body">

            <?php if (!empty($_SESSION['success'])): ?>
              <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
              </div>
            <?php endif ?>

            <?php if (!empty($errors)): ?>
              <div class="alert alert-danger">
                <?php foreach ($errors as $e): ?>
                  <div><?= htmlspecialchars($e) ?></div>
                <?php endforeach ?>
              </div>
            <?php endif ?>

            <form method="POST" action="../auth/log.php">
              <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email"
                       class="form-control"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       required>
              </div>
              <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password"
                       class="form-control" required>
              </div>
              <button class="btn btn-primary w-100" type="submit">Login</button>
            </form>

            <div class="mt-3 text-center">
              Don't have an account? <a href="register.php">Register here</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include '../includes/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
