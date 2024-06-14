<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$adminEmails = [
    'dumidu.kodithuwakku@ebeyonds.com',
    'prabhath.senadheer@ebeyonds.com',
    
];

// display messages
function displayMessages($messages, $type = 'success') {
    echo "<div class='message-box'>";
    foreach ($messages as $message) {
        echo "<p class='$type'>$message</p>";
    }
    echo "<button onclick='window.location.href=\"index.html\";'>Go to Home</button>";
    echo "</div>";
}

// Checking the submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['first-name'] . ' ' . $_POST['last-name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $message = $_POST['message'];
    $terms = isset($_POST['terms']) ? $_POST['terms'] : '';

//    validating form data
    $errors = [];

    if (empty($name)) {
        $errors[] = 'Name is required';
    }

    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }

    if (empty($telephone)) {
        $errors[] = 'Telephone is required';
    } elseif (!preg_match('/^\d{10}$/', $telephone)) {
        $errors[] = 'Invalid telephone format';
    }

    if (empty($message)) {
        $errors[] = 'Message is required';
    }

    if (empty($terms)) {
        $errors[] = 'You must agree to the terms and conditions';
    }

//    error handling
    if (empty($errors)) {
        // Process the data
         $messages = ["Your Form submitted Successfully!"];
        
        // Prepare data for saving in JSON file
        $data = [
            'name' => $name,
            'email' => $email,
            'telephone' => $telephone,
            'message' => $message
        ];

        // Save data in JSON file
        $jsonFile = 'submissions.json';

        // Check if the JSON file exists, if not create it
        if (!file_exists($jsonFile)) {
            file_put_contents($jsonFile, json_encode([]));
        }

        $jsonData = json_decode(file_get_contents($jsonFile), true) ?? [];

        $jsonData[] = $data;

        file_put_contents($jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));


        $subjectUser = "Form Submission Confirmation";
        $messageUser = "Dear $name,\n\nThank you for your submission.\n\nBest Regards,\neBeyonds Team";

        // Prepare email details for the admin
        $subjectAdmin = "New Form Submission";
        $messageAdmin = "New form submission details:\n\nName: $name\nEmail: $email\nTelephone: $telephone\nMessage: $message";

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true); // Passing `true` enables exceptions

        try {
            

            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true; 
            $mail->Username = 'harithamandara01@gmail.com'; 
            $mail->Password = 'jnpmbukugfczkhsk'; 
            $mail->SMTPSecure = 'tls'; 
            $mail->Port = 587; 

            // Sender
            $mail->setFrom('harithamandara01@gmail.com', 'New Form Submission');

            // Send email to user
            $mail->addAddress($email, "$name");
            $mail->Subject = $subjectUser;
            $mail->Body = $messageUser;
            if ($mail->send()) {
                $messages[] = "Email sent successfully to $email.";
            } else {
                $errors[] = "Failed to send email to $email. Error: {$mail->ErrorInfo}";
            }

            // Send email to admin(s)
            foreach ($adminEmails as $adminEmail) {
                $mail->clearAddresses(); // Clear previous addresses
                $mail->addAddress($adminEmail);
                $mail->Subject = $subjectAdmin;
                $mail->Body = $messageAdmin;

                // Send email
                if ($mail->send()) {
                    $messages[] = "Email sent successfully to $adminEmail.";
                } else {
                    $errors[] = "Failed to send email to $adminEmail. Error: {$mail->ErrorInfo}";
                }
            }
        } catch (Exception $e) {
            $errors[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
        if (!empty($messages)) {
            displayMessages($messages, 'success');
        }

        if (!empty($errors)) {
            displayMessages($errors, 'error');
        }

    } else {

        displayMessages($errors, 'error');
    }
}
?>


<!-- successfull message css starts here -->

<style>
    body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
    margin: 0;
}

.message-box {
    background: #fff;
    border: 1px solid #ddd;
    padding: 20px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.message-box p {
    margin: 10px 0;
}

.message-box .success {
    color: green;
}

.message-box .error {
    color: red;
}

.message-box button {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
}

.message-box button:hover {
    background-color: #0056b3;
}

</style>