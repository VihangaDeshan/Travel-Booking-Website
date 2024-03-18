<?php
include 'conf.php';
$message = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $persons = $_POST["persons"];
    $children = $_POST["children"];
    $date = $_POST["date"];
    $package_id = $_POST["package_id"];

    // Convert the date format to match the MySQL format
    $formatted_date = date("Y-m-d", strtotime($date));

   
    // Prepare and execute the SQL statement to insert the booking data
    $sql = "INSERT INTO bookings (name, email, phone, persons, children, booking_date, package_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
   

    if ($stmt) {
        $stmt->bind_param("sssiisi", $name, $email, $phone, $persons, $children, $formatted_date, $package_id);

        if ($stmt->execute()) {
            $message = "Booking successful!";
        } else {
            $error = "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        $error = "Error in SQL statement preparation: " . $conn->error;
    }
   
}
 // Close the database connection
 $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include jQuery UI CSS for datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Include Bootstrap JavaScript (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        /* Set the font-family for the entire document to Poppins */
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    


</head>
<body>
    <div class="container">
        <h1>Booking for Package</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="bookingForm">
        <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
                <small id="nameError" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" id="phone" required>
            <small id="phoneError" class="form-text text-danger"></small>
           </div>
            <div class="form-group">
                <label for="persons">Number of Persons</label>
                <input type="number" class="form-control" id="persons" name="persons" required>
            </div>
            <div class="form-group">
                <label for="children">Number of Children</label>
                <input type="number" class="form-control" id="children" name="children" required>
            </div>
            <div class="form-group">
                <label for="date">Booking Date</label>
                <input type="text" class="form-control" id="date" name="date" required>
            </div>
             
            <input type="hidden" name="package_id" value="<?php echo isset($_GET['package_id']) ? $_GET['package_id'] : ''; ?>">
            <br><button type="submit" class="btn btn-primary">Book Now</button>
            
            <!-- Add a back button -->
            <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
        </form>
        <!-- Display success message or error -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-success mt-3">
                <?= $message ?>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "index.html";
                }, 2000); // Redirect after 2 seconds
            </script>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger mt-3">
                <?= $error ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Include jQuery UI for datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize datepicker
            $("#date").datepicker({
                minDate: 0  // Restrict dates to today and future dates
            });

            // Front-end validation
            $("#bookingForm").submit(function(e) {
                var name = $("#name").val();
                var email = $("#email").val();
                var phone = $("#phone").val();
                var persons = $("#persons").val();
                var children = $("#children").val();
                var date = $("#date").val();

                if (name === "" || email === "" || phone === "" || persons === "" || children === "" || date === "") {
                    alert("All fields are required.");
                    e.preventDefault();
                    return;
                }

                if (!validateEmail(email)) {
                    alert("Invalid email address.");
                    e.preventDefault();
                    return;
                }

                if (!validatePhone(phone)) {
                    alert("Invalid phone number.");
                    e.preventDefault();
                    return;
                }

                if (!validateDate(date)) {
                    alert("Invalid date format.");
                    e.preventDefault();
                    return;
                }
            });

            function validateEmail(email) {
                var re = /\S+@\S+\.\S+/;
                return re.test(email);
            }

            function validatePhone(phone) {
                var re = /^\d{10}$/;
                return re.test(phone);
            }

            function validateDate(date) {
                return !isNaN(Date.parse(date));
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
                const phoneInput = document.getElementById('phone');
                const phoneError = document.getElementById('phoneError');

                phoneInput.addEventListener('input', function() {
                    let phoneNumber = phoneInput.value.trim();
                    
                    // Remove non-numeric characters
                    phoneNumber = phoneNumber.replace(/\D/g, '');

                    // Ensure the length is not greater than 10
                    if (phoneNumber.length > 10) {
                        phoneNumber = phoneNumber.slice(0, 10);
                    }

                    phoneInput.value = phoneNumber; // Update the input value

                    if (phoneNumber.length !== 10) {
                        phoneError.textContent = 'Please enter a valid 10-digit phone number.';
                    } else {
                        phoneError.textContent = ''; // Clear any previous error message
                    }
                });
            });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('nameError');

            nameInput.addEventListener('input', function() {
                let name = nameInput.value.trim();

                if (/\d/.test(name)) {
                    nameError.textContent = 'Numeric values are not allowed.';
                    nameInput.value = '';
                } else {
                    nameError.textContent = '';
                }
            });
        });
    </script>
</body>
</html>
