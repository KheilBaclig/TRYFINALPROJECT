<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $users = [
            ['name' => 'Super Admin', 'email' => 'superadmin@apparelhub.com', 'password' => password_hash('password', PASSWORD_BCRYPT), 'role' => 'superadmin', 'api_token' => bin2hex(random_bytes(32)), 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Store Manager', 'email' => 'manager@apparelhub.com', 'password' => password_hash('password', PASSWORD_BCRYPT), 'role' => 'manager', 'api_token' => bin2hex(random_bytes(32)), 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Staff One', 'email' => 'staff@apparelhub.com', 'password' => password_hash('password', PASSWORD_BCRYPT), 'role' => 'staff', 'api_token' => bin2hex(random_bytes(32)), 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('users')->insertBatch($users);

        // Categories
        $categories = [
            ['name' => 'Tops', 'slug' => 'tops', 'description' => 'T-shirts, blouses, and shirts', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Bottoms', 'slug' => 'bottoms', 'description' => 'Pants, jeans, and shorts', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'description' => 'Jackets, coats, and hoodies', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Footwear', 'slug' => 'footwear', 'description' => 'Shoes, sneakers, and sandals', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Bags, belts, and hats', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('categories')->insertBatch($categories);

        // Products
        $products = [
            ['category_id' => 1, 'name' => 'Classic White Tee', 'slug' => 'classic-white-tee', 'sku' => 'TOP-001', 'description' => 'Premium cotton classic white t-shirt', 'price' => 29.99, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['category_id' => 1, 'name' => 'Linen Button Shirt', 'slug' => 'linen-button-shirt', 'sku' => 'TOP-002', 'description' => 'Breathable linen button-up shirt', 'price' => 59.99, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['category_id' => 2, 'name' => 'Slim Fit Chinos', 'slug' => 'slim-fit-chinos', 'sku' => 'BOT-001', 'description' => 'Modern slim fit chino pants', 'price' => 79.99, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['category_id' => 2, 'name' => 'Raw Denim Jeans', 'slug' => 'raw-denim-jeans', 'sku' => 'BOT-002', 'description' => 'Japanese raw selvedge denim', 'price' => 149.99, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['category_id' => 3, 'name' => 'Wool Overcoat', 'slug' => 'wool-overcoat', 'sku' => 'OUT-001', 'description' => 'Italian wool blend overcoat', 'price' => 299.99, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['category_id' => 3, 'name' => 'Puffer Jacket', 'slug' => 'puffer-jacket', 'sku' => 'OUT-002', 'description' => 'Lightweight down puffer jacket', 'price' => 189.99, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['category_id' => 4, 'name' => 'Leather Derby Shoes', 'slug' => 'leather-derby-shoes', 'sku' => 'FOO-001', 'description' => 'Full-grain leather derby shoes', 'price' => 219.99, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['category_id' => 5, 'name' => 'Canvas Tote Bag', 'slug' => 'canvas-tote-bag', 'sku' => 'ACC-001', 'description' => 'Heavy canvas tote bag', 'price' => 49.99, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('products')->insertBatch($products);

        // Variants
        $variants = [];
        $sizes  = ['XS', 'S', 'M', 'L', 'XL'];
        $colors = [['name' => 'White', 'hex' => '#FFFFFF'], ['name' => 'Black', 'hex' => '#1A1A1A'], ['name' => 'Navy', 'hex' => '#1B2A4A']];
        for ($p = 1; $p <= 8; $p++) {
            foreach ($sizes as $size) {
                foreach ($colors as $color) {
                    $variants[] = ['product_id' => $p, 'size' => $size, 'color' => $color['name'], 'color_hex' => $color['hex'], 'stock' => rand(5, 50), 'created_at' => date('Y-m-d H:i:s')];
                }
            }
        }
        $this->db->table('product_variants')->insertBatch($variants);
    }
}
