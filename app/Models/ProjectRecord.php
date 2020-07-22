<?php

namespace App\Models;

use App\Scopes\LoginUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProjectRecord
 *
 * @package App\Models
 */
class ProjectRecord extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
    }

    /**
     * ホワイトリスト
     *
     * @var array
     */
    protected $guarded = ['id', 'project'];

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
        'project',
    ];

    /**
     * 案件情報を取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getProjectAttribute()
    {
        return $this->project()
            ->getResults();
    }


    /**
     * 紐づく案件
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
