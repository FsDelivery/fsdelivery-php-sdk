<?php
namespace FsDeliverySdk\ValueObject;

class Item implements RequestParamsInterface
{
    use TraitFilter;

    /** @var float */
    private $insurance; // Сумма страхования товара
    /** @var float */
    private $payment_sum; // Сумма наложенного платежа

    /**
     * @return float
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * @param float $insurance
     */
    public function setInsurance($insurance)
    {
        $this->insurance = $insurance;
    }

    /**
     * @return float
     */
    public function getPaymentSum()
    {
        return $this->payment_sum;
    }

    /**
     * @param float $payment_sum
     */
    public function setPaymentSum($payment_sum)
    {
        $this->payment_sum = $payment_sum;
    }
}