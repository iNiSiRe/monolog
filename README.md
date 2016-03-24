# Monolog
Slack handler for monolog

#Usage

Example for Symfony2.

Create channel:

slack.channel.log:
    class: Slack\Model\Channel
    arguments: ["https://hooks.slack.com/services/XXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"]

monolog.handler.slack:
    class: Monolog\Handler\Custom\SlackHandler
    calls:
      - [setLevel, [400]]
      - [setChannel, [@slack.channel.log]]