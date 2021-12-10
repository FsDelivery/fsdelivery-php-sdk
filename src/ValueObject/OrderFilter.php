<?php
namespace FsDeliverySdk\ValueObject;

class OrderFilter implements RequestParamsInterface
{
    use TraitFilter;

    /** @var int|int[] */
    private $order_id; // ID заказа по базе FsDelivery
    /** @var string|string[] */
    private $order_number; // Внутренний номер заказа интернет-магазина
    /** @var string|string[] */
    private $dispacher_number; // Номер накладной / трекинг номер в курьерской службе
    /** @var \DateTimeImmutable */
    private $create_date_begin; // Дата создания заказа ОТ в формате Y-m-d ( это дата создания накладной в курьерской службе, а не дата создания заказа в системе )
    /** @var \DateTimeImmutable */
    private $create_date_end; // Дата создания заказа ДО в формате Y-m-d ( это дата создания накладной в курьерской службе, а не дата создания заказа в системе )
    /** @var \DateTimeImmutable */
    private $delivery_date_begin; // Дата вручения заказа ОТ
    /** @var \DateTimeImmutable */
    private $delivery_date_end; // Дата вручения заказа ДР
    /** @var string */
    private $sender_city_name; // Город отправителя по базе FsDelivery с метода получения списка городов. Например: Екатеринбург
    /** @var string */
    private $reciver_city_name; // Город получателя по базе FsDelivery с метода получения списка городов. Например: Казань
    /** @var string */
    private $reciver_name; // Имя получателя, как оно записано в заказе или заказах, поиск ведется по точному соответствию.
    /** @var string */
    private $reciver_phone; // Телефон получателя, как он записан в заказе или заказах. Не стандантизируется, поиск ведется по точному соответствию.
    /** @var int */
    private $tariff_id; // ID тарифа по базе FsDelivery с метода получения списка тарифов.
    /** @var \DateTimeImmutable */
    private $send_date; // Дата приезда курьера для заказов от двери
    /** @var int */
    private $type_id; // Тип заказа с метода получения типов заказа ( число от 1 до 4 )

    /**
     * @return int|int[]
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param int|int[] $order_id
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * @return string|string[]
     */
    public function getOrderNumber()
    {
        return $this->order_number;
    }

    /**
     * @param string|string[] $order_number
     */
    public function setOrderNumber($order_number)
    {
        $this->order_number = $order_number;
        return $this;
    }

    /**
     * @return string|string[]
     */
    public function getDispacherNumber()
    {
        return $this->dispacher_number;
    }

    /**
     * @param string|string[] $dispacher_number
     */
    public function setDispacherNumber($dispacher_number)
    {
        $this->dispacher_number = $dispacher_number;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderCityName()
    {
        return $this->sender_city_name;
    }

    /**
     * @param string $sender_city_name
     */
    public function setSenderCityName($sender_city_name)
    {
        $this->sender_city_name = $sender_city_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getReciverCityName()
    {
        return $this->reciver_city_name;
    }

    /**
     * @param string $reciver_city_name
     */
    public function setReciverCityName($reciver_city_name)
    {
        $this->reciver_city_name = $reciver_city_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getReciverName()
    {
        return $this->reciver_name;
    }

    /**
     * @param string $reciver_name
     */
    public function setReciverName($reciver_name)
    {
        $this->reciver_name = $reciver_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getReciverPhone()
    {
        return $this->reciver_phone;
    }

    /**
     * @param string $reciver_phone
     */
    public function setReciverPhone($reciver_phone)
    {
        $this->reciver_phone = $reciver_phone;
        return $this;
    }

    /**
     * @return int
     */
    public function getTariffId()
    {
        return $this->tariff_id;
    }

    /**
     * @param int $tariff_id
     */
    public function setTariffId($tariff_id)
    {
        $this->tariff_id = $tariff_id;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getSendDate()
    {
        return $this->send_date;
    }

    /**
     * @param string $send_date
     */
    public function setSendDate($send_date)
    {
        $this->send_date = new \DateTimeImmutable($send_date);
        return $this;
    }

    /**
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param int $type_id
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreateDateBegin()
    {
        return $this->create_date_begin;
    }

    /**
     * @param string $create_date_begin
     */
    public function setCreateDateBegin($create_date_begin)
    {
        $this->create_date_begin = new \DateTimeImmutable($create_date_begin);
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreateDateEnd()
    {
        return $this->create_date_end;
    }

    /**
     * @param string $create_date_end
     */
    public function setCreateDateEnd($create_date_end)
    {
        $this->create_date_end = new \DateTimeImmutable($create_date_end);
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDeliveryDateBegin()
    {
        return $this->delivery_date_begin;
    }

    /**
     * @param string $delivery_date_begin
     */
    public function setDeliveryDateBegin($delivery_date_begin)
    {
        $this->delivery_date_begin = new \DateTimeImmutable($delivery_date_begin);
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDeliveryDateEnd()
    {
        return $this->delivery_date_end;
    }

    /**
     * @param string $delivery_date_end
     */
    public function setDeliveryDateEnd($delivery_date_end)
    {
        $this->delivery_date_end = new \DateTimeImmutable($delivery_date_end);
        return $this;
    }
}