<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | BugTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    
</head>
<body>
    <?php 
    include '../includes/header.php';
    ?>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <!-- About Header -->
        <section class="about-header text-center">
            <div class="container">
                <h1 class="display-5 fw-bold">About BugTrack</h1>
                <p class="lead">Our mission is to simplify bug tracking for development teams</p>
            </div>
        </section>

        <!-- About Content -->
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2 class="mb-4">Our Story</h2>
                        <p>BugTrack was founded in 2023 by a team of developers who were frustrated with overly complex bug tracking systems. We wanted to create a solution that was simple to use but still powerful enough for real development teams.</p>
                        <p>Our philosophy is that bug tracking should help you solve problems, not create more work. That's why we've focused on creating an intuitive interface with just the features you actually need.</p>
                    </div>
                    <div class="col-lg-6">
                        <img src="assets/images/team-working.jpg" alt="Team working together" class="img-fluid rounded">
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <h2 class="text-center mb-5">Meet the Team</h2>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                        <div class="team-member">
                            <img src="assets/images/team1.jpg" alt="Team Member" class="mb-3">
                            <h4>Alex Johnson</h4>
                            <p class="text-muted">Founder & CEO</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                        <div class="team-member">
                            <img src="assets/images/team2.jpg" alt="Team Member" class="mb-3">
                            <h4>Sarah Williams</h4>
                            <p class="text-muted">Lead Developer</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                        <div class="team-member">
                            <img src="assets/images/team3.jpg" alt="Team Member" class="mb-3">
                            <h4>Michael Chen</h4>
                            <p class="text-muted">UX Designer</p>
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