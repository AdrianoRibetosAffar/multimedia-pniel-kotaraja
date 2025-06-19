<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Email configuration
    $to = "your-email@example.com";  // Replace with your email
    $headers = "From: " . $email . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "Content-Type: text/html; charset=UTF-8\r\n";

    // Compose the email
    $email_subject = "New Message from Contact Form: " . $subject;
    $email_message = "<h2>New Contact Message</h2>
                     <p><strong>Name:</strong> " . $name . "</p>
                     <p><strong>Email:</strong> " . $email . "</p>
                     <p><strong>Subject:</strong> " . $subject . "</p>
                     <p><strong>Message:</strong></p>
                     <p>" . nl2br($message) . "</p>";

    // Send the email
    if (mail($to, $email_subject, $email_message, $headers)) {
        echo "<h3>Message sent successfully!</h3>";
    } else {
        echo "<h3>There was an error sending your message. Please try again.</h3>";
    }
} else {
    echo "<h3>Invalid request method.</h3>";
}
?>
