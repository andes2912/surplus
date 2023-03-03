<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
                'name'          => 'Baju Panjang',
                'description'   => 'Baju panjang untuk pria',
                'enable'        => 1
            ],
            [
                'name'          => 'Gamis',
                'description'   => 'Baju panjang untuk wanita',
                'enable'        => 1
            ],
        ];

        foreach ($data as $value) {
            Product::create($value);
            $this->command->info('Product '.$value['name'].' has been saved.');
        }
    }
}
