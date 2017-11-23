<?php

namespace App\Service\Notification\Sender;

class EmailSender implements NotificationSenderInterface
{
    private $mailer;
    private $from;
    private $subject;
    private $emails;


    public function __construct(\Swift_Mailer $mailer, string $from, string $subject, array $emails)
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->subject = $subject;
        $this->emails = $emails;
    }


    public function send(string $notification_text): void
    {
        $message = (new \Swift_Message($this->subject))
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo($this->emails)
            ->setBody($notification_text);

        $this->mailer->send($message);
    }
}