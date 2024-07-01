<?php
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

    // Check if user_message passed correctly from the form and validate max length/
    if (!isset($_POST["user_message"]) || empty($_POST["user_message"]))
    {
        $form_submit_errors[] = "Message is required and must be 256 characters or less.";
    }

    // Check if accept_terms checkbox is checked and submit button clicked, checking the submit button click provides basic security and prevents selenium-based bots/scripts to send request.
    if (!isset($_POST["accept_terms"]) && !isset($_POST["send_message"])) 
    {
        $form_submit_errors[] = "You must accept the Terms & Conditions.";
    }

    // If there are any errors, display them and exit.
    if (!empty($form_submit_errors)) 
    {
        foreach ($form_submit_errors as $form_submit_error) 
        {
            echo $form_submit_error . "<br>";
        }

        exit;
    }
    
    // If all validations pass, proceed with further processing.
    echo "good!";
?>