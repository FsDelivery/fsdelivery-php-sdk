<?php
namespace FsDeliverySdk\ValueObject;

class CitiesFilter
{
    /** @var int */
    private $fsdelivery_city_id; // ID города по базе FSDelivery
    /** @var string */
    private $kladr_id; // Код города по КЛАДР
    /** @var string */
    private $fias_id; // Код города по ФИАС
    /** @var int */
    private $postal_code; // Почтовый индекс города
    /** @var string */
    private $country_iso_code; // Код страны (ISO 3166-1 2 буквы)

    /**
     * Формирует параметры для запроса к API
     */
    public function getParams() {
        $params = [];
        if (!empty($this->fsdelivery_city_id)) $params['fsdelivery_city_id'] = $this->fsdelivery_city_id;
        if (!empty($this->kladr_id)) $params['kladr_id'] = $this->kladr_id;
        if (!empty($this->fias_id)) $params['fias_id'] = $this->fias_id;
        if (!empty($this->postal_code)) $params['postal_code'] = $this->postal_code;
        if (!empty($this->country_iso_code)) $params['country_iso_code'] = $this->country_iso_code;
        return $params;
    }

    /**
     * @return int
     */
    public function getFsdeliveryCityId()
    {
        return $this->fsdelivery_city_id;
    }

    /**
     * @param int $fsdelivery_city_id
     */
    public function setFsdeliveryCityId($fsdelivery_city_id)
    {
        $this->fsdelivery_city_id = $fsdelivery_city_id;
    }

    /**
     * @return string
     */
    public function getKladrId()
    {
        return $this->kladr_id;
    }

    /**
     * @param string $kladr_id
     */
    public function setKladrId($kladr_id)
    {
        $this->kladr_id = $kladr_id;
    }

    /**
     * @return string
     */
    public function getFiasId()
    {
        return $this->fias_id;
    }

    /**
     * @param string $fias_id
     */
    public function setFiasId($fias_id)
    {
        $this->fias_id = $fias_id;
    }

    /**
     * @return int
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param int $postal_code
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return string
     */
    public function getCountryIsoCode()
    {
        return $this->country_iso_code;
    }

    /**
     * @param string $country_iso_code
     */
    public function setCountryIsoCode($country_iso_code)
    {
        $this->country_iso_code = $country_iso_code;
    }
}