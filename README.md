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
        <unique_slug_bot>:
            name: UniqueNameBot
            source: !php/const \RusLan\SeamlessMessage\Bundle\Doctrine\Type\SourceTypeEnum::source__telegram
            default_controller: \MyApp\Controller\DefaultController
            routers:
                !php/const \RusLan\SeamlessMessage\Bundle\Doctrine\Type\ChatTypeEnum::channel_chat:
                    command_1: { action: MyApp\Controller\Chat\CommandController::command_1, method: POST }
                    command_2: { action: MyApp\Controller\Chat\CommandController::command_2 }
                !php/const \RusLan\SeamlessMessage\Bundle\Doctrine\Type\ChatTypeEnum::channel_channel:
                    command: { action: MyApp\Controller\Channel\CommandController::command }
```
* `<unique_slug_bot>` need for generate url.
* `UniqueNameBot` need for generate route name.
* `source` type bot, need for correct set objects and pars
* `default_controller` the optional parent, if need custom logic
* `routers` list command in any channel (chat/channel).