<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the email parameter is provided
    if (isset($_POST['email'])) {
        $recipient_email = $_POST['email'];

        try {
            $mail = new PHPMailer(true);

            // Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'kabbs2701@gmail.com'; // SMTP username
            $mail->Password = 'lenz dpeq oedz xcun'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->addAddress($recipient_email); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Queue Notification';
            
            // Stylish and professional email content with your own image
            $emailContent = '
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f2f2f2;
                        }
                        .container {
                            padding: 20px;
                            background-color: #ffffff;
                            border-radius: 5px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        h1 {
                            color: #333;
                            text-align:center;
                            font-size: 30;
                        }
                        p {
                            font-size: 24px;
                            line-height: 1.6;
                            text-align:center;
                          
                        }
                        img {
                            max-width: 100%;
                            height: auto;
                            display: block; /* Make images block-level elements */
                            margin: 0 auto; 
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                    <img src="https://queue-ease.000webhostapp.com/logo-header.png" alt="Queue Notification Image">
                        <h1>Queue Notification</h1>
                        <p>It\'s almost your turn in the queue!</p>
                    <img src="https://queue-ease.000webhostapp.com/email-photo.png" alt="Queue Notification Image">
                       
                    </div>
                </body>
                </html>
            ';
            
            $mail->Body = $emailContent;

            $mail->send();
            echo 'success';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    } else {
        echo 'Email parameter is missing.';
    }
} else {
    echo 'Invalid request method';
}
?>
