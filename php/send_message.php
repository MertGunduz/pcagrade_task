<?php
    // Import MailValidate.
    require_once "classes/MailValidate.php";

    // Errors array to store the form submit errors.
    $form_submit_errors = [];

    // Check if name_surname passed correctly from the form and sanitize input.
    if (!isset($_POST["name_surname"]) || empty($_POST["name_surname"])) 
    {
        $form_submit_errors[] = "Name & Surname is required.";
    }

    // Check if email_address passed correctly from the form and validate its format.
    if (!isset($_POST["email_address"]) || empty($_POST["email_address"])) 
    {
        $form_submit_errors[] = "A valid Email Address is required.";
    }

    // Check if user_message passed correctly from the form and validate max length.
    if (!isset($_POST["user_message"]) || empty($_POST["user_message"])) 
    {
        $form_submit_errors[] = "Message is required and must be 256 characters or less.";
    }

    // Check if accept_terms checkbox is checked and submit button clicked/
    if (!isset($_POST["accept_terms"])) 
    {
        $form_submit_errors[] = "You must accept the Terms & Conditions.";
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

    // Check if the email address syntax is valid
    if (!$mail_validator->is_email_valid()) 
    {
        echo json_encode(['success' => false, 'errors' => ["Email syntax is not valid."]]);
        exit;
    }

    // Check if the email address domain is from a known disposable email provider
    if ($mail_validator->is_email_disposable()) 
    {
        echo json_encode(['success' => false, 'errors' => ["Email domain is from a disposable provider."]]);
        exit;
    }

    // If all checks pass, process the message (e.g., send an email, save to database, etc.)
    // For demonstration, we'll just return a success message.
    echo json_encode(['success' => true, 'message' => "Message sent successfully."]);
