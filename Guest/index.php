<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Teacher's Diary</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #007bff;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            position: relative;
        }
        h1{
                font-family: open sans;
        }
        .logo {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            max-width: 100px;
        }
        .header-content {
            margin-left: 140px; /* Adjust based on logo size */
        }
        nav {
            background-color: #f8f9fa;
        }
        .navbar-nav {
            margin: 0 auto; /* Center the navigation bar */
        }
        .nav-link {
            font-weight: bold;
            font-size: 18px;
        }
        .nav-link:hover {
            color: #0056b3 !important;
        }
        .feature {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }
        .feature:hover {
            transform: translateY(-5px);
        }
        footer {
            background-color: #007bff;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-top: auto; /* Push the footer to the bottom */
        }
    </style>
</head>
<body>

<header>
    <img src="University logo.png" alt="College Logo" class="logo"> <!-- Replace 'path_to_logo.png' with the actual path to the college logo -->
    <div class="header-content">
        <h1>Welcome to University College of Cyber security</h1>
        <p>Your dedicated platform for managing academic activities and enhancing teaching efficiency.</p>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="feature">
                <h2>Manage Your Classes</h2>
                <p>
                    Welcome to the class management system at University College of Cyber security. Here, you can easily schedule and organize your classes, keeping track of all your sessions with minimal effort. The intuitive interface ensures that you can allocate time for lectures, labs, and extra-curricular activities without missing a beat.
                    Stay organized and ensure your students receive the best possible experience.
                </p>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2025 University College of Cyber security. Developed By Amirthjoy AI,Ajradh TK,Albert C Domanic & Archana BU.</p>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const features = document.querySelectorAll('.feature');

        features.forEach(feature => {
            feature.addEventListener('mouseover', () => {
                feature.style.backgroundColor = '#e0f7fa';
            });

            feature.addEventListener('mouseout', () => {
                feature.style.backgroundColor = '#fff';
            });
        });
    });
</script>

</body>
</html>
