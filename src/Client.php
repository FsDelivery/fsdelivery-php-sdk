<?php

namespace FsDeliverySdk;

use FsDeliverySdk\Exception\FsDeliveryException;
use FsDeliverySdk\ValueObject\CalculateParams;
use FsDeliverySdk\ValueObject\CitiesFilter;
use FsDeliverySdk\ValueObject\OrderFilter;
use FsDeliverySdk\ValueObject\OrderStatusFilter;
use FsDeliverySdk\ValueObject\PvzFilter;
use FsDeliverySdk\ValueObject\ReestrFilter;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Client implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const VERSION = '1.0';

    /** @var string */
    private $token = null;
    /** @var \GuzzleHttp\Client|null */
    private $httpClient = null;

    /** @var string|null */
    private $last_request_id = null;

    /**
     * Client constructor.
     * @param string $apitoken - токен для работы с API
     * @param int $timeout - таймаут ожидания ответа от серверов FsDelivery в секундах
     * @param string $api_uri - адрес API
     */
    public function __construct($apitoken, $timeout = 300, $api_uri = 'https://api.fsdelivery.ru')
    {
        $this->setToken($apitoken);
        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => $api_uri.'/',
            'timeout' => $timeout,
            'http_errors' => false
        ]);
    }

    /**
     * Возвращает токен из хранилища по ключу
     *
     * @return string|null
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Заносит токен в хранилище
     *
     * @param string $token - Токен доступа к API
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string|null
     */
    public function getLastRequestId()
    {
        return $this->last_request_id;
    }

    /**
     * @param string|null $last_request_id
     */
    public function setLastRequestId($last_request_id)
    {
        $this->last_request_id = $last_request_id;
    }

    /**
     * Инициализирует вызов к API
     *
     * @param $type
     * @param $method
     * @param array $params
     * @return array
     * @throws FsDeliveryException
     */
    private function callApi($type, $method, $params = [])
    {
        $headers['X-API-TOKEN'] = $this->getToken();

        switch ($type) {
            case 'GET':
                if ($this->logger) {
                    $this->logger->info("FsDelivery API {$type} request /{$method}: " . http_build_query($params));
                }
                $response = $this->httpClient->get($method, ['headers' => $headers, 'query' => $params]);
                break;
            case 'POST':
                if ($this->logger) {
                    $this->logger->info("FsDelivery API {$type} request /{$method}: " . json_encode($params));
                }
                $response = $this->httpClient->post($method, ['headers' => $headers, 'json' => $params]);
                break;
        }

        $request = http_build_query($params);

        $json = $response->getBody()->getContents();

        if ($this->logger) {
            $headers = $response->getHeaders();
            $headers['http_status'] = $response->getStatusCode();
            $this->logger->info("FsDelivery API response /{$method}: " . $json, $headers);
        }

        $respFS = json_decode($json, true);
        $this->last_request_id = $respFS['request_id'];

        if (in_array($response->getStatusCode(), [401, 403]))
            throw new FsDeliveryException('Ошибка авторизации при вызове метода /' . $method . ': ' . $respFS['error_message'], $respFS['error_code'], $json, $request);

        if ($response->getStatusCode() != 200)
            throw new FsDeliveryException('Неверный код ответа от сервера FsDelivery при вызове метода /' . $method . ': ' . $response->getStatusCode(), $response->getStatusCode(), $json, $request);

        if (empty($respFS))
            throw new FsDeliveryException('От сервера FsDelivery при вызове метода /' . $method . ' пришел пустой ответ', $response->getStatusCode(), $json, $request);

        if (!empty($respFS['error_code']))
            throw new FsDeliveryException('От сервера FsDelivery при вызове метода /' . $method . ' получена ошибка: ' . $respFS['error_message'], $respFS['error_code'], $json, $request);

        return $respFS;
    }

    /**
     * Получение списка служб доставки
     *
     * @return array
     * @throws FsDeliveryException
     */
    public function getDeliveryList()
    {
        return $this->callApi('GET', self::VERSION."/delivery/list");
    }

    /**
     * Получение списка статусов заказа
     *
     * @return array
     * @throws FsDeliveryException
     */
    public function getDeliveryStatuses()
    {
        return $this->callApi('GET', self::VERSION."/delivery/statuses");
    }

    /**
     * Получение списка режимов доставки
     *
     * @param int $type_id - ID режима доставки по базе FsDelivery
     * @return array
     * @throws FsDeliveryException
     */
    public function getDeliveryTypes($type_id = null)
    {
        $params = !empty($type_id) ? ['type_id' => $type_id] : [];
        return $this->callApi('POST', self::VERSION."/delivery/types", $params);
    }

    /**
     * Получение списка тарифов
     *
     * @param int $delivery_id - ID службы доставки по базе FsDelivery
     * @param int $type_id - ID режима доставки по базе FsDelivery
     * @return array
     * @throws FsDeliveryException
     */
    public function getDeliveryTariffs($delivery_id = null, $type_id = null)
    {
        $params = [];
        if (!empty($delivery_id)) $params['delivery_company_id'] = $delivery_id;
        if (!empty($type_id)) $params['type_id'] = $type_id;
        return $this->callApi('POST', self::VERSION."/delivery/tariffs", $params);
    }

    /**
     * Получение списка стран
     *
     * @param int $country_id - ID страны по базе FsDelivery
     * @param string $country_code - Код страны (ISO 3166-1 2 буквы)
     * @param string $country_name - Точное название страны ( например Россия ), поиск без учета регистра
     * @return array
     * @throws FsDeliveryException
     */
    public function getReferenceCountries($country_id = null, $country_code = null, $country_name = null)
    {
        $params = [];
        if (!empty($country_id)) $params['country_id'] = $country_id;
        if (!empty($country_code)) $params['country_code'] = $country_code;
        if (!empty($country_name)) $params['country_name'] = $country_name;
        return $this->callApi('POST', self::VERSION."/reference/countries", $params);
    }

    /**
     * Получение списка городов
     *
     * @param CitiesFilter $searchFilter - объект-фильтр
     * @param int $page_number - Номер страницы для выборки
     * @param int $page_size - Количество результатов на странице
     * @return array
     * @throws FsDeliveryException
     */
    public function getReferenceCities($searchFilter, $page_number = 1, $page_size = 100)
    {
        $params = [];
        if (!empty($page_number)) $params['page_number'] = $page_number;
        if (!empty($page_size)) $params['page_size'] = $page_size;
        $params = array_merge($params, $searchFilter->getParams());
        return $this->callApi('POST', self::VERSION."/reference/cities", $params);
    }

    /**
     * Получение списка городов для AUTOCOMPLETE
     *
     * @param string $char_city_name - Строка поиска по названию города (от двух символов)
     * @param int|null $fsdelivery_country_id - ID страны по базе FSDelivery
     * @return array
     * @throws \InvalidArgumentException
     * @throws FsDeliveryException
     */
    public function getReferenceCitiesAutocomplete($char_city_name, $fsdelivery_country_id = null)
    {
        $params = [];
        if (empty($char_city_name))
            throw new \InvalidArgumentException('Не передан обязательный параметр $char_city_name');

        $params['char_city_name'] = $char_city_name;
        if (!empty($fsdelivery_country_id)) $params['fsdelivery_country_id'] = $fsdelivery_country_id;
        return $this->callApi('POST', self::VERSION."/reference/cities/autocomplete", $params);
    }

    /**
     * Получение списка пунктов выдачи заказов (ПВЗ)
     *
     * @param PvzFilter $pvzFilter - объект-фильтр
     * @return array
     * @throws FsDeliveryException
     */
    public function getDeliveryPoints($pvzFilter)
    {
        return $this->callApi('POST', self::VERSION."/delivery/points", $pvzFilter->getParams());
    }

    /**
     * СПИСОК РЕЕСТРОВ НП
     *
     * @param ReestrFilter $reestrFilter - объект-фильтр
     * @return array
     * @throws FsDeliveryException
     */
    public function getReestrList($reestrFilter)
    {
        return $this->callApi('POST', self::VERSION."/reestr/list", $reestrFilter->getParams());
    }

    /**
     * ДЕТАЛИЗАЦИЯ ПО РЕЕСТРУ НП
     *
     * @param int $reestr_number - Номер реестра наложенного платежа ( поле number из метода /1.0/reestr/list )
     * @return array
     * @throws \InvalidArgumentException
     * @throws FsDeliveryException
     */
    public function getReestrWaybills($reestr_number)
    {
        if (empty($reestr_number))
            throw new \InvalidArgumentException('Не передан номер реестра');

        return $this->callApi('POST', self::VERSION."/reestr/waybills", ['reestr_number' => $reestr_number]);
    }

    /**
     * СТАТУСЫ РЕЕСТРОВ НП
     *
     * @return array
     * @throws FsDeliveryException
     */
    public function getReestrStatuses()
    {
        return $this->callApi('GET', self::VERSION."/reference/reestr/statuses");
    }

    /**
     * ПОЛУЧЕНИЕ ИНФОРМАЦИИ О ПОЛЬЗОВАТЕЛЕ
     *
     * @return array
     * @throws FsDeliveryException
     */
    public function getUserInfo()
    {
        return $this->callApi('GET', self::VERSION."/user/info");
    }

    /**
     * ПОЛУЧЕНИЕ СТАТУСОВ ЗАКАЗА
     *
     * @param OrderStatusFilter $orderStatusFilter - объект-фильтр
     * @return array
     * @throws FsDeliveryException
     */
    public function getOrderStatuses($orderStatusFilter)
    {
        return $this->callApi('POST', self::VERSION."/order/statuses", $orderStatusFilter->getParams());
    }

    /**
     * ПОЛУЧЕНИЕ ИНФОРМАЦИИ ПО ЗАКАЗАМ
     *
     * @param OrderFilter $orderFilter - объект-фильтр
     * @return array
     * @throws FsDeliveryException
     */
    public function getOrders($orderFilter)
    {
        return $this->callApi('POST', self::VERSION."/order/find", $orderFilter->getParams());
    }

    /**
     * КАЛЬКУЛЯТОР ТАРИФОВ
     *
     * @param CalculateParams $calculateParams - объект-параметры таррификатора
     * @return array
     * @throws FsDeliveryException
     */
    public function calculateTariff($calculateParams)
    {
        return $this->callApi('POST', self::VERSION."/tariff/calculation", $calculateParams->getParams());
    }
}