<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";  // Default XAMPP server address
$username = "root";  // Default XAMPP username
$password = "";  // Default XAMPP password (empty)
$dbname = "registration_db";  // Your database name

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    echo json_encode(array("error" => "Connection failed: " . $conn->connect_error));
    exit();  // Stop further execution
}

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = (int)$_POST['age'];  // Ensure age is an integer
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Validate if the data is not empty
    if (!empty($name) && !empty($email) && !empty($age) && !empty($phone) && !empty($address)) {
        // Prepare the SQL query to insert the data into the registrations table
        $sql = "INSERT INTO registrations (name, email, age, phone, address) 
                VALUES ('$name', '$email', $age, '$phone', '$address')";

        // Execute the query and check for success
        if ($conn->query($sql) === TRUE) {
            // If the insertion was successful, return the inserted data as JSON
            $response = array(
                'name' => $name,
                'email' => $email,
                'age' => $age,
                'phone' => $phone,
                'address' => $address
            );
            echo json_encode($response);  // Return data as JSON
        } else {
            // If there was an error with the query, return an error message
            echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
        }
    } else {
        // Return error if required fields are missing
        echo json_encode(array("error" => "All fields are required."));
    }
} else {
    // If the request is not POST, return an error
    echo json_encode(array("error" => "Invalid request method."));
}

// Close the database connection
$conn->close();
?>