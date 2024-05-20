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

    protected $table = 'products';


    protected $fillable = [

        'name',
        'description',
        'category_id'
      ];

      public function category() {
        return $this->belongsTo(Category::class,'category_id','id')->withTrashed();
    }


 }
