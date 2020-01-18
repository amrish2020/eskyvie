<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ads_id','media', 'url','ads_type','budeget','start_at','end_at','created_by'
    ];

}
