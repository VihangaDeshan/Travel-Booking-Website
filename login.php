<?php
session_start();
include 'conf.php'; // Include your database connection

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $db_username, $db_password);
        $stmt->fetch();
        // Check the password without hashing (not recommended)
        if ($password === $db_password) {
            $_SESSION['user_id'] = $id;
            header("Location: admin.php");
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "Invalid username. Please try again.";
    }
    

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <title>Admin Login</title>
    <style>
        .travel-bg {
            background: url('img/login.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            font-family: 'Poppins', sans-serif;
        }

        .card-title {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
        }
    </style>
</head>
<body class="travel-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Admin Login</h4>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary btn-block">Log In</button>
                            </center>
                        </form>
                        <p class="mt-3 text-center">
                            <a href="create-account.html">Forgot password</a>
                        </p>
                        <?php
                            if (!empty($error)) {
                                echo '<div class="alert alert-danger mt-3">' . $error . '</div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
