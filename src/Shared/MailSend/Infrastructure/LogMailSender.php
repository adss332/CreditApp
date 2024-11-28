<?php

declare(strict_types=1);

namespace App\Shared\MailSend\Infrastructure;

use App\Shared\MailSend\Domain\MailSenderInterface;
use Psr\Log\LoggerInterface;

class LogMailSender implements MailSenderInterface
{
    private LoggerInterface $logger;

    public function setLogger(LoggerInterface $emailLogger): void
    {
        $this->logger = $emailLogger;
    }

    public function send(string $to, string $subject, string $body): void
    {
        $logMessage = sprintf(
            "Send email:\nTo: %s\nSubject: %s\nText:\n%s\n\n",
            $to,
            $subject,
            $body,
        );

        $this->logger->info($logMessage);
    }
}
