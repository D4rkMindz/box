<?php

use App\Service\AMQP\AMQPInterface;
use App\Service\Mailer\DebugMailAdapter;
use App\Service\Mailer\MailerAdapterInterface;
use App\Service\SettingsInterface;
use Odan\Twig\TwigTranslationExtension;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Mailer container.
 *
 * @param SettingsInterface $settings
 *
 * @return MailerAdapterInterface
 */
$container[MailerAdapterInterface::class] = static function (SettingsInterface $settings) {
    return new DebugMailAdapter($settings);
};

/**
 * Twig container.
 *
 * USED IN EMAIL RENDERING IN USERCONTROLLER!
 *
 * @param SettingsInterface $settings
 *
 * @return Twig_Environment
 */
$container[Twig_Environment::class] = static function (SettingsInterface $settings): Twig_Environment {
    $twigSettings = $settings->get('twig');
    $loader = new Twig_Loader_Filesystem($twigSettings['viewPath']);
    $twig = new Twig_Environment($loader, ['cache' => $twigSettings['cachePath']]);
    $twig->addExtension(new TwigTranslationExtension());

    return $twig;
};
