<?php

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\AppRepository;
use Illuminate\Http\Request;

class ItemRepository extends AppRepository
{
    protected $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
    }
}
