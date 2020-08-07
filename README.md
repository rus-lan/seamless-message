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
* `UniqueNameBot` need for generate route name and file translation
* `source` type bot, need for correct set objects and pars
* `default_controller` the optional parent, if need custom logic
* `routers` list command in any channel (chat/channel).

### custom button in telegram
you need to add a translation file containing a list of buttons and command names. example for bot before code (file name `telegram_UniqueNameBot.ru.yml`):
```yaml
button:
    chat:
        cancel: Отмена # add option 'cancel' for present action (example: '/command_1 cancel')
        lang: Сменить язык
        lang_ru: 🇷🇺 Русский
        lang_en: 🇬🇧 Английский
route:
    chat:
        command_1: Приватная команда 1 # run action MyApp\Controller\Chat\CommandController::command_1
        command_2: Приватная команда 2 # run action MyApp\Controller\Chat\CommandController::command_1
    channel:
        command: Команда в общем чате # run action MyApp\Controller\Channel\CommandController::command
```