<?php

namespace App\Models;

use App\Scopes\LoginUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project
 *
 * @package App\Models
 */
class Project extends Model
{
    use SoftDeletes;

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
    protected $guarded = ['id', 'labels', 'client', 'status'];

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
        'client',
        'labels',
        'status',
    ];

    /**
     * 所属取引先情報を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getClientAttribute()
    {
        return $this->client()
            ->getResults();
    }

    /**
     * ラベル一覧情報を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getLabelsAttribute()
    {
        return $this->labels()
            ->getResults();
    }

    /**
     * ステータス情報を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getStatusAttribute()
    {
        return $this->status()
            ->getResults();
    }

    /**
     * 紐づく取引先
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
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

    /**
     * 紐づくステータス
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id');
    }
}
