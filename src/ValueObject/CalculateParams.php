<?php
namespace FsDeliverySdk\ValueObject;

class CalculateParams implements RequestParamsInterface
{
    /** @var int[] */
    private $type_id; // ID режима доставки по базе FsDelivery
    /** @var int[] */
    private $tariff_id_list; // Фильтр по ID тарифов которые нужны
    /** @var int[] */
    private $delivery_company_id; // ID служб доставки по базе FsDelivery
    /** @var boolean */
    private $add_items_prices; // Учитывать ли в калькуляции товары
    /** @var int */
    private $sender_city_id; // ID города отправителя по базе FsDelivery
    /** @var int */
    private $reciver_city_id; // ID города получателя по базе FsDelivery
    /** @var string */
    private $sender_city_kladr; // КЛАДР города отправителя
    /** @var string */
    private $reciver_city_kladr; // КЛАДР города получателя
    /** @var string */
    private $sender_city_fias; // ФИАС города отправителя
    /** @var string */
    private $reciver_city_fias; // ФИАС города получателя
    /** @var string */
    private $sender_city_index; // Почтовый индекс города отправителя
    /** @var string */
    private $reciver_city_index; // Почтовый индекс города получателя
    /** @var Package[]  */
    private $packages = [];
    /** @var Item[]  */
    private $items = [];

    public function getParams()
    {
        $params = [];
        foreach (get_object_vars($this) as $property => $value) {
            if (in_array($property, ['packages', 'items'])) continue;
            if (!empty($value)) {
                $params[$property] = $value;
            }
        }

        if (!empty($this->packages)) {
            $params['packages'] = [];
            foreach ($this->packages as $package) {
                $params['packages'][] = $package->getParams();
            }
        }

        if (!empty($this->items)) {
            $params['items'] = [];
            foreach ($this->items as $item) {
                $params['items'][] = $item->getParams();
            }
        }

        return $params;
    }

    /**
     * @return int[]
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param int[] $type_id
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getTariffIdList()
    {
        return $this->tariff_id_list;
    }

    /**
     * @param int[] $tariff_id_list
     */
    public function setTariffIdList($tariff_id_list)
    {
        $this->tariff_id_list = $tariff_id_list;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getDeliveryCompanyId()
    {
        return $this->delivery_company_id;
    }

    /**
     * @param int[] $delivery_company_id
     */
    public function setDeliveryCompanyId($delivery_company_id)
    {
        $this->delivery_company_id = $delivery_company_id;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAddItemsPrices()
    {
        return $this->add_items_prices;
    }

    /**
     * @param bool $add_items_prices
     */
    public function setAddItemsPrices($add_items_prices)
    {
        $this->add_items_prices = $add_items_prices;
        return $this;
    }

    /**
     * @return int
     */
    public function getSenderCityId()
    {
        return $this->sender_city_id;
    }

    /**
     * @param int $sender_city_id
     */
    public function setSenderCityId($sender_city_id)
    {
        $this->sender_city_id = $sender_city_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getReciverCityId()
    {
        return $this->reciver_city_id;
    }

    /**
     * @param int $reciver_city_id
     */
    public function setReciverCityId($reciver_city_id)
    {
        $this->reciver_city_id = $reciver_city_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderCityKladr()
    {
        return $this->sender_city_kladr;
    }

    /**
     * @param string $sender_city_kladr
     */
    public function setSenderCityKladr($sender_city_kladr)
    {
        $this->sender_city_kladr = $sender_city_kladr;
        return $this;
    }

    /**
     * @return string
     */
    public function getReciverCityKladr()
    {
        return $this->reciver_city_kladr;
    }

    /**
     * @param string $reciver_city_kladr
     */
    public function setReciverCityKladr($reciver_city_kladr)
    {
        $this->reciver_city_kladr = $reciver_city_kladr;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderCityFias()
    {
        return $this->sender_city_fias;
    }

    /**
     * @param string $sender_city_fias
     */
    public function setSenderCityFias($sender_city_fias)
    {
        $this->sender_city_fias = $sender_city_fias;
        return $this;
    }

    /**
     * @return string
     */
    public function getReciverCityFias()
    {
        return $this->reciver_city_fias;
    }

    /**
     * @param string $reciver_city_fias
     */
    public function setReciverCityFias($reciver_city_fias)
    {
        $this->reciver_city_fias = $reciver_city_fias;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderCityIndex()
    {
        return $this->sender_city_index;
    }

    /**
     * @param string $sender_city_index
     */
    public function setSenderCityIndex($sender_city_index)
    {
        $this->sender_city_index = $sender_city_index;
        return $this;
    }

    /**
     * @return string
     */
    public function getReciverCityIndex()
    {
        return $this->reciver_city_index;
    }

    /**
     * @param string $reciver_city_index
     */
    public function setReciverCityIndex($reciver_city_index)
    {
        $this->reciver_city_index = $reciver_city_index;
        return $this;
    }

    /**
     * @return Package[]
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @param Package $pakage
     */
    public function addPackage($pakage)
    {
        $this->packages[] = $pakage;
        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Item $item
     */
    public function addItem($item)
    {
        $this->items[] = $item;
        return $this;
    }
}