<?php

namespace App\Models;

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

    public function scopeProject($query)
    {
        return $query->where('type', self::TYPE_PROJECT);
    }
}
