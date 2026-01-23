<?php
// Provider App Information
$title = "Provider App";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service Provider App</title>
    <!-- Using existing CSS -->
    <link rel="stylesheet" href="../serviceprovider/assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #2c3e50;
            font-family: 'Quicksand', sans-serif;
            color: white;
        }

        .app-header {
            background-color: #1a252f;
            padding: 30px;
            text-align: center;
            border-radius: 0 0 20px 20px;
        }

        .app-container {
            padding: 20px;
            max-width: 480px;
            margin: 0 auto;
        }

        .action-card {
            background: #34495e;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .btn-custom {
            width: 100%;
            border-radius: 50px;
            padding: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="app-header">
        <h1>🛠️ Partner</h1>
        <p>Service Provider App</p>
    </div>

    <div class="app-container">

        <div class="action-card">
            <h3>Grow Business</h3>
            <p>Get orders from customers near you.</p>
            <hr style="border-color: #7f8c8d;">
            <a href="../login.php" class="btn btn-success btn-custom">Partner Login</a>
            <a href="../sp_signup.php" class="btn btn-outline-light btn-custom">Register as Partner</a>
        </div>

        <div class="action-card">
            <h5>Why Join Us?</h5>
            <ul class="text-left" style="list-style: none; padding-left: 0;">
                <li class="mb-2">✅ Verified Leads</li>
                <li class="mb-2">✅ Flexible Timings</li>
                <li class="mb-2">✅ Daily Payouts</li>
            </ul>
        </div>

    </div>

</body>

</html>