
# ticket-price-modeling

## お題

[https://cinemacity.co.jp/ticket/](https://cinemacity.co.jp/ticket/)

[#チケット料金モデリング](https://twitter.com/search?q=%23%E3%83%81%E3%82%B1%E3%83%83%E3%83%88%E6%96%99%E9%87%91%E3%83%A2%E3%83%87%E3%83%AA%E3%83%B3%E3%82%B0&src=typed_query&f=live)

## ドメインモデル

![model dialog](http://www.plantuml.com/plantuml/proxy?src=https://gist.githubusercontent.com/ngmy/ea2957b7146d523a813a563fab578f90/raw)

## 動作確認

```
$ php artisan tinker
Psy Shell v0.9.9 (PHP 7.2.12 — cli) by Justin Hileman
>>> $service = app(Ngmy\TicketPrice\App\TicketPriceService::class);
=> Ngmy\TicketPrice\App\TicketPriceService {#2880}
>>> $command = new Ngmy\TicketPrice\App\GetTicketPriceByCommand(3, "2019-07-18 20:00:00");
=> Ngmy\TicketPrice\App\GetTicketPriceByCommand {#2885}
>>> $service->getTicketPriceBy($command);
=> 1300
>>> $command->setIsGokubakuScreening(true);
=> Ngmy\TicketPrice\App\GetTicketPriceByCommand {#2885}
>>> $service->getTicketPriceBy($command);
=> 1800
>>> $command->setIsThreeDimensionalMovie(true);
=> Ngmy\TicketPrice\App\GetTicketPriceByCommand {#2885}
>>> $service->getTicketPriceBy($command);
=> 2200
>>> $command->setHasThreeDimensionalGlasses(true);
=> Ngmy\TicketPrice\App\GetTicketPriceByCommand {#2885}
>>> $service->getTicketPriceBy($command);
=> 2100
>>> 
```

## テスト

```
$ php vendor/bin/phpunit
```
