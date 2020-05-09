<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Analytic
 *
 * @package App\Models
 */
class Analytic extends Model
{
    public $timestamps = false;
    
    /**
     * ホワイトリスト
     *
     * @var array
     */
    protected $guarded = ['id'];
}
