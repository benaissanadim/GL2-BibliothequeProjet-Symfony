<?php


namespace App\Service;
use Twig\Environment;



class SendMailService
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {

        $this->mailer = $mailer;
        $this->twig = $twig;

    }

    public function send(
        string $subject,
        string $to,
        string $from,
        string $template,
        string $contentType,
        array $context

    ) : void
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)

            ->setBody(
                $this->twig->render($template, $context),
                $contentType,
            );
        $this->mailer->send($message);
    }
}
