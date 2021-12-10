<?php
namespace FsDeliverySdk\ValueObject;

trait TraitFilter
{
    /**
     * Формирует параметры для запроса к API
     */
    public function getParams()
    {
        $params = [];
        foreach (get_object_vars($this) as $property => $value) {
            if (!empty($value)) $params[$property] = $value;
        }
        return $params;
    }
}