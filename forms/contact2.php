<?php
// Database connection
$servername = "mysqlserver"; // your DB server
$username   = "root";       // your DB username
$password   = "Godismore123!!";           // your DB password
$dbname     = "bernese_db"; // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name    = $_POST['name'];
$email   = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Save to database
$stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    
    // Send email
    $to      = "kobebryantz143@gmail.com";  // replace with your email
    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    $emailBody = "
        <h2>New Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Subject:</strong> $subject</p>
        <p><strong>Message:</strong><br>$message</p>
    ";
    
    if (mail($to, "New Contact Form: $subject", $emailBody, $headers)) {
        echo "Thank you for contacting us. We will get back to you shortly.";
    } else {
        echo "Error: Unable to send email.";
    }

} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
