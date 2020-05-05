<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['token']]);
    }

    /**
     * 認証チェック & トークン発行処理
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function token()
    {
        $credentials = request(['email', 'password']);

        try {
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => '認証情報をお確かめください'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return response()->json(compact('token'));
    }

    /**
     * 認証済みユーザー情報を取得
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * ログアウト
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * token リフレッシュ
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * tokenを返却
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
