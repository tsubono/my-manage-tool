<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SaleStatus
 *
 * @package App\Models
 */
class SaleStatus extends Model
{
    /**
     * ホワイトリスト
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * created_at, updated_atを使用しない
     *
     * @var bool
     */
    public $timestamps = false;
}
