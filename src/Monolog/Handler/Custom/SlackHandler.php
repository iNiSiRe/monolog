<?php

namespace Monolog\Handler\Custom;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Slack\Model\Channel;
use Slack\Model\Message;
use Slack\Model\MessageField;

class SlackHandler extends AbstractProcessingHandler
{
    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var string
     */
    protected $username = 'logger';

    /**
     * @param Channel $channel
     */
    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Returned a Slack message attachment color
     *
     * @param  int $level
     *
     * @return string
     */
    protected function getAttachmentColor($level)
    {
        switch (true) {
            case $level >= Logger::ERROR:
                return 'danger';
            case $level >= Logger::WARNING:
                return 'warning';
            case $level >= Logger::INFO:
                return 'good';
            default:
                return '#e3e4e6';
        }
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
        $message = (new Message())
            ->setUsername('logger')
            ->addField(new MessageField('Level', $record['level_name'], true))
            ->setText($record['message'])
            ->setColor($this->getAttachmentColor($record['level']));

        $this->channel->send($message);
    }
}