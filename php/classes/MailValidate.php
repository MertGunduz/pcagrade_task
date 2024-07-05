<?php
    /**
     * Class MailValidate
     *
     * This class provides methods to validate and check the email address before sending the form data according to RFC 5321 and RFC 5322 specifications.
     */
    class MailValidate
    {
        private $mail;

        /**
         * Initializes the mail variable with the given string parameter using the constructor method.
         *
         * @param string $mail The email address to initialize.
         */
        public function __construct(string $mail) 
        {
            $this->set_mail($mail);
        }

        /**
         * Sets the mail address.
         *
         * @param string $mail The email address to set.
         */
        public function set_mail(string $mail): void
        {
            $this->mail = $this->sanitize_email($mail);
        }

        /**
         * Gets the mail address.
         *
         * @return string The email address.
         */
        public function get_mail(): string
        {
            return $this->mail;
        }

        /**
         * Sanitizes the email address.
         *
         * @param string $email The email address to sanitize.
         * @return string The sanitized email address.
         */
        private function sanitize_email(string $email): string
        {
            return filter_var($email, FILTER_SANITIZE_EMAIL);
        }

        /**
         * Validates the email address using various checks.
         *
         * @return bool True if the email address is valid, false otherwise.
         */
        public function is_email_valid(): bool
        {
            // Take the email address and trim it to remove the spaces.
            $email = trim($this->mail);
            
            // Validate the email address syntax using regex.
            if (!(bool) preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) 
            {
                return false;
            }
            
            // Validate the email address by using default filter.
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                return false;
            }
            
            // Take the domain string data from the email.
            $domain = substr(strrchr($email, "@"), 1);
            
            // Check if the domain has a valid MX or A record.
            return checkdnsrr($domain, "MX") || checkdnsrr($domain, "A");
        }

        /**
         * Checks if the email address domain is from a disposable email provider.
         *
         * @return bool True if the domain is from a disposable email provider, false otherwise.
         */
        public function is_email_disposable(): bool
        {
            $domain = substr(strrchr($this->mail, "@"), 1);

            // Disposable_mails.txt list file path.
            $file_path = __DIR__ . '/../data/disposable_mails.txt';

            // Check if the file exists and is readable.
            if (!is_readable($file_path)) 
            {
                throw new RuntimeException("Disposable email list file not found or not readable.");
            }

            // Read the file into an array.
            $disposable_email_providers = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Check if the domain is in the list of disposable email providers.
            return in_array($domain, $disposable_email_providers);
        }
    }
