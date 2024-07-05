<?php
    // Import MailValidate.
    require_once "classes/MailValidate.php";

    // Errors array to store the form submit errors.
    $form_submit_errors = [];

    // Check if name_surname passed correctly from the form and sanitize input.
    if (!isset($_POST["name_surname"]) || empty($_POST["name_surname"])) 
    {
        $form_submit_errors[] = "Please enter your name and surname.";
    }

    // Check if email_address passed correctly from the form and validate its format.
    if (!isset($_POST["email_address"]) || empty($_POST["email_address"])) 
    {
        $form_submit_errors[] = "Please enter your e-mail address.";
    }

    // Check if user_message passed correctly from the form and validate max length.
    if (!isset($_POST["user_message"]) || empty($_POST["user_message"])) 
    {
        $form_submit_errors[] = "Please enter message content.";
    }

    // Check if accept_terms checkbox is checked.
    if (!isset($_POST["accept_terms"])) 
    {
        $form_submit_errors[] = "Please accept terms and conditions.";
    }
    
    // If there are any errors, return them as JSON and exit.
    if (!empty($form_submit_errors)) 
    {
        echo json_encode(['success' => false, 'errors' => $form_submit_errors]);
        exit;
    }

    // Take name-surname and message, also use htmlspecialchars function to sanitize them for XSS attacks.
    $name_surname = htmlspecialchars(filter_input(INPUT_POST, "name_surname", FILTER_SANITIZE_STRING));
    $user_message = htmlspecialchars(filter_input(INPUT_POST, "user_message", FILTER_SANITIZE_STRING));

    // Take email without htmlspecialchars function.
    $email_address = $_POST["email_address"];

    // Create a MailValidate object.
    $mail_validator = new MailValidate($email_address);

    // Check if the email address syntax is valid.
    if (!$mail_validator->is_email_valid()) 
    {
        echo json_encode(['success' => false, 'errors' => ["Email syntax is not valid or DNS checks are unsuccessful, please check again or try with a different mail."]]);
        exit;
    }

    // Check if the email address domain is from a disposable email provider.
    if ($mail_validator->is_email_disposable()) 
    {
        echo json_encode(['success' => false, 'errors' => ["Email domain is from a disposable provider, please use your original email address."]]);
        exit;
    }

    // Return the message successfully sent information to user.
    echo json_encode(['success' => true, 'message' => "Message sent successfully."]);
