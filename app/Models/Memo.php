<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Memo
 *
 * @package App\Models
 */
class Memo extends Model
{
    /**
     * ホワイトリスト
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 日付へキャスト
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
