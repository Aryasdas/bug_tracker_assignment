<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BugTrack - Simple Bug Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <!-- Header/Navigation -->
   <?php 
   include '../includes/header.php';

   ?>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container py-4">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-5 fw-bold mb-3">Simple Bug Tracking Solution</h1>
                        <p class="lead mb-4">Track and manage software issues efficiently with our straightforward bug tracking system.</p>
                        <div class="d-flex gap-3">
                            <a href="register.php" class="btn btn-primary btn-lg px-4">Get Started</a>
                            <a href="#features" class="btn btn-outline-secondary btn-lg px-4">Learn More</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="assets/images/bug-tracking.png" alt="Bug Tracking Interface" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-5 bg-white">
            <div class="container py-4">
                <h2 class="text-center mb-5">Key Features</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 p-3">
                            <div class="card-body text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <h4>Bug Tracking</h4>
                                <p>Easily create, assign, and track bugs through their lifecycle.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 p-3">
                            <div class="card-body text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <h4>Tagging</h4>
                                <p>Categorize and filter bugs with custom tags.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 p-3">
                            <div class="card-body text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h4>Reporting</h4>
                                <p>Generate simple reports to track progress.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="py-5 bg-light">
            <div class="container py-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h2 class="mb-4">About BugTrack</h2>
                        <p>BugTrack is a straightforward bug tracking system designed for small to medium development teams who need an uncomplicated solution for tracking software issues.</p>
                        <p>Our focus is on simplicity and usability, without unnecessary complexity that gets in the way of your actual work.</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Why Choose BugTrack?</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Easy to set up and use</li>
                                    <li class="list-group-item">No complicated workflows</li>
                                    <li class="list-group-item">Focused on essential features</li>
                                    <li class="list-group-item">Affordable pricing</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php 
   include '../includes/footer.php';

   ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>