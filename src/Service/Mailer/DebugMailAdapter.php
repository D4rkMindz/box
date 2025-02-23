<?php

namespace App\Service\Mailer;

use App\Service\SettingsInterface;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Container\ContainerInterface;

/**
 * Class DebugMailAdapter.
 */
class DebugMailAdapter implements MailerAdapterInterface
{
    /**
     * @var PHPMailer
     */
    private $mailer;

    /**
     * DebugMailAdapter constructor.
     *
     * @param SettingsInterface $settings
     */
    public function __construct(SettingsInterface $settings)
    {
        $config = $settings->get('debugmail');
        $this->mailer = new PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = 0;
        $this->mailer->Host = $config['host'];
        $this->mailer->Port = $config['port'];
        $this->mailer->Username = $config['username'];
        $this->mailer->Password = $config['password'];
        $this->mailer->CharSet = 'UTF8';
        $this->mailer->SMTPAuth = true;
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Timeout = 10;
    }

    /**
     * Send Text email.
     *
     * @param string $to   Receiver
     * @param string $subject
     * @param string $html
     * @param string $text Email as String
     * @param string $from Forwarder
     *
     * @return bool
     */
    public function send(string $to, string $subject, string $html, string $text, string $from = null): bool
    {
        $this->mailer->setFrom($from);
        $this->mailer->Subject = $subject;
        $this->mailer->addAddress($to);
        $this->mailer->Body = $html;
        $this->mailer->AltBody = $text;
        return $this->mailer->send();
    }
}
