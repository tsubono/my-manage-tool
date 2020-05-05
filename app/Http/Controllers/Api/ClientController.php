<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;

/**
 * Class ClientController
 *
 * @package App\Http\Controllers\Api
 */
class ClientController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * ClientController constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clients = $this->client->all();
        return response()->json(['clients' => $clients], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $client = $this->client->query()->find($id);
        if (empty($client)) {
            return response()->json([], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($client, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成 : TODO
     */
    public function store()
    {
        //
    }

    /**
     * 更新 : TODO
     */
    public function update()
    {
       //
    }

    /**
     * 削除 : TODO
     */
    public function destroy()
    {
       //
    }
}
