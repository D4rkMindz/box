<?php

namespace App\Service\Mailer;

use App\Service\SettingsInterface;
use RuntimeException;
use Slim\Views\Twig;

/**
 * Class UserMailer
 */
class UserMailer
{
    /** @var string */
    private $baseUrl;
    /** @var array all social media links (facebook, instagram, twitter) with the according URL */
    private $socialMediaLinks;

    /** @var MailerAdapterInterface */
    protected $mailer;

    /** @var Twig */
    protected $twig;

    /**
     * Mailer constructor.
     *
     * @param MailerAdapterInterface $mailerAdapter
     * @param Twig                   $twig
     * @param SettingsInterface      $settings
     */
    public function __construct(MailerAdapterInterface $mailerAdapter, Twig $twig, SettingsInterface $settings)
    {
        $this->mailer = $mailerAdapter;
        // TODO create a renderer instead of using twig.
        $this->twig = $twig;
        $urls = $settings->get('url');
        $this->baseUrl = $urls['base'];
        $this->socialMediaLinks = $urls['social_media'];
    }

    /**
     * Send registration email
     *
     * @param string $email
     * @param string $emailtoken
     */
    public function sendWelcomeEmail(string $email, string $emailtoken)
    {
        $viewData = $this->socialMediaLinks;
        $viewData['link'] = $this->baseUrl . '/signup/' . $emailtoken;

        $html = $this->twig->fetch('Email/welcome.html.twig', $viewData);
        $text = $this->twig->fetch('Email/welcome.txt.twig', $viewData);
        $sent = $this->mailer->send(
            $email,
            __('Thanks for Your Registration at Venovum'),
            $html,
            $text,
            'registration@venovum.com'
        );

        if (!$sent) {
            throw new RuntimeException(__('Sending an email failed'));
        }
    }

    /**
     * Send a welcome email
     *
     * @param string $email
     */
    public function sendRegistrationEmail(string $email)
    {
        $viewData = [
            'link' => 'https://venovum.com',
            'instagram' => 'https://instagram.com/venovum',
            'twitter' => 'https://twitter.com/venovum',
            'facebook' => 'https://www.facebook.com/venovum',
        ];
        $html = $this->twig->fetch('Email/registration.html.twig', $viewData);
        $text = $this->twig->fetch('Email/registration.txt.twig', $viewData);
        $this->mailer->send(
            $email,
            __('Welcome to Venovum'),
            $html,
            $text,
            'registration@venovum.com'
        );
    }
}
