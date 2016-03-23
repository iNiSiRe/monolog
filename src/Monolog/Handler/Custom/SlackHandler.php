<?php

namespace Monolog\Handler\Custom;

use Monolog\Handler\AbstractProcessingHandler;
use Slack\Model\Channel;
use Slack\Model\Message;

class SlackHandler extends AbstractProcessingHandler
{
    /**
     * @var Channel
     */
    protected $channel;

    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     *
     * @return void
     */
    protected function write(array $record)
    {
        $content = $record['formatted'];
        $message = (new Message())
            ->setUsername('logger')
            ->setText($content);

        $this->channel->send($message);
    }}