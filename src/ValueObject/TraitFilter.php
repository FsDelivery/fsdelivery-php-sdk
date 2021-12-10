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
                    if (in_array($property, ['create_date_begin', 'delivery_date_begin'])) {
                        $params[str_replace('_begin', '', $property)]['date_beg'] = $value->format('Y-m-d');
                    } else if (in_array($property, ['create_date_end', 'delivery_date_end'])) {
                        $params[str_replace('_end', '', $property)]['date_end'] = $value->format('Y-m-d');
                    } else {
                        $params[$property] = $value->format('Y-m-d');
                    }
                } else {
                    $params[$property] = $value;
                }
            }
        }
        return $params;
    }
}