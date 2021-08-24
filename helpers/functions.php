<?php

function filterItemsByStoreId(array $items, $storeId)
{
    return array_filter($items, function($line) use($storeId) {
        return $line['store_id'] = $storeId;
    });
}

function formatPriceToDatabase($price)
{
    //19,00 -> 19.00 ou 1.111,00 -> 1111.00

    return str_replace(['.', ','], ['', '.'], $price);
}