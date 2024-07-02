<?php
/**
 * Class MailValidate
 *
 * This class provides methods to validate and check the email address before sending the form data.
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
        $email = $this->mail;

        // Removing spaces from the email
        $email = trim($email);

        // Basic syntax validation using regex
        if (!$this->has_valid_syntax($email)) {
            return false;
        }

        // Validate email format using PHP's built-in filter
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Extract the domain from the email
        $domain = $this->extract_domain($email);

        // Check if the domain has a valid MX or A record
        return $this->has_valid_dns($domain);
    }

    /**
     * Checks if the email address domain is from a known disposable email provider.
     *
     * @return bool True if the domain is from a disposable email provider, false otherwise.
     */
    public function is_email_disposable(): bool
    {
        $domain = $this->extract_domain($this->mail);

        // Path to disposable email list file
        $file_path = __DIR__ . '/../data/disposable_mails.txt';

        // Read the file into an array
        $disposable_email_providers = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Check if the domain is in the list of disposable email providers
        return in_array($domain, $disposable_email_providers);
    }

    /**
     * Checks if the email address is role-based (e.g., admin@domain.com).
     *
     * @return bool True if the email address is role-based, false otherwise.
     */
    public function is_email_role_based(): bool
    {
        $local_part = $this->extract_local_part($this->mail);

        $role_based_emails = [
            'admin', 'administrator', 'info',
            'contact', 'support', 'sales',
            'office', 'noreply', 'no-reply',
            'helpdesk', 'service', 'marketing',
            'hr', 'jobs', 'careers',
            'techsupport', 'it', 'sysadmin',
            'finance', 'accounting', 'billing',
            'press', 'media','pr',
            'legal', 'dev', "staff"
        ];

        return in_array(strtolower($local_part), $role_based_emails);
    }

    /**
     * Validates the syntax of the email address using a regex pattern.
     *
     * @param string $email The email address to validate.
     * @return bool True if the email address has valid syntax, false otherwise.
     */
    private function has_valid_syntax(string $email): bool
    {
        return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
    }

    /**
     * Extracts the domain part of the email address.
     *
     * @param string $email The email address to extract the domain from.
     * @return string The domain part of the email address.
     */
    private function extract_domain(string $email): string
    {
        return substr(strrchr($email, "@"), 1);
    }

    /**
     * Extracts the local part of the email address.
     *
     * @param string $email The email address to extract the local part from.
     * @return string The local part of the email address.
     */
    private function extract_local_part(string $email): string
    {
        return strstr($email, '@', true);
    }

    /**
     * Checks if the domain has valid DNS records (MX or A).
     *
     * @param string $domain The domain to check.
     * @return bool True if the domain has valid DNS records, false otherwise.
     */
    private function has_valid_dns(string $domain): bool
    {
        return checkdnsrr($domain, "MX") || checkdnsrr($domain, "A");
    }
}