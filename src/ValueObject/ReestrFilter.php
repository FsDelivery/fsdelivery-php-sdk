<?php
namespace FsDeliverySdk\ValueObject;

class ReestrFilter
{
    use TraitFilter;

    /** @var int */
    private $status_id; // ID статуса реестра из метода /1.0/reference/reestr/statuses
    /** @var int */
    private $reestr_number; // Фильтрация по номеру реестра ( в ответе в поле number из текущего метода )
    /** @var \DateTimeImmutable */
    private $created_date; // Фильтрация по дата реестра
    /** @var \DateTimeImmutable */
    private $payment_plan_date; // Фильтрация по дате планируемой оплаты реестра ( поле payment_plan_date в ответе из текущего метода )
    /** @var \DateTimeImmutable */
    private $payment_date; // Фильтрация по дате оплаты реестра ( поле payment_date в ответе из текущего метода )

    /**
     * @return int
     */
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * @param int $status_id
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $status_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getReestrNumber()
    {
        return $this->reestr_number;
    }

    /**
     * @param int $reestr_number
     */
    public function setReestrNumber($reestr_number)
    {
        $this->reestr_number = $reestr_number;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * @param string $created_date
     */
    public function setCreatedDate($created_date)
    {
        $this->created_date = new \DateTimeImmutable($created_date);
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPaymentPlanDate()
    {
        return $this->payment_plan_date;
    }

    /**
     * @param string $payment_plan_date
     */
    public function setPaymentPlanDate($payment_plan_date)
    {
        $this->payment_plan_date = new \DateTimeImmutable($payment_plan_date);
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPaymentDate()
    {
        return $this->payment_date;
    }

    /**
     * @param string $payment_date
     */
    public function setPaymentDate($payment_date)
    {
        $this->payment_date = new \DateTimeImmutable($payment_date);
        return $this;
    }
}