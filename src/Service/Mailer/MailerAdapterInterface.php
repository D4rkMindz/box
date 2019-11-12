<?php

namespace App\Service\Mailer;

/**
 * Interface MailerInterface.
 */
interface MailerAdapterInterface
{
    /**
     * Send HTML email.
     *
     * @param string $to   Receiver
     * @param string $subject
     * @param string $html Email content as HTML
     * @param string $text
     * @param string $from Forwarder
     *
     * @return bool
     */
    public function send(string $to, string $subject, string $html, string $text, string $from = null): bool;
}
