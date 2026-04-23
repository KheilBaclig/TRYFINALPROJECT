<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductVariantsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'product_id' => ['type' => 'INT', 'unsigned' => true],
            'size'       => ['type' => 'VARCHAR', 'constraint' => 20],
            'color'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'color_hex'  => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'stock'      => ['type' => 'INT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('product_variants');
    }

    public function down(): void
    {
        $this->forge->dropTable('product_variants');
    }
}
