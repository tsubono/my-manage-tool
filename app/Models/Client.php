<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 *
 * @package App\Models
 */
class Client extends Model
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

    /**
     * データ取得時に付与する情報
     *
     * @var array
     */
    protected $appends = [
        'labels',
    ];

    /**
     * ラベル一覧情報を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getLabelsAttribute()
    {
        return  $this->labels()
            ->getResults()
            ->makeHidden(['projects']);
    }

    /**
     * 紐づくラベル
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
