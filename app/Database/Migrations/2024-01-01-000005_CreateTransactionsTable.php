<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'ref_code'    => ['type' => 'VARCHAR', 'constraint' => 30],
            'type'        => ['type' => 'ENUM', 'constraint' => ['sale', 'return'], 'default' => 'sale'],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'total'       => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'notes'       => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('ref_code');
        $this->forge->createTable('transactions');
    }

    public function down(): void
    {
        $this->forge->dropTable('transactions');
    }
}
