<?php

namespace App\Repositories\Client;

use App\Models\Client;
use App\Models\Label;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ClientRepository
 *
 * @package App\Repositories\Client
 */
class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Label
     */
    private $label;

    public function __construct(Client $client, Label $label) {
        $this->client = $client;
        $this->label = $label;
    }

    /**
     * 取引先を全件取得する
     *
     * @return Client
     */
    public function getAll(): Collection
    {
        return $this->client->orderBy('created_at', 'desc')->get();
    }

    /**
     * 取引先を1件取得する
     *
     * @param int $id
     * @return Client
     */
    public function getOne(int $id): Client
    {
        return $this->client->find($id);
    }

    /**
     * 取引先を登録する
     *
     * @param array $data
     * @return Client
     * @throws \Exception
     */
    public function store(array $data): Client
    {
        DB::beginTransaction();
        try {
            // 取引先登録
            $client = $this->client->create($data);
            // ラベル更新
            $this->updateLabels($client, $data);

            DB::commit();

            return $client;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e);
        }
    }

    /**
     * 取引先を更新する
     *
     * @param int $id
     * @param array $data
     * @return Client
     * @throws \Exception
     */
    public function update(int $id, array $data): Client
    {
        DB::beginTransaction();
        try {
            $client = $this->client->findOrFail($id);
            // 取引先更新
            $client->update($data);
            // ラベル更新
            $this->updateLabels($client, $data);

            DB::commit();

            return $client;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e);
        }
    }

    /**
     * 取引先を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $client = $this->client->findOrFail($id);
        $client->delete();
    }

    /**
     * 取引先を更新する
     *
     * @param Client $client
     * @param array $data
     */
    private function updateLabels(Client &$client, array $data)
    {
        $label_ids = [];
        if (!empty($data['labels'])) {
            foreach ($data['labels'] as $labelData) {
                $label = $this->label->find($labelData['id']);
                if (!empty($label)) {
                    $label->update($labelData);
                } else {
                    $labelData['type'] = Label::TYPE_CLIENT;
                    $label = $this->label->create($labelData);
                }
                $label_ids[] = $label->id;
            }
        }
        $client->labels()->sync($label_ids);
    }
}
