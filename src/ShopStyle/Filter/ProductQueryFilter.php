<?php

namespace ShopStyle\Filter;


class ProductQueryFilter
{
    public static function convertFilterItem($filters)
    {
        $map = array(
            "retailer" => "r",
            "color" => "c",
            "brand" => "b",
            "price" => "p",
            "sale" => "d",
            "size" => "s",
        );

        return array_map(
            function ($filter) use ($map) {
                $key = key($filter);
                $value = current($filter);

                if (isset($map[$key])) {
                    return $map[$key] . $value;
                }

                return $key . $value;

            },
            $filters
        );
    }
}
