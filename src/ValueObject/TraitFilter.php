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
            if (!empty($value)) {
                if (is_a($value, \DateTimeImmutable::class)) {
                    $params[$property] = $value->format('Y-m-d');
                } else {
                    $params[$property] = $value;
                }
            }
        }
        return $params;
    }
}