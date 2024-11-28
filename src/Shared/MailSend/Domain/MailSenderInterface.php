<?php

declare(strict_types=1);

namespace App\Shared\MailSend\Domain;

interface MailSenderInterface
{
    public function send(string $to, string $subject, string $body): void;
}
