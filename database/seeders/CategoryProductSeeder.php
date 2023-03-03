<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'product_id'    => 1,
                'category_id'   => 1,
            ],
            [
                'product_id'    => 2,
                'category_id'   => 2,
            ]
        ];

        foreach ($data as $value) {
            CategoryProduct::create($value);
            $this->command->info('Category Product has been saved.');
        }
    }
}
