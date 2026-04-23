<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table         = 'transactions';
    protected $useTimestamps = true;
    protected $allowedFields = ['ref_code', 'type', 'user_id', 'total', 'notes'];

    protected $validationRules = [
        'type'    => 'required|in_list[sale,return]',
        'user_id' => 'required|integer',
        'total'   => 'required|decimal',
    ];

    public function withUser(): static
    {
        return $this->select('transactions.*, users.name as user_name')
                    ->join('users', 'users.id = transactions.user_id');
    }

    public function generateRef(): string
    {
        return 'TXN-' . strtoupper(substr(uniqid(), -6)) . '-' . date('Ymd');
    }
}
