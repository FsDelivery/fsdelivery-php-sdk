<a href="https://fsdelivery.ru"><img align="right" width="200" src="https://fsdelivery.ru/template/shared/image/fsdelivery/logo.png"></a>
<br  />

[![Latest Stable Version](https://poser.pugx.org/FsDelivery/fsdelivery-php-sdk/v/stable)](https://packagist.org/packages/FsDelivery/fsdelivery-php-sdk)
[![Total Downloads](https://poser.pugx.org/FsDelivery/fsdelivery-php-sdk/downloads)](https://packagist.org/packages/FsDelivery/fsdelivery-php-sdk)
[![License](https://poser.pugx.org/FsDelivery/fsdelivery-php-sdk/license)](https://packagist.org/packages/FsDelivery/fsdelivery-php-sdk)

# SDK для [интеграции с программным комплексом FsDelivery](https://fsdelivery.ru).  

Документация к [API](https://api.fsdelivery.ru/doc/index.html).

# Содержание
[Changelog](#changelog)  
[Установка](#install)  
[Отладка](#debugging)  
[Расчет тарифа](#tariffs)  
[Получение списка служб доставки](#delivery_list)  
[Получение списка режимов доставки](#delivery_types)  
[Получение списка тарифов](#delivery_tariffs)  
[Получение списка возможных статусов заказа](#delivery_order_statuses)  
[Получение списка стран](#countries)  
[Получение списка городов](#cities)  
[Получение списка городов для AUTOCOMPLETE](#cities_autocomplete)  
[Получение списка пунктов выдачи заказов (ПВЗ)](#delivery_points)  
[Детализация по реестру НП](#reestr_waybills)  
[Возможные статусы реестров НП](#reestr_statuses)  
[Список реестров НП](#reestr_list)  
[Получение информации о пользователе](#userinfo)  
[Получение статусов заказа](#order_statuses)  
[Получение информации по зказам](#orders_info)  

<a name="changelog"><h1>Changelog</h1></a>
- 0.5.0 - Первая версия SDK реализующая методы [API FsDelivery](https://api.fsdelivery.ru/doc/index.html);

<a name="install"><h1>Установка</h1></a>
Для установки можно использовать менеджер пакетов Composer

    composer require fsdelivery/fsdelivery-php-sdk

<a name="debugging"><h1>Отладка</h1></a>  
Для логирования запросов и ответов используется [стандартный PSR-3 логгер](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).
Ниже приведен пример логирования используя [Monolog](https://github.com/Seldaek/monolog).

```php
<?php
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler('log.txt', Logger::INFO));

    $Client = new \FsDeliverySdk\Client('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9');
    $Client->setLogger($log);
```
В log.txt будут логи в виде:
```
[2021-12-18T16:55:44.886552+00:00] name.INFO: FsDelivery API POST request /1.0/tariff/calculation: {"tariff_id_list":[136,137,233,234,4000,4001,4003],"delivery_company_id":[1,55],"sender_city_id":44,"reciver_city_index":630001,"packages":[{"length":10,"height":10,"width":10,"weight":0.5}],"items":[{"insurance":1000,"payment_sum":1000}]} [] []
[2021-12-18T16:55:45.971776+00:00] name.INFO: FsDelivery API response /1.0/tariff/calculation: {"request_id":"dc97011a-20f5-45a4-9200-40ee7e174122","tariffs":{"1":{"136":{"tariff_id":136,"min_day":3,"max_day":5,"sum":649,"total_sum":690.25,"services":[{"id":2,"name":"\u0421\u0442\u0440\u0430\u0445\u043e\u0432\u0430\u043d\u0438\u0435","sum":7.5,"rate":0.75},{"id":19,"name":"\u0410\u0433\u0435\u043d\u0442\u0441\u043a\u043e\u0435 \u0432\u043e\u0437\u043d\u0430\u0433\u0440\u0430\u0436\u0434\u0435\u043d\u0438\u0435","sum":30,"rate":3}],"tariff_name":"\u041f\u043e\u0441\u044b\u043b\u043a\u0430 \u0441\u043a\u043b\u0430\u0434-\u0441\u043a\u043b\u0430\u0434"},"137":{"tariff_id":137,"min_day":3,"max_day":5,"sum":803,"total_sum":844.25,"services":[{"id":2,"name":"\u0421\u0442\u0440\u0430\u0445\u043e\u0432\u0430\u043d\u0438\u0435","sum":7.5,"rate":0.75},{"id":19,"name":"\u0410\u0433\u0435\u043d\u0442\u0441\u043a\u043e\u0435 \u0432\u043e\u0437\u043d\u0430\u0433\u0440\u0430\u0436\u0434\u0435\u043d\u0438\u0435","sum":30,"rate":3}],"tariff_name":"\u041f\u043e\u0441\u044b\u043b\u043a\u0430 \u0441\u043a\u043b\u0430\u0434-\u0434\u0432\u0435\u0440\u044c"},"233":{"tariff_id":233,"min_day":4,"max_day":5,"sum":385,"total_sum":426.25,"services":[{"id":2,"name":"\u0421\u0442\u0440\u0430\u0445\u043e\u0432\u0430\u043d\u0438\u0435","sum":7.5,"rate":0.75},{"id":19,"name":"\u0410\u0433\u0435\u043d\u0442\u0441\u043a\u043e\u0435 \u0432\u043e\u0437\u043d\u0430\u0433\u0440\u0430\u0436\u0434\u0435\u043d\u0438\u0435","sum":30,"rate":3}],"tariff_name":"\u042d\u043a\u043e\u043d\u043e\u043c\u0438\u0447\u043d\u0430\u044f \u043f\u043e\u0441\u044b\u043b\u043a\u0430 \u0441\u043a\u043b\u0430\u0434-\u0434\u0432\u0435\u0440\u044c"},"234":{"tariff_id":234,"min_day":4,"max_day":5,"sum":253,"total_sum":294.25,"services":[{"id":2,"name":"\u0421\u0442\u0440\u0430\u0445\u043e\u0432\u0430\u043d\u0438\u0435","sum":7.5,"rate":0.75},{"id":19,"name":"\u0410\u0433\u0435\u043d\u0442\u0441\u043a\u043e\u0435 \u0432\u043e\u0437\u043d\u0430\u0433\u0440\u0430\u0436\u0434\u0435\u043d\u0438\u0435","sum":30,"rate":3}],"tariff_name":"\u042d\u043a\u043e\u043d\u043e\u043c\u0438\u0447\u043d\u0430\u044f \u043f\u043e\u0441\u044b\u043b\u043a\u0430 \u0441\u043a\u043b\u0430\u0434-\u0441\u043a\u043b\u0430\u0434"},"delivery_company_id":1,"delivery_company_name":"Cdek"},"55":{"4000":{"tariff_id":"4000","min_day":3,"max_day":5,"sum":295.54,"total_sum":325.54,"services":[{"id":2,"name":"\u0421\u0442\u0440\u0430\u0445\u043e\u0432\u0430\u043d\u0438\u0435","sum":0,"rate":0.75},{"id":19,"name":"\u0410\u0433\u0435\u043d\u0442\u0441\u043a\u043e\u0435 \u0432\u043e\u0437\u043d\u0430\u0433\u0440\u0430\u0436\u0434\u0435\u043d\u0438\u0435","sum":30,"rate":3}],"tariff_name":"\u041f\u043e\u0441\u044b\u043b\u043a\u0430"},"4001":{"tariff_id":"4001","min_day":3,"max_day":5,"sum":276.96,"total_sum":306.96,"services":[{"id":2,"name":"\u0421\u0442\u0440\u0430\u0445\u043e\u0432\u0430\u043d\u0438\u0435","sum":0,"rate":0.75},{"id":19,"name":"\u0410\u0433\u0435\u043d\u0442\u0441\u043a\u043e\u0435 \u0432\u043e\u0437\u043d\u0430\u0433\u0440\u0430\u0436\u0434\u0435\u043d\u0438\u0435","sum":30,"rate":3}],"tariff_name":"\u041f\u043e\u0441\u044b\u043b\u043a\u0430 \u043e\u043d\u043b\u0430\u0439\u043d"},"4003":{"tariff_id":"4003","min_day":2,"max_day":4,"sum":400.04,"total_sum":430.04,"services":[{"id":2,"name":"\u0421\u0442\u0440\u0430\u0445\u043e\u0432\u0430\u043d\u0438\u0435","sum":0,"rate":0.75},{"id":19,"name":"\u0410\u0433\u0435\u043d\u0442\u0441\u043a\u043e\u0435 \u0432\u043e\u0437\u043d\u0430\u0433\u0440\u0430\u0436\u0434\u0435\u043d\u0438\u0435","sum":30,"rate":3}],"tariff_name":"\u041f\u043e\u0441\u044b\u043b\u043a\u0430 1 \u043a\u043b\u0430\u0441\u0441"},"delivery_company_id":55,"delivery_company_name":"RussianPost"}}} {"Server":["nginx/1.18.0 (Ubuntu)"],"Content-Type":["application/json"],"Transfer-Encoding":["chunked"],"Connection":["keep-alive"],"Set-Cookie":["PHPSESSID=1pdul37glve4qbenqq0ash9t0n; path=/; HttpOnly; SameSite=lax"],"Cache-Control":["max-age=0, must-revalidate, private"],"Date":["Sat, 18 Dec 2021 16:55:45 GMT"],"X-Robots-Tag":["noindex"],"Expires":["Sat, 18 Dec 2021 16:55:45 GMT"],"http_status":200} []
```

<a name="tariffs"><h1>Расчет тарифа</h1></a>  

Для расчета стоимости доставки используйте метод **calculateTariff**.

**Входные параметры:**
- *$calcParams* - объект FsDeliverySdk\ValueObject\CalculateParams;

**Выходные параметры:**
- *array* - список тарифов по заданным параметрам расчета

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $package = new \FsDeliverySdk\ValueObject\Package();
        $package->setHeight(10);
        $package->setWidth(10);
        $package->setLength(10);
        $package->setWeight(0.5);
    
        $item = new \FsDeliverySdk\ValueObject\Item();
        $item->setInsurance(1000);
        $item->setPaymentSum(1000);
    
        $calcParams = new \FsDeliverySdk\ValueObject\CalculateParams();
        $calcParams->setSenderCityId(44);
        $calcParams->setReciverCityIndex(630001);
        $calcParams->setTariffIdList([136,137,233,234,4000,4001,4003]);
        $calcParams->setAddItemsPrices(0);
        $calcParams->setDeliveryCompanyId([1,55]);
        $calcParams->addPackage($package);
        $calcParams->addItem($item);
    
        $result = $client->calculateTariff($calcParams);
        
        /*
         * Array
        (
            [request_id] => dc97011a-20f5-45a4-9200-40ee7e174122
            [tariffs] => Array
                (
                    [1] => Array
                        (
                            [136] => Array
                                (
                                    [tariff_id] => 136
                                    [min_day] => 3
                                    [max_day] => 5
                                    [sum] => 649
                                    [total_sum] => 690.25
                                    [services] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 2
                                                    [name] => Страхование
                                                    [sum] => 7.5
                                                    [rate] => 0.75
                                                )
        
                                            [1] => Array
                                                (
                                                    [id] => 19
                                                    [name] => Агентское вознаграждение
                                                    [sum] => 30
                                                    [rate] => 3
                                                )
        
                                        )
        
                                    [tariff_name] => Посылка склад-склад
                                )
        
                            [137] => Array
                                (
                                    [tariff_id] => 137
                                    [min_day] => 3
                                    [max_day] => 5
                                    [sum] => 803
                                    [total_sum] => 844.25
                                    [services] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 2
                                                    [name] => Страхование
                                                    [sum] => 7.5
                                                    [rate] => 0.75
                                                )
        
                                            [1] => Array
                                                (
                                                    [id] => 19
                                                    [name] => Агентское вознаграждение
                                                    [sum] => 30
                                                    [rate] => 3
                                                )
        
                                        )
        
                                    [tariff_name] => Посылка склад-дверь
                                )
        
                            [233] => Array
                                (
                                    [tariff_id] => 233
                                    [min_day] => 4
                                    [max_day] => 5
                                    [sum] => 385
                                    [total_sum] => 426.25
                                    [services] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 2
                                                    [name] => Страхование
                                                    [sum] => 7.5
                                                    [rate] => 0.75
                                                )
        
                                            [1] => Array
                                                (
                                                    [id] => 19
                                                    [name] => Агентское вознаграждение
                                                    [sum] => 30
                                                    [rate] => 3
                                                )
        
                                        )
        
                                    [tariff_name] => Экономичная посылка склад-дверь
                                )
        
                            [234] => Array
                                (
                                    [tariff_id] => 234
                                    [min_day] => 4
                                    [max_day] => 5
                                    [sum] => 253
                                    [total_sum] => 294.25
                                    [services] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 2
                                                    [name] => Страхование
                                                    [sum] => 7.5
                                                    [rate] => 0.75
                                                )
        
                                            [1] => Array
                                                (
                                                    [id] => 19
                                                    [name] => Агентское вознаграждение
                                                    [sum] => 30
                                                    [rate] => 3
                                                )
        
                                        )
        
                                    [tariff_name] => Экономичная посылка склад-склад
                                )
        
                            [delivery_company_id] => 1
                            [delivery_company_name] => Cdek
                        )
        
                    [55] => Array
                        (
                            [4000] => Array
                                (
                                    [tariff_id] => 4000
                                    [min_day] => 3
                                    [max_day] => 5
                                    [sum] => 295.54
                                    [total_sum] => 325.54
                                    [services] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 2
                                                    [name] => Страхование
                                                    [sum] => 0
                                                    [rate] => 0.75
                                                )
        
                                            [1] => Array
                                                (
                                                    [id] => 19
                                                    [name] => Агентское вознаграждение
                                                    [sum] => 30
                                                    [rate] => 3
                                                )
        
                                        )
        
                                    [tariff_name] => Посылка
                                )
        
                            [4001] => Array
                                (
                                    [tariff_id] => 4001
                                    [min_day] => 3
                                    [max_day] => 5
                                    [sum] => 276.96
                                    [total_sum] => 306.96
                                    [services] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 2
                                                    [name] => Страхование
                                                    [sum] => 0
                                                    [rate] => 0.75
                                                )
        
                                            [1] => Array
                                                (
                                                    [id] => 19
                                                    [name] => Агентское вознаграждение
                                                    [sum] => 30
                                                    [rate] => 3
                                                )
        
                                        )
        
                                    [tariff_name] => Посылка онлайн
                                )
        
                            [4003] => Array
                                (
                                    [tariff_id] => 4003
                                    [min_day] => 2
                                    [max_day] => 4
                                    [sum] => 400.04
                                    [total_sum] => 430.04
                                    [services] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 2
                                                    [name] => Страхование
                                                    [sum] => 0
                                                    [rate] => 0.75
                                                )
        
                                            [1] => Array
                                                (
                                                    [id] => 19
                                                    [name] => Агентское вознаграждение
                                                    [sum] => 30
                                                    [rate] => 3
                                                )
        
                                        )
        
                                    [tariff_name] => Посылка 1 класс
                                )
        
                            [delivery_company_id] => 55
                            [delivery_company_name] => RussianPost
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```


<a name="delivery_list"><h1>Получение списка служб доставки</h1></a>

Для получения доступных служб доставки используйте метод **getDeliveryList**.

**Входные параметры:**
Отсутствуют

**Выходные параметры:**
- *array* - Список служб доставки

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getDeliveryList();
        
        /*
         Array
        (
            [request_id] => efd59d45-ada8-4884-977d-6a0e1eae85df
            [delivery_list] => Array
                (
                    [0] => Array
                        (
                            [id] => 1
                            [name] => Cdek
                        )
        
                    [1] => Array
                        (
                            [id] => 2
                            [name] => Boxberry
                        )
        
                    [2] => Array
                        (
                            [id] => 3
                            [name] => Cse
                        )
        
                    [3] => Array
                        (
                            [id] => 4
                            [name] => Iml
                        )
        
                    [4] => Array
                        (
                            [id] => 5
                            [name] => Dpd
                        )
        
                    [5] => Array
                        (
                            [id] => 7
                            [name] => DelLin
                        )
        
                    [6] => Array
                        (
                            [id] => 50
                            [name] => FSDelivery
                        )
        
                    [7] => Array
                        (
                            [id] => 51
                            [name] => FastDo
                        )
        
                    [8] => Array
                        (
                            [id] => 55
                            [name] => RussianPost
                        )
        
                    [9] => Array
                        (
                            [id] => 111
                            [name] => Pecom
                        )
        
                    [10] => Array
                        (
                            [id] => 112
                            [name] => ПЭК EasyWay
                        )
        
                    [11] => Array
                        (
                            [id] => 113
                            [name] => Ozon
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```

<a name="delivery_types"><h1>Получение списка режимов доставки</h1></a>

Для получения списка режимов доставки используйте метод **getDeliveryTypes**.

**Входные параметры:**
- int **$type_id** - ID режима доставки по базе FsDelivery (не обязательный параметр)

**Выходные параметры:**
- *array* - список режимов доставки

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getDeliveryTypes(4);

        /*
         Array
        (
            [request_id] => a3e7cca7-a3cf-4d7a-b15e-26fcd691d21f
            [types] => Array
                (
                    [0] => Array
                        (
                            [delivery_company_id] => 50
                            [delivery_company_name] => FSDelivery
                            [type_id] => 4
                            [name] => Дверь-Дверь
                        )
        
                    [1] => Array
                        (
                            [delivery_company_id] => 1
                            [delivery_company_name] => Cdek
                            [type_id] => 4
                            [name] => Дверь-Дверь
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```

<a name="delivery_tariffs"><h1>Получение списка тарифов</h1></a>

Для расчета стоимости доставки используйте метод **calculateTariff**.

**Входные параметры:**
int $delivery_id - ID службы доставки по базе FsDelivery (не обязательный параметр)
int $type_id - ID режима доставки по базе FsDelivery (не обязательный параметр)

**Выходные параметры:**
- *array* - список тарифов

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getDeliveryTariffs(2);

        /*
         Array
        (
            [request_id] => e4271d3c-dc32-4592-b8bc-7e32a7b57821
            [tariffs] => Array
                (
                    [0] => Array
                        (
                            [id] => 1001
                            [name] => Boxberry склад-склад
                            [delivery_company_id] => 2
                            [delivery_company_name] => Boxberry
                            [type_id] => 1
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```

<a name="delivery_order_statuses"><h1>Получение списка возможных статусов заказа</h1></a>

Для получения списка всех возможных статусов заказа используйте метод **getDeliveryStatuses**.

**Входные параметры:**
Отсутствуют

**Выходные параметры:**
- *array* - список статусов с разбивкой по службам доставки

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getDeliveryStatuses();

        /*
        Array
        (
            [request_id] => dab8e6cd-150d-402f-a85f-33d900d590bb
            [status_list] => Array
                (
                    [SystemStatus] => Array
                        (
                            [status_list] => Array
                                (
                                    [0] => Array
                                        (
                                            [code] => 0
                                            [status] => Оформлен
                                            [desc] => Заказ оформлен в нашей системе, но еще не интегрирован с курьерской службой. После интеграции заказа статус изменится на status_id = 5, “Подготовлен”
                                        )
        
                                    [1] => Array
                                        (
                                            [code] => 1
                                            [status] => Оплачен
                                            [desc] => Заказ оплачен и интегрирован с системой СДЭК, его можно отправлять.
                                        )
        
                                    [2] => Array
                                        (
                                            [code] => 2
                                            [status] => В работе
                                            [desc] => Заказ находится в пути, после получения клиентом мы вас уведомим и статус изменится
                                        )
        
                                    [3] => Array
                                        (
                                            [code] => 3
                                            [status] => Вручен
                                            [desc] => Заказ получен получателем
                                        )
        
                                    [4] => Array
                                        (
                                            [code] => 4
                                            [status] => Возврат
                                            [desc] => Покупатель отказался от заказа, будет сформирован возврат отправления.
                                        )
        
                                    [5] => Array
                                        (
                                            [code] => 5
                                            [status] => Подготовлен
                                            [desc] => Заказ подготовлен к отправке, накладная сдэк создана, груз можно отправить
                                        )
        
                                    [6] => Array
                                        (
                                            [code] => 6
                                            [status] => Ожидает оплату
                                            [desc] => Т.к. заказ с оплатой отправителем, его необходимо оплатить. На будущие заказы можно привязать карту для ускорения процесса оплаты или выбрать автоматичческое списание с карты.
                                        )
        
                                    [7] => Array
                                        (
                                            [code] => 7
                                            [satus] => Ошибка
                                            [desc] => Сервер курьерской службы не ответил. Накладная сгенерируется автоматически в ближайшее время.
                                        )
        
                                    [8] => Array
                                        (
                                            [code] => 8
                                            [status] => Оплачен с баланса
                                            [desc] => Заказ оплачен с текущего баланса
                                        )
        
                                    [9] => Array
                                        (
                                            [code] => 9
                                            [status] => Отменен
                                            [desc] => Заказ отменен
                                        )
        
                                    [10] => Array
                                        (
                                            [code] => 10
                                            [status] => Готов к доставке
                                            [desc] => Заказ прибыл в город получателя и готов к доставке. Ожидается выдача курьеру.
                                        )
        
                                    [11] => Array
                                        (
                                            [code] => 11
                                            [status] => Готов к выдаче
                                            [desc] => Заказ прибыл в пункт выдачи и готов к выдаче.
                                        )
        
                                    [12] => Array
                                        (
                                            [code] => 12
                                            [status] => Принят КС
                                            [desc] => Заказ принят курьерской службой для дальнейшей транспортировки
                                        )
        
                                    [13] => Array
                                        (
                                            [code] => 13
                                            [status] => Задержка
                                            [desc] => Плановый срок доставки в рабочих днях вышел, но заказ еще не прибыл в пункт назначения
                                        )
        
                                    [14] => Array
                                        (
                                            [code] => 14
                                            [status] => У курьера
                                            [desc] => Заказ находится на доставке у курьера
                                        )
        
                                )
        
                        )
        
                    [1] => Array
                        (
                            [delivery_company_id] => 1
                            [delivery_company_name] => CDEK
                            [status_list] => Array
                                (
                                    [0] => Array
                                        (
                                            [code] => 0
                                            [status] => Неизвестный статус
                                            [desc] => 
                                        )
        
                                    [1] => Array
                                        (
                                            [code] => 1
                                            [status] => Создан
                                            [desc] => 
                                        )
        
                                    [2] => Array
                                        (
                                            [code] => 2
                                            [status] => Удален
                                            [desc] => 
                                        )
        
                                    [3] => Array
                                        (
                                            [code] => 3
                                            [status] => Принят на склад отправителя
                                            [desc] => 
                                        )
        
                                    [6] => Array
                                        (
                                            [code] => 6
                                            [status] => Выдан на отправку в г. отправителе
                                            [desc] => 
                                        )
        
                                    [16] => Array
                                        (
                                            [code] => 16
                                            [status] => Возвращен на склад отправителя
                                            [desc] => 
                                        )
        
                                    [7] => Array
                                        (
                                            [code] => 7
                                            [status] => Сдан перевозчику в г. отправителе
                                            [desc] => 
                                        )
        
                                    [21] => Array
                                        (
                                            [code] => 21
                                            [status] => Отправлен в г. транзит
                                            [desc] => 
                                        )
        
                                    [27] => Array
                                        (
                                            [code] => 27
                                            [status] => Отправлен в г. отправитель
                                            [desc] => 
                                        )
        
                                    [28] => Array
                                        (
                                            [code] => 28
                                            [status] => Встречен в г. отправителе
                                            [desc] => 
                                        )
        
                                    [22] => Array
                                        (
                                            [code] => 22
                                            [status] => Встречен в г. транзите
                                            [desc] => 
                                        )
        
                                    [13] => Array
                                        (
                                            [code] => 13
                                            [status] => Принят на склад транзита
                                            [desc] => 
                                        )
        
                                    [19] => Array
                                        (
                                            [code] => 19
                                            [status] => Выдан на отправку в г. транзите
                                            [desc] => 
                                        )
        
                                    [17] => Array
                                        (
                                            [code] => 17
                                            [status] => Возвращен на склад транзита
                                            [desc] => 
                                        )
        
                                    [20] => Array
                                        (
                                            [code] => 20
                                            [status] => Сдан перевозчику в г. транзите
                                            [desc] => 
                                        )
        
                                    [8] => Array
                                        (
                                            [code] => 8
                                            [status] => Отправлен в г. получатель
                                            [desc] => 
                                        )
        
                                    [9] => Array
                                        (
                                            [code] => 9
                                            [status] => Встречен в г. получателе
                                            [desc] => 
                                        )
        
                                    [10] => Array
                                        (
                                            [code] => 10
                                            [status] => Принят на склад доставки
                                            [desc] => 
                                        )
        
                                    [12] => Array
                                        (
                                            [code] => 12
                                            [status] => Принят на склад до востребования
                                            [desc] => 
                                        )
        
                                    [11] => Array
                                        (
                                            [code] => 11
                                            [status] => Выдан на доставку
                                            [desc] => 
                                        )
        
                                    [18] => Array
                                        (
                                            [code] => 18
                                            [status] => Возвращен на склад доставки
                                            [desc] => 
                                        )
        
                                    [4] => Array
                                        (
                                            [code] => 4
                                            [status] => Вручен
                                            [desc] => 
                                        )
        
                                    [5] => Array
                                        (
                                            [code] => 5
                                            [status] => Не вручен
                                            [desc] => 
                                        )
        
                                )
        
                            [dop_status_list] => Array
                                (
                                    [0] => Array
                                        (
                                            [code] => 0
                                            [status] => Неизвестный статус
                                        )
        
                                    [1] => Array
                                        (
                                            [code] => 1
                                            [status] => Возврат, неверный адрес
                                        )
        
                                    [2] => Array
                                        (
                                            [code] => 2
                                            [status] => Возврат, не дозвонились
                                        )
        
                                    [3] => Array
                                        (
                                            [code] => 3
                                            [status] => Возврат, адресат не проживает
                                        )
        
                                    [4] => Array
                                        (
                                            [code] => 4
                                            [status] => Возврат, не должен выполняться: вес отличается от заявленного более, чем на X г.
                                        )
        
                                    [5] => Array
                                        (
                                            [code] => 5
                                            [status] => Возврат, не должен выполняться: фактически нет отправления (на бумаге есть)
                                        )
        
                                    [6] => Array
                                        (
                                            [code] => 6
                                            [status] => Возврат, не должен выполняться: дубль номера заказа в одном акте приема-передачи
                                        )
        
                                    [7] => Array
                                        (
                                            [code] => 7
                                            [status] => Возврат, не должен выполняться: не доставляем в данный город/регион
                                        )
        
                                    [8] => Array
                                        (
                                            [code] => 8
                                            [status] => Возврат, повреждение упаковки, при приемке от отправителя
                                        )
        
                                    [9] => Array
                                        (
                                            [code] => 9
                                            [status] => Возврат, повреждение упаковки, у перевозчика
                                        )
        
                                    [10] => Array
                                        (
                                            [code] => 10
                                            [status] => Возврат, повреждение упаковки, на нашем складе/доставке у курьера
                                        )
        
                                    [11] => Array
                                        (
                                            [code] => 11
                                            [status] => Возврат, отказ от получения: Без объяснения
                                        )
        
                                    [12] => Array
                                        (
                                            [code] => 12
                                            [status] => Возврат, отказ от получения: Претензия к качеству товара
                                        )
        
                                    [13] => Array
                                        (
                                            [code] => 13
                                            [status] => Возврат, отказ от получения: Недовложение
                                        )
        
                                    [14] => Array
                                        (
                                            [code] => 14
                                            [status] => Возврат, отказ от получения: Пересорт
                                        )
        
                                    [15] => Array
                                        (
                                            [code] => 15
                                            [status] => Возврат, отказ от получения: Не устроили сроки
                                        )
        
                                    [16] => Array
                                        (
                                            [code] => 16
                                            [status] => Возврат, отказ от получения: Уже купил
                                        )
        
                                    [17] => Array
                                        (
                                            [code] => 17
                                            [status] => Возврат, отказ от получения: Передумал
                                        )
        
                                    [18] => Array
                                        (
                                            [code] => 18
                                            [status] => Возврат, отказ от получения: Ошибка оформления
                                        )
        
                                    [19] => Array
                                        (
                                            [code] => 19
                                            [status] => Возврат, отказ от получения: Повреждение упаковки, у получателя
                                        )
        
                                    [20] => Array
                                        (
                                            [code] => 20
                                            [satus] => Частичная доставка
                                        )
        
                                    [21] => Array
                                        (
                                            [code] => 21
                                            [status] => Возврат, отказ от получения: Нет денег
                                        )
        
                                    [22] => Array
                                        (
                                            [code] => 22
                                            [status] => Возврат, отказ от получения: Товар не подошел/не понравился
                                        )
        
                                    [23] => Array
                                        (
                                            [code] => 23
                                            [status] => Возврат, истек срок хранения
                                        )
        
                                    [24] => Array
                                        (
                                            [code] => 24
                                            [status] => Возврат, не прошел таможню
                                        )
        
                                    [25] => Array
                                        (
                                            [code] => 25
                                            [status] => Возврат, не должен выполняться: является коммерческим грузом
                                        )
        
                                    [26] => Array
                                        (
                                            [code] => 26
                                            [status] => Утерян
                                        )
        
                                    [27] => Array
                                        (
                                            [code] => 27
                                            [status] => Не востребован, утилизация
                                        )
        
                                )
        
                        )
        
                    [2] => Array
                        (
                            [delivery_company_id] => 2
                            [delivery_company_name] => BoxBerry
                            [status_list] => Array
                                (
                                    [0] => Array
                                        (
                                            [code] => 0
                                            [status] => Загружен реестр ИМ
                                            [desc] => Заказ загружен в ИС Боксберри (сформирован акт boxberry для отправки посылки)
                                        )
        
                                    [1] => Array
                                        (
                                            [code] => 1
                                            [status] => Принято к доставке
                                            [desc] => Груз промаркирован и принят на складе Боксберри.
                                        )
        
                                    [2] => Array
                                        (
                                            [code] => 2
                                            [status] => Передано на сортировку
                                            [desc] => Заказ готовится к отправке в город назначения.
                                        )
        
                                    [3] => Array
                                        (
                                            [code] => 3
                                            [status] => Отправлен на сортировочный терминал
                                            [desc] => В пути на терминал.
                                        )
        
                                    [6] => Array
                                        (
                                            [code] => 6
                                            [status] => Отправлено в город назначения
                                            [desc] => Груз фактически отправлен в город назначения.
                                        )
        
                                    [16] => Array
                                        (
                                            [code] => 16
                                            [status] => Передан на доставку до пункта выдачи
                                            [desc] => Отправлен в пункт выдачи.
                                        )
        
                                    [7] => Array
                                        (
                                            [code] => 7
                                            [status] => Передано на курьерскую доставку
                                            [desc] => Заказ прибыл в город назначения, с получателем согласовано время доставки. Заказ передан курьеру
                                        )
        
                                    [21] => Array
                                        (
                                            [code] => 21
                                            [status] => Поступило в пункт выдачи
                                            [desc] => Заказ поступил в пункт выдачи. Готов к получению.
                                        )
        
                                    [22] => Array
                                        (
                                            [code] => 22
                                            [status] => Выдано
                                            [desc] => Заказ выдан получателю.
                                        )
        
                                    [13] => Array
                                        (
                                            [code] => 13
                                            [status] => Возвращено с курьерской доставки
                                            [desc] => Заказ возвращен с курьерской доставки
                                        )
        
                                    [19] => Array
                                        (
                                            [code] => 19
                                            [status] => Готовится к возврату
                                            [desc] => Заказ готовится на возврат, но по факту находятся в пункте выдачи.
                                        )
        
                                    [17] => Array
                                        (
                                            [code] => 17
                                            [status] => Отправлено в пункт приема
                                            [desc] => Заказ отправлен на возврат.
                                        )
        
                                    [20] => Array
                                        (
                                            [code] => 20
                                            [status] => Возвращено в пункт приема
                                            [desc] => Заказ поступил на склад возвратов Боксберри.
                                        )
        
                                    [8] => Array
                                        (
                                            [code] => 8
                                            [status] => Возвращено в ИМ
                                            [desc] => Заказ отправлен в интернет-магазин
                                        )
        
                                )
        
                        )
        
                    [51] => Array
                        (
                            [delivery_company_id] => 51
                            [delivery_company_name] => FastDo
                            [status_list] => Array
                                (
                                    [0] => Array
                                        (
                                            [code] => 0
                                            [status] => Неизвестный статус
                                            [desc] => Неизвестный статус
                                        )
        
                                    [1] => Array
                                        (
                                            [code] => 1
                                            [status] => WORK
                                            [desc] => В работе
                                        )
        
                                    [2] => Array
                                        (
                                            [code] => 2
                                            [status] => NOW
                                            [desc] => Созданный заказ, ожидает одобрения оператора
                                        )
        
                                    [3] => Array
                                        (
                                            [code] => 3
                                            [status] => EXECUTING
                                            [desc] => Заказ выполнен
                                        )
        
                                    [4] => Array
                                        (
                                            [code] => 4
                                            [status] => CANCELED
                                            [desc] => Заказ отменен
                                        )
        
                                    [5] => Array
                                        (
                                            [code] => 5
                                            [status] => 3
                                            [desc] => Заказ одобрен оператором и доступен курьерам
                                        )
        
                                )
        
                        )
        
                    [111] => Array
                        (
                            [delivery_company_id] => 111
                            [delivery_company_name] => Pecom
                            [status_list] => Array
                                (
                                    [0] => Array
                                        (
                                            [code] => 0
                                            [status] => Неизвестный статус
                                            [desc] => Неизвестный статус
                                        )
        
                                    [1] => Array
                                        (
                                            [code] => 1
                                            [status] => Принят
                                            [desc] => Принят для перевозки
                                        )
        
                                    [2] => Array
                                        (
                                            [code] => 2
                                            [status] => Возвращен отправителю
                                            [desc] => Возвращен отправителю
                                        )
        
                                    [3] => Array
                                        (
                                            [code] => 3
                                            [status] => Оформлен
                                            [desc] => Оформлен
                                        )
        
                                    [4] => Array
                                        (
                                            [code] => 4
                                            [status] => В пути
                                            [desc] => В пути
                                        )
        
                                    [5] => Array
                                        (
                                            [code] => 5
                                            [status] => Прибыл
                                            [desc] => Прибыл
                                        )
        
                                    [6] => Array
                                        (
                                            [code] => 6
                                            [status] => Готов к выдаче
                                            [desc] => Готов к выдаче
                                        )
        
                                    [7] => Array
                                        (
                                            [code] => 7
                                            [status] => Выдан на доставку
                                            [desc] => Выдан на доставку
                                        )
        
                                    [8] => Array
                                        (
                                            [code] => 8
                                            [status] => Выдан на складе
                                            [desc] => Выдан на складе
                                        )
        
                                    [9] => Array
                                        (
                                            [code] => 9
                                            [status] => Доставлен
                                            [desc] => Доставлен
                                        )
        
                                    [10] => Array
                                        (
                                            [code] => 10
                                            [status] => Выдан на складе
                                            [desc] => Выдан на складе
                                        )
        
                                    [11] => Array
                                        (
                                            [code] => 11
                                            [status] => Утилизирован
                                            [desc] => Утилизирован
                                        )
        
                                    [12] => Array
                                        (
                                            [code] => 12
                                            [status] => Выдан частично
                                            [desc] => Выдан ( мест { количество_мест } из { количество_мест } )
                                        )
        
                                )
        
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```

<a name="countries"><h1>Получение списка стран</h1></a>

Для получение списка стран используйте метод **getReferenceCountries**.

**Входные параметры:**
- int **$country_id** - ID страны по базе FsDelivery
- string **$country_code** - Код страны (ISO 3166-1 2 буквы)
- string **$country_name** - Точное название страны (например Россия), поиск без учета регистра

**Выходные параметры:**
- *array* - список стран

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getReferenceCountries(null, 'RU');
        
        /*
        Array
        (
            [request_id] => 3af5a29f-b2a5-4f24-8d51-61db501fb7b2
            [country_list] => Array
                (
                    [0] => Array
                        (
                            [id] => 1
                            [name] => Россия
                            [name_eng] => Russia
                            [code] => RU
                        )
        
                )
        )
        */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```


<a name="cities"><h1>Получение списка городов</h1></a>

Для получение списка городов используйте метод **getReferenceCities**.

**Входные параметры:**
- CitiesFilter **$searchFilter** - объект-фильтр
- int **$page_number** - Номер страницы для выборки
- int **$page_size** - Количество результатов на странице

**Выходные параметры:**
- *array* - список городов

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $citiesFilter = new \FsDeliverySdk\ValueObject\CitiesFilter();
        $citiesFilter->setKladrId('0100400000200');
        $result = $client->getReferenceCities($citiesFilter);
        
        /*
        Array
        (
            [request_id] => 1a100d01-0535-409c-a9ec-ea553ae01695
            [city_list] => Array
                (
                    [0] => Array
                        (
                            [id] => 16418
                            [kladr_id] => 0100400000200
                            [fias_id] => a11b882d-79ab-4087-9d2d-8effea6d066c
                            [postal_code] => 
                            [name] => Абадзехская, Адыгея респ.
                            [name_only] => Абадзехская
                            [fullname] => 
                            [name_eng] => 
                            [region] => Адыгея респ.
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2021-03-21
                        )
        
                )
        
            [page_number] => 1
            [page_size] => 100
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```


<a name="cities_autocomplete"><h1>Получение списка городов для AUTOCOMPLETE</h1></a>

Для получение списка городов для AUTOCOMPLETE используйте метод **getReferenceCitiesAutocomplete**.

**Входные параметры:**
- string **$char_city_name** - Строка поиска по названию города (от двух символов)
- int|null **$fsdelivery_country_id** - ID страны по базе FSDelivery

**Выходные параметры:**
- *array* - список городов

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getReferenceCitiesAutocomplete('Москва');
        
        /*
        Array
        (
            [request_id] => fdf18084-7af1-46ed-8e6e-88c1e5c5b9d8
            [city_list] => Array
                (
                    [0] => Array
                        (
                            [id] => 44
                            [kladr_id] => 7700000000000
                            [fias_id] => 0c5b2444-70a0-4932-980c-b4dc0d3f02b5
                            [postal_code] => 
                            [name] => Россия
                            [name_only] => Москва
                            [fullname] => МОСКВА
                            [name_eng] => Russia
                            [region] => Москва
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2021-03-21
                        )
        
                    [1] => Array
                        (
                            [id] => 1198
                            [kladr_id] => 7701200000100
                            [fias_id] => 00c00b6c-9517-4dfe-b97b-4e10b49acd8a
                            [postal_code] => 
                            [name] => Россия
                            [name_only] => Мосрентген, Москва
                            [fullname] => МОСРЕНТГЕН, МОСКОВСКАЯ ОБЛАСТЬ
                            [name_eng] => Russia
                            [region] => Московская обл.
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2021-03-21
                        )
        
                    [2] => Array
                        (
                            [id] => 2789
                            [kladr_id] => 7700000002500
                            [fias_id] => 25c2e4f1-5d65-4d59-8124-e45a649ef7d6
                            [postal_code] => 
                            [name] => Россия
                            [name_only] => Рублево, Москва
                            [fullname] => РУБЛЕВО, МОСКВА
                            [name_eng] => Russia
                            [region] => Москва
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2020-06-06
                        )
        
                    [3] => Array
                        (
                            [id] => 14299
                            [kladr_id] => 2502500002200
                            [fias_id] => 3a8f0394-8688-42f8-b770-ec8d079b6895
                            [postal_code] => 
                            [name] => Россия
                            [name_only] => Новая Москва
                            [fullname] => 
                            [name_eng] => Russia
                            [region] => Приморский край
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2020-06-06
                        )
        
                    [4] => Array
                        (
                            [id] => 15556
                            [kladr_id] => 7701400001900
                            [fias_id] => 77014000019000000000000
                            [postal_code] => 108807
                            [name] => Россия
                            [name_only] => Птичное, Москва
                            [fullname] => 
                            [name_eng] => Russia
                            [region] => Московская обл.
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2020-03-10
                        )
        
                    [5] => Array
                        (
                            [id] => 15881
                            [kladr_id] => 7700000043000
                            [fias_id] => db22b565-f8ab-464b-b76f-1106629e9e95
                            [postal_code] => 
                            [name] => Россия
                            [name_only] => Сколково инновационный центр, Москва
                            [fullname] => 
                            [name_eng] => Russia
                            [region] => Москва
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2020-06-06
                        )
        
                    [6] => Array
                        (
                            [id] => 16239
                            [kladr_id] => 7701100000400
                            [fias_id] => 3ab4bca1-7730-4997-9732-a6b753707dc3
                            [postal_code] => 
                            [name] => Россия
                            [name_only] => Ульяновского лесопарка пос., Москва
                            [fullname] => 
                            [name_eng] => Russia
                            [region] => Москва
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2020-03-10
                        )
        
                    [7] => Array
                        (
                            [id] => 42724
                            [kladr_id] => 7701900001800
                            [fias_id] => e307c4df-03bc-453f-b0c0-fe861eaabc1b
                            [postal_code] => 
                            [name] => Россия
                            [name_only] => Спортбазы посёлок, Москва
                            [fullname] => 
                            [name_eng] => Russia
                            [region] => Московская обл.
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2020-06-06
                        )
        
                    [8] => Array
                        (
                            [id] => 48335
                            [kladr_id] => 77000000000420900
                            [fias_id] => 77000000000000042090000
                            [postal_code] => 127495
                            [name] => Россия
                            [name_only] => Северный (Москва)
                            [fullname] => Северный
                            [name_eng] => Russia
                            [region] => Московская обл.
                            [country_iso] => RU
                            [country_id] => 1
                            [country_name] => Россия
                            [country_name_eng] => Russia
                            [last_date_update] => 2020-06-06
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```

<a name="delivery_points"><h1>Получение списка пунктов выдачи заказов (ПВЗ)</h1></a>

Для получение списка пунктов выдачи заказов (ПВЗ) используйте метод **getDeliveryPoints**.

**Входные параметры:**
- PvzFilter $pvzFilter - объект-фильтр

**Выходные параметры:**
- *array* - список ПВЗ

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $pvzFilter = new \FsDeliverySdk\ValueObject\PvzFilter();
        $pvzFilter->setFsdeliveryCityId(366);
        $pvzFilter->setDeliveryCompanyId(2);
        $result = $client->getDeliveryPoints((new \FsDeliverySdk\ValueObject\PvzFilter())->setFsdeliveryCityId(366)->setDeliveryCompanyId(2));
    
        /*
        Array
        (
            [request_id] => cff96546-ad13-4123-ae1b-aa91ed8031ba
            [points] => Array
                (
                    [2] => Array
                        (
                            [0] => Array
                                (
                                    [delivery_company_id] => 2
                                    [delivery_company_name] => Boxberry
                                    [coord_x] => 39.737066
                                    [coord_y] => 52.040505
                                    [country_id] => 1
                                    [city_id] => 366
                                    [city_name] => Усмань
                                    [city_kladr] => 4801600100000
                                    [city_fias] => 1b3ce1ae-6edd-464b-ab82-79237510cd5c
                                    [postal_code] => 
                                    [address] => Ленина ул, д.12
                                    [address_comment] => Остановка - Аграрный колледж.
        Примерное расстояние от остановки до Отделения - 300 м.
        2-этажный нежилой дом.
        1 этаж.
        Вход в улицы, единственная дверь с левого края здания.
        Офис "Изготовление печатей".
        
        
                                    [schedule] => [{"day":1,"periods":"10:00\/19:00","lunch":"\/"},{"day":2,"periods":"10:00\/19:00","lunch":"\/"},{"day":3,"periods":"10:00\/19:00","lunch":"\/"},{"day":4,"periods":"10:00\/19:00","lunch":"\/"},{"day":5,"periods":"10:00\/19:00","lunch":"\/"},{"day":6,"periods":"10:00\/16:00","lunch":"\/"},{"day":7,"periods":"\/","lunch":"\/"}]
                                    [metro] => 
                                    [is_cash] => 1
                                    [phone] => 8-800-222-80-00
                                )
        
                            [1] => Array
                                (
                                    [delivery_company_id] => 2
                                    [delivery_company_name] => Boxberry
                                    [coord_x] => 39.729332
                                    [coord_y] => 52.062841
                                    [country_id] => 1
                                    [city_id] => 366
                                    [city_name] => Усмань
                                    [city_kladr] => 4801600100000
                                    [city_fias] => 1b3ce1ae-6edd-464b-ab82-79237510cd5c
                                    [postal_code] => 
                                    [address] => Ленина ул, д.148
                                    [address_comment] => Остановка  -  "школа №3".
        Примерное расстояние от остановки до Отделения  -  20м.       Нежилое здание.
        Центральный вход.
        Этаж 1.
        Ремонт компьютерной техники.
                                    [schedule] => [{"day":1,"periods":"09:00\/20:00","lunch":"\/"},{"day":2,"periods":"09:00\/20:00","lunch":"\/"},{"day":3,"periods":"09:00\/20:00","lunch":"\/"},{"day":4,"periods":"09:00\/20:00","lunch":"\/"},{"day":5,"periods":"09:00\/20:00","lunch":"\/"},{"day":6,"periods":"09:00\/20:00","lunch":"\/"},{"day":7,"periods":"09:00\/20:00","lunch":"\/"}]
                                    [metro] => 
                                    [is_cash] => 1
                                    [phone] => 8-800-222-80-00
                                )
        
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```


<a name="reestr_waybills"><h1>ДЕТАЛИЗАЦИЯ ПО РЕЕСТРУ НП</h1></a>

Для получения детализации по реестру НП используйте метод **getReestrWaybills**.

**Входные параметры:**
- int **$reestr_number** - Номер реестра наложенного платежа (поле number из метода /1.0/reestr/list)

**Выходные параметры:**
- *array* - список данных

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getReestrWaybills(1);
        
        /*
        Array
        (
            [request_id] => fe2e0236-fc32-4ce1-95aa-c15e9d286d1d
            [waybills] => Array
                (
                    [146] => Array
                        (
                            [0] => Array
                                (
                                    [delivery_company_id] => 1
                                    [order_num] => 
                                    [dispacher_number] => 1152922965
                                    [dispacher_date] => 2019-12-13 12:44:17
                                    [delivery_date] => 2019-12-18 18:43:00
                                    [delivery_sum] => 990.75
                                    [agent_sum] => 3.00
                                    [np] => 22000.00
                                    [reciver_city_name] => 
                                    [reciver_name] => 
                                    [date_add] => 
                                )
        
                            [1] => Array
                                (
                                    [delivery_company_id] => 1
                                    [order_num] => 
                                    [dispacher_number] => 1164621325
                                    [dispacher_date] => 2020-02-27 11:34:30
                                    [delivery_date] => 2020-03-23 15:18:00
                                    [delivery_sum] => 231.75
                                    [agent_sum] => 3.00
                                    [np] => 2503.00
                                    [reciver_city_name] => 
                                    [reciver_name] => 
                                    [date_add] => 
                                )
        
                            [2] => Array
                                (
                                    [delivery_company_id] => 1
                                    [order_num] => 
                                    [dispacher_number] => 1168097080
                                    [dispacher_date] => 2020-03-19 05:06:45
                                    [delivery_date] => 2020-03-24 14:06:00
                                    [delivery_sum] => 451.75
                                    [agent_sum] => 3.00
                                    [np] => 400.00
                                    [reciver_city_name] => 
                                    [reciver_name] => 
                                    [date_add] => 
                                )
        
                        )
        
                )
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```


<a name="reestr_statuses"><h1>Возможные статусы реестров НП</h1></a>

Для получения возможных статусов реестров НП используйте метод **getReestrStatuses**.

**Входные параметры:**
Отсутствуют

**Выходные параметры:**
- *array* - список статусов

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getReestrStatuses();
        
        /*
        Array
        (
            [request_id] => 93b4a90f-24b4-4ab1-892c-208aef3cb18f
            [status_list] => Array
                (
                    [0] => Array
                        (
                            [name] => Готовится
                            [id] => 0
                        )
        
                    [1] => Array
                        (
                            [name] => К оплате
                            [id] => 1
                        )
        
                    [2] => Array
                        (
                            [name] => В графике
                            [id] => 2
                        )
        
                    [3] => Array
                        (
                            [name] => Оплачен
                            [id] => 3
                        )
        
                    [4] => Array
                        (
                            [name] => Удален
                            [id] => 4
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```


<a name="reestr_list"><h1>Список реестров НП</h1></a>

Для получения списка реестров НП используйте метод **getReestrList**.

**Входные параметры:**
- ReestrFilter **$reestrFilter** - объект-фильтр

**Выходные параметры:**
- *array* - список реестров

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getReestrList((new \FsDeliverySdk\ValueObject\ReestrFilter())->setCreatedDate('2020-03-29'));
        
        /*
        Array
        (
            [request_id] => 229923ec-d989-4237-a94c-0d8f0cd68a0a
            [reestr_list] => Array
                (
                    [0] => Array
                        (
                            [number] => 1
                            [status_id] => 3
                            [status_name] => Оплачен
                            [order_count] => 0
                            [sum_for_payment] => 22481.66
                            [payment_plan_date] => 0000-00-00
                            [payment_date] => 2020-05-06 00:00:00
                            [bank_pp] => 1
                            [deilvery_sum] => 0.00
                            [agent_sum] => 0.00
                            [np] => 24903.00
                            [history] => Array
                                (
                                    [0] => Array
                                        (
                                            [id] => 247
                                            [reestr_id] => 146
                                            [status_id] => 0
                                            [change_date] => 2020-01-19 23:33:18
                                            [user_id] => 0
                                            [status_name] => Готовится
                                        )
        
                                    [1] => Array
                                        (
                                            [id] => 250
                                            [reestr_id] => 146
                                            [status_id] => 1
                                            [change_date] => 2020-01-22 00:00:02
                                            [user_id] => 0
                                            [status_name] => К оплате
                                        )
        
                                    [2] => Array
                                        (
                                            [id] => 303
                                            [reestr_id] => 146
                                            [status_id] => 2
                                            [change_date] => 2020-03-02 11:25:21
                                            [user_id] => 0
                                            [status_name] => В графике
                                        )
        
                                    [3] => Array
                                        (
                                            [id] => 332
                                            [reestr_id] => 146
                                            [status_id] => 0
                                            [change_date] => 2020-03-21 22:59:21
                                            [user_id] => 0
                                            [status_name] => Готовится
                                        )
        
                                    [4] => Array
                                        (
                                            [id] => 346
                                            [reestr_id] => 146
                                            [status_id] => 1
                                            [change_date] => 2020-03-29 00:00:02
                                            [user_id] => 0
                                            [status_name] => К оплате
                                        )
        
                                    [5] => Array
                                        (
                                            [id] => 411
                                            [reestr_id] => 146
                                            [status_id] => 3
                                            [change_date] => 2020-05-06 11:02:07
                                            [user_id] => 0
                                            [status_name] => Оплачен
                                        )
        
                                )
        
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```

<a name="userinfo"><h1>Получение информации о пользователе</h1></a>

Для получение информации о пользователе используйте метод **getUserInfo**.

**Входные параметры:**
Отсутствуют

**Выходные параметры:**
- *array* - информация о пользователе

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getUserInfo();
        
        /*
        Array
        (
            [request_id] => 1a461bb4-a99c-4840-b828-e30cce13cad3
            [username] => Иван Иванов
            [phone] => +79991234567
            [link] => OriginalDvr
            [email] => info@test.ru
            [dogovor] => 1
            [city_name] => Москва
            [city_id] => 44
            [shop_name] => -
            [balance] => -565971
            [real_balance] => -552754
            [cdek_on] => 1
            [boxberry_on] => 1
            [cse_on] => 
            [iml_on] => 
            [dellin_on] => 
            [ruspost_on] => 1
            [fastdo_on] => 
            [fsdelivery_on] => 1
            [inn] => 1234567890
            [kpp] => 1
            [ogrn] => 321874201211313
            [okved] => 53.20.3
            [status_company_ur] => Юр. лицо действующее
            [reg_data] => Array
                (
                    [date] => 1970-01-01 00:00:00.000000
                    [timezone_type] => 3
                    [timezone] => UTC
                )
        
            [ur_adress] => 
            [director_name] => Иванов Иван Иванович
            [director_post_name] => Индивидуальный предприниматель
            [bank_name] => 1
            [bik] => 2
            [correspondent_account] => 4
            [checking_account] => 3
            [opf] => ИП
            [name_ooo] => Иванов Иван Иванович
            [agent_sum] => 3
            [signature_basis] => 
            [signature_basis_date] => 
            [signature_basis_serial] => 
            [signature_basis_number] => 
            [settings] => Array
                (
                    [default_item_name] => Заказ 2
                    [default_sender_phone] => 88000000000
                    [default_sender_street] => Тихомирова
                    [default_sender_email] => 11@11
                    [default_sender_shop_name] => -
                    [default_sender_name] => Интернет-магазин
                    [default_sender_comment] => 
                    [default_sender_city_id] => 44
                    [default_sender_city] => Москва
                    [default_insecury] => 
                    [default_insecury_sum] => 1
                    [default_sender_house] => 7
                    [default_sender_flat] => 55
                    [send_to_email_create] => 
                    [send_to_email_work] => 
                    [send_to_email_dd] => 
                    [send_to_pdf_work] => 
                    [send_to_pdf_create] => 
                    [more_paymenter] => 
                    [copy_count] => 1
                    [boxberry_pvz_sender_id] => 
                    [boxberry_pvz_sender_name] => 
                    [OrderNum] => 1
                    [from_door] => 
                )
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```


<a name="order_statuses"><h1>Получение статусов заказа</h1></a>

Для получение статусов заказа используйте метод **$orderStatusFilter**.

**Входные параметры:**
- OrderStatusFilter **$orderStatusFilter** - объект-фильтр

**Выходные параметры:**
- *array* - список статусов

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getOrderStatuses((new \FsDeliverySdk\ValueObject\OrderFilter())->setOrderId(358)); // последний статус
        $result = $client->getOrderStatuses((new \FsDeliverySdk\ValueObject\OrderFilter())->setOrderId([358, 382])->setShowHistory(1)); // с историей статусов
        /*
        Array
        (
            [request_id] => cb1dbcb7-eb7d-46d3-9f80-0c60c9ae27cc
            [orders] => Array
                (
                    [0] => Array
                        (
                            [order_id] => 358
                            [order_number] => 
                            [order_dispacher_number] => 1108697266
                            [order_delivery_copmany_id] => 1
                            [order_delivery_copmany_name] => Cdek
                            [city_name] => Москва
                            [delivery_status_id] => 4
                            [delivery_status_date] => 2019-02-07 18:12:24
                            [delivery_status_name] => Вручен
                            [delivery_status_description] => 
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```


<a name="orders_info"><h1>Получение информации по заказам</h1></a>

Для получение информации по заказам используйте метод ****.

**Входные параметры:**
- OrderFilter **$orderFilter** - объект-фильтр

**Выходные параметры:**
- *array* - список заказов

**Примеры вызова:**
```php
<?php
    try {
        $client = new \FsDeliverySdk\Client('api-token');
        $client->setLogger($log);
        $result = $client->getOrders((new \FsDeliverySdk\ValueObject\OrderFilter())->setOrderId([358, 382])); // Получение по ID заказов
        $result = $client->getOrders((new \FsDeliverySdk\ValueObject\OrderFilter())->setCreateDateBegin('2019-02-06')->setCreateDateEnd('2019-02-06')); // Получение по периоду дат
        
        /*
        Array
        (
            [request_id] => fcd13111-602d-436e-a953-d467dc0b463d
            [orders] => Array
                (
                    [0] => Array
                        (
                            [order_id] => 358
                            [order_number] => 
                            [order_dispacher_number] => 1108697266
                            [external_dispacher_number] => 
                            [creation_time] => 2019-02-06 17:12:21
                            [dispacher_date] => 2019-02-06 05:12:35
                            [type_id] => 2
                            [service_id] => 1
                            [last_status_id] => 3
                            [last_status_delivery_company_id] => 4
                            [last_status_delivery_company_date] => 2019-02-07 18:12:24
                            [last_status_delivery_company_city_name] => Москва
                            [dop_last_status_id] => 
                            [item_count] => 1
                            [tariff_id] => 11
                            [tariff_name] => Экспресс лайт склад-дверь
                            [sender_city_id] => 44
                            [sender_city_name] => Москва
                            [sender_flat] => 
                            [sender_house] => 
                            [sender_comment] => 
                            [sender_opf] => 
                            [sender_inn] => 
                            [sender_passport_seria] => 
                            [sender_passport_nomer] => 
                            [reciver_country_id] => 0
                            [reciver_city_id] => 44
                            [reciver_city_name] => Москва
                            [reciver_email] => 
                            [pvz_id] => 
                            [pvz_name] => 
                            [reciver_name] => Стратегия
                            [reciver_phone] => 89991234567
                            [reciver_phone2] => 
                            [reciver_phone3] => 
                            [reciver_street] => Жуковского
                            [reciver_home] => 5
                            [reciver_ofice] => 14
                            [reciver_comment] => Расходники, можно выдать без паспорта и доверенности любому получателю
                            [reciver_opf] => 
                            [reciver_inn] => 
                            [reciver_passport_seria] => 
                            [reciver_passport_nomer] => 
                            [shop_name] => -
                            [total_sum] => 0.00
                            [courier_number] => 
                            [delivery_recipient_payment] => 0.00
                            [delivery_recipient_payment_fact] => 0.00
                            [total_recipient_payment] => 0.00
                            [total_recipient_payment_fact] => 0.00
                            [min_period] => 
                            [max_period] => 
                            [is_return] => 0
                            [returned_dispacher_number] => 0
                            [np_pereveden] => 0
                            [max_date_storage] => 
                            [act_number] => 2
                            [reestr_user_number] => 
                            [reestr_in_order_date] => 
                            [courier_delivered_phone_name] => 
                            [fsdelivery_courier] => 0
                            [deadline_delivery_date] => 
                            [prices] => Array
                                (
                                    [0] => Array
                                        (
                                            [cost] => 220
                                            [type_id] => 1
                                        )
        
                                    [1] => Array
                                        (
                                            [cost] => 0.75
                                            [type_id] => 2
                                        )
        
                                )
        
                            [items] => Array
                                (
                                    [0] => Array
                                        (
                                            [weight] => 0.5
                                            [height] => 0
                                            [width] => 0
                                            [length] => 0
                                            [total] => 0.00
                                            [insurance] => 1.00
                                            [name] => 
                                            [payment] => 
                                        )
        
                                )
        
                        )
        
                    [1] => Array
                        (
                            [order_id] => 382
                            [order_number] => 
                            [order_dispacher_number] => 1108793811
                            [external_dispacher_number] => 
                            [creation_time] => 2019-02-07 13:02:21
                            [dispacher_date] => 2019-02-07 01:02:22
                            [type_id] => 1
                            [service_id] => 1
                            [last_status_id] => 3
                            [last_status_delivery_company_id] => 4
                            [last_status_delivery_company_date] => 2019-02-11 19:42:36
                            [last_status_delivery_company_city_name] => Санкт-Петербург
                            [dop_last_status_id] => 
                            [item_count] => 1
                            [tariff_id] => 136
                            [tariff_name] => Посылка склад-склад
                            [sender_city_id] => 44
                            [sender_city_name] => Москва
                            [sender_flat] => 
                            [sender_house] => 
                            [sender_comment] => 
                            [sender_opf] => 
                            [sender_inn] => 
                            [sender_passport_seria] => 
                            [sender_passport_nomer] => 
                            [reciver_country_id] => 0
                            [reciver_city_id] => 137
                            [reciver_city_name] => Санкт-Петербург
                            [reciver_email] => 
                            [pvz_id] => SPB34
                            [pvz_name] => Сортировочный центр
                            [reciver_name] => Луи.
                            [reciver_phone] => 89991234567
                            [reciver_phone2] => 
                            [reciver_phone3] => 
                            [reciver_street] => 
                            [reciver_home] => 
                            [reciver_ofice] => 
                            [reciver_comment] => Луи. 
                            [reciver_opf] => 
                            [reciver_inn] => 
                            [reciver_passport_seria] => 
                            [reciver_passport_nomer] => 
                            [shop_name] => 
                            [total_sum] => 0.00
                            [courier_number] => 
                            [delivery_recipient_payment] => 0.00
                            [delivery_recipient_payment_fact] => 0.00
                            [total_recipient_payment] => 0.00
                            [total_recipient_payment_fact] => 180.00
                            [min_period] => 
                            [max_period] => 
                            [is_return] => 0
                            [returned_dispacher_number] => 0
                            [np_pereveden] => 0
                            [max_date_storage] => 
                            [act_number] => 2
                            [reestr_user_number] => 
                            [reestr_in_order_date] => 
                            [courier_delivered_phone_name] => 
                            [fsdelivery_courier] => 0
                            [deadline_delivery_date] => 
                            [prices] => Array
                                (
                                    [0] => Array
                                        (
                                            [cost] => 187
                                            [type_id] => 1
                                        )
        
                                    [1] => Array
                                        (
                                            [cost] => 0.75
                                            [type_id] => 2
                                        )
        
                                    [2] => Array
                                        (
                                            [cost] => 37.55
                                            [type_id] => 200
                                        )
        
                                )
        
                            [items] => Array
                                (
                                    [0] => Array
                                        (
                                            [weight] => 0.5
                                            [height] => 0
                                            [width] => 0
                                            [length] => 0
                                            [total] => 0.00
                                            [insurance] => 1.00
                                            [name] => 
                                            [payment] => 
                                        )
        
                                )
        
                        )
        
                )
        
        )
         */
    }
    
    catch (\InvalidArgumentException $e) {
        // Обработка неверного заполнения параметров
        // $e->getMessage(); // Текст ошибки 
    }

    catch (\FsDeliverySdk\Exception\FsDeliveryException $e) {
        // Обработка ошибки вызова API FsDelivery
        // $e->getMessage(); // Текст ошибки 
        // $e->getCode(); // Код ошибки
        // $e->getRawResponse(); // Ответ сервера FsDelivery как есть (http request body)
    }

    catch (\Exception $e) {
        // Обработка исключения
    }
```