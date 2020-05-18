<?php

namespace App\Models;

use App\Scopes\LoginUser;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SaleStatus
 *
 * @package App\Models
 */
class SaleStatus extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new LoginUser());
        static::creating(function (Model $model) {
            $model->user_id = auth()->id();
        });
    }

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
