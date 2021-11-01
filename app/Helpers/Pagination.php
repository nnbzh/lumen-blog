<?php

namespace App\Helpers;

class Pagination
{
    public static function handle($result): ?array
    {
        $data['total']        = $result->total();
        $data['current_page'] = $result->currentPage();
        $data['last_page']    = $result->lastPage();
        $data['details']      = $result->items();

        return $data;
    }
}