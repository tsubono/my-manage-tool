<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectStatus
 *
 * @package App\Models
 */
class ProjectStatus extends Model
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
