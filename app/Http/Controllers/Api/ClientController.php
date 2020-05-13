<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Repositories\Client\ClientRepositoryInterface as ClientRepository;

/**
 * Class ClientController
 *
 * @package App\Http\Controllers\Api
 */
class ClientController extends Controller
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * ClientController constructor.
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository) {
        $this->clientRepository = $clientRepository;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clients = $this->clientRepository->getAll();

        return response()->json(['clients' => $clients], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $client = $this->clientRepository->getOne($id);

        if (empty($client)) {
            return response()->json([], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($client, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param ClientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClientRequest $request)
    {
        $data = $request->all();
        $client = $this->clientRepository->store($data);

        return response()->json(['client' => $client], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 更新
     *
     * @param ClientRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClientRequest $request, int $id)
    {
        $data = $request->all();
        $client = $this->clientRepository->update($id, $data);

        return response()->json(['client' => $client], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->clientRepository->destroy($id);

        return response()->noContent();
    }
}
