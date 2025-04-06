<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';  // Include the Composer autoloader

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                               // Gmail SMTP server
    $mail->SMTPAuth = true;                                       // Enable SMTP authentication
    $mail->Username = 'omareduslwork@gmail.com';                   // Your Gmail address
    $mail->Password = 'lwiw rufc iyqu tzxc';                        // Your Gmail password or app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption
    $mail->Port = 587;                                            // TCP port to connect to (587 for TLS)
                                        // TCP port to connect to (587 for TLS)

    // Sender's email address
    $mail->setFrom('omareduslwork@gmail.com', 'Omar');  // Replace with your email and name

    // Recipient's email address
    $mail->addAddress('oesl96@gmail.com', 'Omar');  // Replace with recipient's email and name

    // Subject
    $mail->Subject = 'Hello, World!';

    // Body content
    $mail->isHTML(true);                                          // Send email as HTML
    $mail->Body    = 'Hello, World!';                             // HTML email body
    $mail->AltBody = 'Hello, World!';                             // Plain-text body for non-HTML email clients

    // Send the email
    $mail->send();
    echo 'Message has been sent successfully.';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
