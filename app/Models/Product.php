<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 use App\Models\Category;

class Product extends Model
{
     use SoftDeletes;
    use HasFactory;

    protected $table = 'product';


    protected $fillable = [

        'productname',
        'description',
        'category_id'
      ];

      public function categorys() {
        return $this->belongsTo(Category::class);
    }
 }
