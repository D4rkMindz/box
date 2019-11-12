<?php

namespace App\Service\Mailer;

use Exception;
use Mailgun\Mailgun;
use Psr\Log\LoggerInterface;

/**
 * Class MailgunAdapter.
 */
class MailgunAdapter implements MailerAdapterInterface
{
    /**
     * @var Mailgun
     */
    private $mail;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string email
     */
    private $from;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * MailgunAdapter constructor.
     *
     * @param string          $apiKey
     * @param string          $domain
     * @param string          $sender email
     * @param LoggerInterface $logger
     */
    public function __construct(string $apiKey, string $domain, string $sender, LoggerInterface $logger)
    {
        $this->mail = Mailgun::create($apiKey);
        $this->domain = $domain;
        $this->from = $sender;
        $this->logger = $logger;
    }

    /**
     * Get domain name.
     *
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Send Text email.
     *
     * @param string $to   Receiver
     * @param string $subject
     * @param string $text Email as String
     * @param string $from Forwarder
     * @param string $html
     *
     * @return bool
     */
    public function send(string $to, string $subject, string $html, string $text, string $from = null): bool
    {
        if (empty($from)) {
            $from = $this->from;
        }
        $mailConfig = [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'text' => $text,
            'html' => $html,
        ];
        try {
            $this->mail->messages()->send($this->getDomain(), $mailConfig);
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message .= '\n';
            $message .= $e->getTraceAsString();
            $this->logger->error($message);

            return false;
        }

        return true;
    }
}
