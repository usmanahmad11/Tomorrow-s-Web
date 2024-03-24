<?php
// db.php - Create a database connection
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'my_db'; // Replace with your actual database name
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die('Could not connect to MySQL server: ' . mysqli_error());
}

// Registration form processing
if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    // Validate input
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $name_error = "Name must contain only alphabets and spaces";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please enter a valid email address";
    }
    if (strlen($password) < 6) {
        $password_error = "Password must be at least 6 characters long";
    }
    if (strlen($mobile) < 10) {
        $mobile_error = "Mobile number must be at least 10 characters long";
    }
    if ($password != $cpassword) {
        $cpassword_error = "Password and Confirm Password do not match";
    }

    // If no errors, insert data into the database
    if (!isset($name_error, $email_error, $password_error, $mobile_error, $cpassword_error)) {
        $hashed_password = md5($password); // Hash the password
        $sql = "INSERT INTO users (name, email, mobile, password) VALUES ('$name', '$email', '$mobile', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            header("location: registration.php"); // Redirect after successful registration
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}
?>