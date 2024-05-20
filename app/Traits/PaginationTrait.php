<?php

namespace App\Traits;

trait PaginationTrait
{
    public function get_pagination_offset(int $page, int $per_page)
    {
        return intval(($page - 1) * $per_page);
    }
}
