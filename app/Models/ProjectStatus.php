<?php

namespace App\Models;

use App\Scopes\LoginUser;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectStatus
 *
 * @package App\Models
 */
class ProjectStatus extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new LoginUser());
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
