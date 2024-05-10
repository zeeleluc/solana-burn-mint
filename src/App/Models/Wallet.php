<?php

namespace App\Models;

use App\Query\WalletQuery;
use ArrayHelpers\Arr;
use Carbon\Carbon;

class Wallet extends BaseModel
{

    public ?int $id = null;

    public string $address;

    public ?Carbon $createdAt = null;

    public ?Carbon $updatedAt = null;

    public function initNew(array $values)
    {
        $wallet = $this->fromArray($values);

        return $wallet->save();
    }

    public function fromArray(array $values): Wallet
    {
        $wallet = new $this;
        if ($id = Arr::get($values, 'id')) {
            $wallet->id = $id;
        }
        if ($createdAt = Arr::get($values, 'created_at')) {
            $wallet->createdAt = Carbon::parse($createdAt);
        }
        if ($updatedAt = Arr::get($values, 'updated_at')) {
            $wallet->updatedAt = Carbon::parse($updatedAt);
        }

        return $wallet;
    }

    public function toArray(): array
    {
        $array = [];

        if ($this->id) {
            $array['id'] = $this->id;
        }
        if ($this->createdAt) {
            $array['created_at'] = $this->createdAt;
        }
        if ($this->updatedAt) {
            $array['updated_at'] = $this->updatedAt;
        }

        return $array;
    }

    /**
     * @throws \Exception
     */
    public function save()
    {
        if ($this->getQueryObject()->doesWalletExist($this->address)) {
            throw new \Exception('Wallet `' . $this->address . '` exists!');
        }

        return $this->getQueryObject()->createNewWallet($this->toArray());
    }

    public function getQueryObject()
    {
        return new WalletQuery();
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}
