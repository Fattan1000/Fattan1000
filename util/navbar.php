<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-light bg-cover bg-cyan-950">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="http://localhost:9000/home.php">LOGO</a>
        <?php
        session_start();
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'patient') {
            echo '<a href="patient/dashboard-patient.php" class="btn btn-dark text-white border border-light">Mon compte</a>';
        } else {
            echo '<a href="login.php" class="btn btn-dark text-white border border-light">Se connecter</a>';
        }
        ?>
    </div>
</nav>
</body>
</html>