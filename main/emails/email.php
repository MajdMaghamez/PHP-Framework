<?php namespace main\emails;

    class email
    {
        private static $transport;

        protected $subject;
        protected $recipients;
        protected $body;

        public function __construct ( $subject, $recipients, $body )
        {
            $this->subject = $subject;
            $this->recipients = $recipients;
            $this->body = $body;
        }

        private static function setConnection ( )
        {
            self::$transport = new \Swift_SmtpTransport ( $GLOBALS ["MAIL_HOST"], $GLOBALS ["MAIL_PORT"], $GLOBALS ["MAIL_ENCRYPTION"] );
            self::$transport->setUsername ( $GLOBALS ["MAIL_USER"] );
            self::$transport->setPassword ( $GLOBALS ["MAIL_PASS"] );
        }

        public static function sendEmail ( $subject, $recipients, $body )
        {
            self::setConnection ( );

            $message = new \Swift_Message ( );
            $message->setSubject ( $subject );
            $message->setFrom ( [ $GLOBALS ["MAIL_FROM"]["address"] => $GLOBALS ["MAIL_FROM"]["name"] ] );

            if ( ! empty ( $recipients ["to"] ) )       { $message->setTo ( $recipients ["to"] ); }
            elseif ( ! empty ( $recipients ["cc"] ) )   { $message->setCc ( $recipients ["cc"] ); }
            elseif ( ! empty ( $recipients ["bc"] ) )   { $message->setBcc( $recipients ["bc"] ); }

            $message->addBcc ( $GLOBALS ["MAIL_FROM"]["address"] );
            $message->setBody ( $body, "text/html" );

            $mail = new \Swift_Mailer ( self::$transport );

            return $mail->send ( $message );
        }
    }