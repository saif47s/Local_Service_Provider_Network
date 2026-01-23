<?php
// User App Information
$title = "User App";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Customer App</title>
    <!-- Using existing CSS -->
    <link rel="stylesheet" href="../serviceprovider/assets/css/bootstrap.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Quicksand', sans-serif; }
        .app-header { background-color: #007bff; color: white; padding: 20px; text-align: center; border-radius: 0 0 20px 20px; }
        .app-container { padding: 20px; max-width: 480px; margin: 0 auto; }
        .action-card { background: white; padding: 20px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
        .btn-custom { width: 100%; border-radius: 50px; padding: 12px; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="app-header">
        <h1>🏠 Home Service</h1>
        <p>Customer App</p>
    </div>

    <div class="app-container">
        
        <div class="action-card">
            <h3>Welcome!</h3>
            <p>Find the best services for your home.</p>
            <hr>
            <a href="../login.php" class="btn btn-primary btn-custom">Login</a>
            <a href="../signup.php" class="btn btn-outline-primary btn-custom">Sign Up</a>
        </div>

        <div class="action-card">
            <h5>Available Services</h5>
            <div class="row">
                <div class="col-6 mb-3">
                    <span style="font-size: 2em;">🧹</span><br>Cleaning
                </div>
                <div class="col-6 mb-3">
                    <span style="font-size: 2em;">🔧</span><br>Plumbing
                </div>
            </div>
            <a href="../index.php" class="btn btn-link">Browse as Guest</a>
        </div>

    </div>

</body>
</html>
