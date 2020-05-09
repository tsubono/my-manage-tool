<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LoginUser implements Scope
{
    /**
     * ログイン中のユーザーに限定するスコープ
     *
     * @param Builder $builder
     * @param Model $model
     * @return Builder|void
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('user_id', \auth()->user()->id);
    }
}
