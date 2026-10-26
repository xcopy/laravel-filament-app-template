<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Monolog\Handler\SlackWebhookHandler;
use Monolog\Logger;

class SendExceptionNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $level, public $message, public $context = [])
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $config = config('logging.channels.slack');

        $logger = new Logger('logger');
        $logger->pushHandler(
            new SlackWebhookHandler(
                webhookUrl: $config['url'],
                username: $config['username'],
                iconEmoji: $config['emoji'],
                includeContextAndExtra: true,
                level: $this->level,
            )
        );
        $logger->log($this->level, $this->message, $this->context);
    }
}
