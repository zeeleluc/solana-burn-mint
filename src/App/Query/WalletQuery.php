<?php
namespace App\Query;

use App\Models\Wallet;
use ArrayHelpers\Arr;
use Carbon\Carbon;

class WalletQuery extends Query
{

    private string $table = 'wallets';

    public function createNewWallet(array $values): Wallet
    {
        foreach ($values as $key => $value) {
            if ($value instanceof Carbon) {
                $values[$key] = $value->format('Y-m-d H:i:s');
            }
        }

        $result = $this->db->insert($this->table, $values);
        if (!$result) {
            throw new \Exception('Wallet not created.');
        }

        return $this->getWalletByAddress(Arr::get($values, 'address'));
    }

    /**
     * @return array|Wallet[]
     * @throws \Exception
     */
    public function getAll(): array
    {
        $results = $this->db->get($this->table);

        $wallets = [];
        foreach ($results as $result) {
            $wallets[] = (new Wallet())->fromArray($result);
        }

        return $wallets;
    }

    public function getWalletByAddress(string $wallet): Wallet
    {
        $values = $this->db
            ->where('wallet', $wallet)
            ->getOne($this->table);

        $wallet = new Wallet();
        return $wallet->fromArray($values);
    }

    public function getWalletById(int $id): ?Wallet
    {
        $results = $this->db
            ->where('id', $id)
            ->getOne($this->table);

        if ($results) {
            return (new Wallet())->fromArray($results);
        }

        return null;
    }

    public function doesWalletExist(string $address): bool
    {
        return (bool) $this->db
            ->where('address', $address)
            ->getOne($this->table);
    }
}
