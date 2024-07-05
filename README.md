# PCA Grade Task

This task was completed by Mehmet Mert Gunduz in 3 days. It involves creating a small web application that includes an HTML form, JavaScript to handle form submission via AJAX using the fetch API, and a PHP file to process the form data and return a response. The application performs various validations to ensure data integrity and security.

## Screenshot

![pcagrade_task](https://github.com/MertGunduz/pcagrade_task/assets/65850970/70673d90-2569-4fa5-8b64-62b8e9487793)

## Features

1. **HTML Form**:
    - The form includes the following fields:
        - Name (text input)
        - Email (text input)
        - Message (textarea)
        - Terms and Conditions (checkbox)
    - A submit button to send the form data.

2. **JavaScript (AJAX using fetch)**:
    - Vanilla JavaScript is used to capture the form submission.
    - Form data is sent to the PHP file using a fetch request.
    - The response from the PHP file is displayed in the HTML page without refreshing.

3. **PHP File**:
    - The PHP file receives the form data via a POST request.
    - Validates the form data by ensuring all fields are filled and the email is valid.
    - Returns a JSON response indicating success or failure.
    - Defines return types and follows Psalm and PHPStan rules.
    - Follows PSR Standards.
    - Uses PHPDoc comments.

## File Structure

- **send_message.php**: PHP file to process the form data and return a response.
- **MailValidate.php**: PHP class to validate and check the email address.
- **ajax_post.js**: JavaScript file to handle the form submission using AJAX.
- **c_count.js**: Javascript file to handle the textarea character counter text.
- **index.html**: The main HTML file that contains the form.
  
## PHP Implementation Details

### MailValidate.php

This class provides methods to validate and check the email address before sending the form data according to RFC 5321 and RFC 5322 specifications. It includes methods to:
- Sanitize the email address.
- Validate the email address using regex and DNS checks.
- Check if the email address domain is from a disposable email provider.

### send_message.php

This file processes the form data and performs the following tasks:
- Validates if all fields are filled.
- Sanitizes the name and message to prevent XSS attacks.
- Creates an instance of the MailValidate class to validate the email address.
- Checks if the email address syntax is valid and if it belongs to a disposable email provider.
- Returns a JSON response indicating success or failure.
