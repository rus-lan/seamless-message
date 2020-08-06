# Seamless Message
### install
require
```bash
composer require rus-lan/seamless-message
```
add bundle
```php
return [
    ...
    RusLan\SeamlessMessage\Bundle\SeamlessMessageBundle::class => ['all' => true],
];
```
add route
```yaml
seamless_message:
    resource: "@SeamlessMessageBundle/Resources/routes/extra.yml"
```
add configure package (`seamless_message.yml` file)
```yaml
seamless_message:
    bots:
        <unique_name_bot>:
            name: NameBot
            source: !php/const \AppBundle\Doctrine\Type\SourceTypeEnum::source__telegram
            default_controller: \InvestProfitBot\Controller\DefaultController
            routers:
                !php/const \AppBundle\Doctrine\Type\ChatTypeEnum::channel_chat:
                    start: { action: InvestProfitBot\Controller\Chat\StartController::start, method: POST }
                    help: { action: InvestProfitBot\Controller\Chat\HelpController::help, method: POST }
                !php/const \AppBundle\Doctrine\Type\ChatTypeEnum::channel_channel:
                    help: { action: InvestProfitBot\Controller\Channel\HelpController::help }
        <unique_name_bot2>:
            ...
```