<?php

namespace App\Models;

use App\Scopes\LoginUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Todo
 *
 * @package App\Models
 */
class Todo extends Model
{
    use SoftDeletes;

    const LIMIT_WARNING_DAYS = 3;

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
        'is_warning',
    ];

    /**
     * 期限日が警告範囲内かどうかを取得する
     *
     * @return bool
     */
    public function getIsWarningAttribute()
    {
        $isWarning = false;
        $limitWarningDay = Carbon::now()->addDays(self::LIMIT_WARNING_DAYS);
        $limit = $this->limit_datetime;
        // gt: $limitWarningDayが$limitより大きいかどうか
        if ($limitWarningDay->gt($limit)) {
            $isWarning = true;
        }

        return $isWarning;
    }
}
