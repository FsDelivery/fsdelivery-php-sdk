<?php
namespace FsDeliverySdk\ValueObject;

class OrderStatusFilter implements RequestParamsInterface
{
    use TraitFilter;

    /** @var int|int[] */
    private $order_id; // ID заказа по базе FsDelivery
    /** @var string|string[] */
    private $order_number; // Внутренний номер заказа интернет-магазина
    /** @var string|string[] */
    private $dispacher_number; // Номер накладной / трекинг номер в курьерской службе
    /** @var int */
    private $show_history; // Загружать ли историю статусов заказа ( 0 - нет, 1 - да )

    /**
     * @return int
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
     * @return int|int[]
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
     * @return int
     */
    public function getShowHistory()
    {
        return $this->show_history;
    }

    /**
     * @param int $show_history
     */
    public function setShowHistory($show_history)
    {
        $this->show_history = $show_history;
        return $this;
    }
}