<?php 
    /**
     * Class MailValidate
     *
     * This class provides methods below to validate and check the mail address before sending the form data.
     */
    class MailValidate
    {
        private $mail;

        /**
         * Initializes the mail variable with the given string parameter by using constructor method.
         */
        public function __construct(string $mail) 
        {
            $this->mail = $mail;
        }

        /**
         * Set the mail.
         */
        public function set_mail(string $mail)
        {
            $this->mail = $mail;
        }

        /**
         * Get the mail.
         */
        public function get_mail(): ?string
        {
            return $this->mail;
        }
    }
?>