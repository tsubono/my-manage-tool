<?php

namespace App\Models;

use App\Scopes\LoginUser;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Label
 *
 * @package App\Models
 */
class Label extends Model
{
    const TYPE_PROJECT = 1;
    const TYPE_CLIENT = 2;
    const TYPES = [
        self::TYPE_PROJECT,
        self::TYPE_CLIENT
    ];

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

    protected $hidden = ['pivot'];

    /**
     * 案件にひもづくラベルに絞るScope
     *
     * @param $query
     * @return mixed
     */
    public function scopeProject($query)
    {
        return $query->where('type', self::TYPE_PROJECT);
    }

    /**
     * 取引先にひもづくラベルに絞るScope
     *
     * @param $query
     * @return mixed
     */
    public function scopeClient($query)
    {
        return $query->where('type', self::TYPE_CLIENT);
    }
}
