<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Email details
    $to = 'sengarsonal13@gmail.com';  // The recipient email address
    $subject = 'New Contact Form Submission';
    $headers = "From: no-reply@floymlearning.com\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Message body (HTML format)
    $body = "
        <h3 style='color: #4a148c;'>New Enquiry Received!</h3>
        <p>Dear Team,</p>
        <p>You have received a new enquiry through the contact form on your website. Here are the details:</p>
        <ul style='list-style-type: none; padding: 0;'>
            <li><strong>Name:</strong> {$name}</li>
            <li><strong>Number:</strong> {$number}</li>
            <li><strong>Email:</strong> {$email}</li>
        </ul>
        <p><strong>Message:</strong></p>
        <blockquote style='border-left: 3px solid #4a148c; padding-left: 10px; margin: 10px 0;'>
            <p>{$message}</p>
        </blockquote>
        <p>We recommend following up promptly to provide excellent service to your prospective client.</p>
        <p>Best Regards,<br>Your Website Team</p>
    ";

    // SMTP configuration (using PHPMailer)
    require 'PHPMailer/PHPMailerAutoload.php'; // Ensure this path is correct
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'ADD YOUR SMTP SERVER'; // SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'YOUR SMTP USERNAME'; // SMTP username
    $mail->Password = 'YOUR SMTP PASSWORD OR APP PASSWORD'; // SMTP password
    $mail->SMTPSecure = 'ssl'; // Enable SSL encryption
    $mail->Port = 'SMTP PORT'; // SMTP port

    $mail->setFrom('YOUR SMTP USERNAME', 'Floym Learning Hub');
    $mail->addAddress($to); // Recipient

    $mail->isHTML(true); // Email format is HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;

    // Send email and provide feedback
    if ($mail->send()) {
        echo '<script>
                alert("Message has been sent successfully!");
                window.location.href = "index.html"; 
              </script>';
    } else {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
