<?php


namespace App\Service;

class SendMailService
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(
        string $from,
        string $to,
        string $template,
        array $context
    ) : void
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $template,
                $context
            );

        $this->mailer->send($message);
    }
}