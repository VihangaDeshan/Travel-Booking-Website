<?php
session_start();
include 'conf.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_package"])) {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
    
        // Handle image upload
        $image_url = "uploads/default.jpg"; // Default image URL
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
            $target_dir = "img/"; // Directory where images are stored
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $target_file; // Set the image URL to the uploaded file
            }
        }
    
        if (!empty($name) && !empty($description) && is_numeric($price)) {
            $stmt = $conn->prepare("INSERT INTO packages (name, description, price, image_url) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $name, $description, $price, $image_url);
            $stmt->execute();
        } else {
            echo "Please fill out all fields correctly.";
        }
    }
    
     elseif (isset($_POST["update_package"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $image_url = $_POST["image_url"];
    
        if (!empty($name) && !empty($description) && is_numeric($price) && !empty($image_url)) {
            $stmt = $conn->prepare("UPDATE packages SET name = ?, description = ?, price = ?, image_url = ? WHERE id = ?");
            $stmt->bind_param("ssdsi", $name, $description, $price, $image_url, $id);
            $stmt->execute();
        } else {
            echo "Please fill out all fields correctly.";
        }
    } elseif (isset($_POST["delete_package"])) {
        $id = $_POST["id"];
        $stmt = $conn->prepare("DELETE FROM packages WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

$packages = array();
$result = $conn->query("SELECT * FROM packages");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function validateForm() {
            var name = document.forms["packageForm"]["name"].value;
            var description = document.forms["packageForm"]["description"].value;
            var price = document.forms["packageForm"]["price"].value;
            var image_url = document.forms["packageForm"]["image_url"].value;

            if (name == "" || description == "" || isNaN(price) || image_url == "") {
                alert("Please fill out all fields correctly.");
                return false;
            }
        }
    </script>
     <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Add Bootstrap navigation bar -->
    <nav class="navbar navbar-expand-lg custom-bg-black fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-hover" href="#packages">Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-hover" href="#Add_Packages">Add Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-hover" href="#messages">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-hover" href="#bookings">Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link main-btn" href="index.html">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section id="packages" style="background-color:aliceblue;" class="py-5">
    <div class="container">
        <br><Center><h1>Welcome to the Admin Dashboard</h1></Center>
        <!-- Display packages -->
        <h2 >Packages</h2>
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th class="lower">Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th class="wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($packages as $package) : ?>
                    <tr>
                        <td><?= $package['id']; ?></td>
                        <td><?= $package['name']; ?></td>
                        <td class="lower"><?= $package['description']; ?></td>
                        <td><?= $package['price']; ?></td>
                        <td><img src="<?= $package['image_url']; ?>" alt="<?= $package['name']; ?>" style="max-width: 100px;"></td>
                        <td class="wider">
                        <form name="packageForm" method="post" onsubmit="return validateForm();">
                            <input type="hidden" name="id" value="<?= $package['id']; ?>">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $package['name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" rows="4"><?= $package['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" value="<?= $package['price']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="image_url">Image URL</label>
                                <input type="text" name="image_url" class="form-control" value="<?= $package['image_url']; ?>">
                            </div><br><center>
                            <button type="submit" name="update_package" class="btn btn-primary">Update</button><br>
                            <br><button type="submit" name="delete_package" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button></center>
                        </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table><br>
        </div>
    </div>
 </section>

<!-- Add Package form -->

    <section id="Add_Packages" style="background-color:aquamarine; text-align: center;" class="py-5">
    <div class="container">
        <br><h2 >Add Package</h2>
          <form name="packageForm" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div><br>
            <div class="form-group">
                <textarea id="description" name="description" class="form-control" rows="5" placeholder="Description" required></textarea>
            </div><br>
            <div class="form-group">
                <input type="number" name="price" class="form-control" placeholder="Price" required>
            </div><br>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control-file" required>
            </div><br>
            <button type="submit" name="add_package" class="btn btn-primary">Add</button>
        </form>

    </div>
    </section>
    
        
<!-- Add a new section to display contact messages -->
 <section id="messages" style="background-color:aliceblue; text-align: center;" class="py-5">
    <div class="container">
        <br><h2 >Contact Messages</h2>
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 100px;">Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch data from the contact_data table
                $contactMessages = array();
                $contactResult = $conn->query("SELECT * FROM contact_data");
                if ($contactResult->num_rows > 0) {
                    while ($row = $contactResult->fetch_assoc()) {
                        $contactMessages[] = $row;
                    }
                }

                // Display contact messages
                foreach ($contactMessages as $message) : ?>
                    <tr>
                        <td><?= $message['id']; ?></td>
                        <td style="width: 100px;"><?= $message['name']; ?></td>
                        <td><?= $message['email']; ?></td>
                        <td ><?= $message['message']; ?></td>
                        <td ><?= $message['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table></div>
    </div>
 </section>
       

        
<!-- Add a new section to display bookings -->
<section id="bookings" style="background-color:gainsboro;" class="py-5">
    <div class="container">
            <br><h2 >Bookings</h2>
            <div class="table-responsive">
            <table class="table table-bordered" style="overflow-x: auto;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Persons</th>
                        <th>Children</th>
                        <th>Booking Date</th>
                        <th>Package ID</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch data from the bookings table
                    $bookings = array();
                    $bookingResult = $conn->query("SELECT * FROM bookings");
                    if ($bookingResult->num_rows > 0) {
                        while ($row = $bookingResult->fetch_assoc()) {
                            $bookings[] = $row;
                        }
                    }

                    // Display booking information
                    foreach ($bookings as $booking) : ?>
                        <tr>
                            <td><?= $booking['id']; ?></td>
                            <td><?= $booking['name']; ?></td>
                            <td><?= $booking['email']; ?></td>
                            <td><?= $booking['phone']; ?></td>
                            <td><?= $booking['persons']; ?></td>
                            <td><?= $booking['children']; ?></td>
                            <td><?= $booking['booking_date']; ?></td>
                            <td><?= $booking['package_id']; ?></td>
                            <td><?= $booking['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
</div>
</section>
   
    <!-- Add Bootstrap JS and Popper.js scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
