<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionItemModel extends Model
{
    protected $table         = 'transaction_items';
    protected $useTimestamps = true;
    protected $allowedFields = ['transaction_id', 'variant_id', 'quantity', 'unit_price'];
}
