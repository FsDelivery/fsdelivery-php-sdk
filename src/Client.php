<?php

namespace FsDeliverySdk;

use FsDeliverySdk\Exception\FsDeliveryException;
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
                    $this->logger->info("FsDelivery API /{$type} request {$method}: " . http_build_query($params));
                }
                $response = $this->httpClient->get($method, ['headers' => $headers, 'query' => $params]);
                break;
            case 'POST':
                if ($this->logger) {
                    $this->logger->info("FsDelivery API /{$type} request {$method}: " . json_encode($params));
                }
                $response = $this->httpClient->post($method, ['headers' => $headers, 'json' => $params]);
                break;
        }

        $request = http_build_query($params);

        $json = $response->getBody()->getContents();

        if ($this->logger) {
            $headers = $response->getHeaders();
            $headers['http_status'] = $response->getStatusCode();
            $this->logger->info("FsDelivery API response {$method}: " . $json, $headers);
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
}