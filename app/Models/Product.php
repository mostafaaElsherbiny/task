<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['id','name','price'];
    protected $usd=1;
    protected $eg=10;



    public function getPriceAttribute($value){
        if(request()->current=='usd'){
                return $value*$this->usd;
        }elseif(request()->current=='eg'){
            return $value*$this->eg;
        }

        return $value;
    }
}
