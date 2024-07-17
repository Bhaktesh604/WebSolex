<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and sanitize inputs
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        http_response_code(400); // Bad request
        echo "Please fill out all fields.";
        exit;
    }

    // Set recipient email address
    $to = "your-email@example.com"; // Replace with your email address

    // Set email subject
    $email_subject = "$subject";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build email headers
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $email_subject, $email_content, $email_headers)) {
        http_response_code(200); // Success
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500); // Server error
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(403); // Forbidden
    echo "There was a problem with your submission, please try again.";
}
?>
