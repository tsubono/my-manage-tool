<?php

namespace App\Repositories\Client;

use App\Models\Client;
use App\Models\Label;
use Illuminate\Database\Eloquent\Collection;

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

    public function getOne(int $id): Client
    {
        return $this->client->find($id);
    }

    public function getAll(): Collection
    {
        return $this->client->get();
    }

    public function store(array $data): Client
    {
        // 取引先登録
        $client = $this->client->create($data);
        // ラベル更新
        $this->updateLabels($client, $data);

        return $client;
    }

    public function update($id, array $data): Client
    {
        $client = $this->client->findOrFail($id);
        // 取引先更新
        $client->update($data);
        // ラベル更新
        $this->updateLabels($client, $data);

        return $client;
    }

    public function destroy(int $id)
    {
        $client = $this->client->findOrFail($id);
        $client->delete();
    }

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
            $client->labels()->sync($label_ids);
        }
    }
}
