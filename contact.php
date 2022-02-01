<?php
function problem($error)
    {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors.<br><br>";
        die();
    }
    // validation expected data exists
    if (
        !isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])
    ) {
        problem('We are sorry, but there appears to be a problem with the form you submitted.');
    }
    $name = $_POST['name']; // required
    $email = $_POST['email'];
    $message = $_POST['message']; // required
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if (!preg_match($email_exp, $email)) {
        $error_message .= 'The Email address you entered does not appear to be valid.<br>';
    }
    $string_exp = "/^[A-Za-z .'-]+$/";
    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br>';
    }
    if (strlen($message) < 2) {
        $error_message .= 'The Message you entered do not appear to be valid.<br>';
    }
    if (strlen($error_message) > 0) {
        problem($error_message);
    }
    $email_message = "Form details below.<br>";
    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }
    $email_message .= "Name: " . clean_string($name) . "<br>";
    $email_message .= "Email: " . clean_string($email) . "<br>";
    $email_message .= "Message: " . clean_string($message) . "<br>";
require 'PHP-SMTP-Mailer/class/SMTPMailer.php';
$mail = new SMTPMailer();
$mail->addTo($email);
$mail->Body($email_message);
if ($mail->Send()) echo 'I recieved your request successfully!';
else               echo 'There was a problem, kindly try contacting me again';


// Display the alert box 
// echo '<script>alert("Welcome to Geeks for Geeks")</script>';
