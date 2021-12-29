<?php

namespace Database\Seeders;

use App\Models\Cat;
use Illuminate\Database\Seeder;

class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats=[
            [
                'category'=>'sports',
            ],
            [
                'category'=>'news',
            ],
            [
                'category'=>'business',
            ],
            [
                'category'=>'lifestyle',
            ],

        ];
        Cat::insert($cats);
    }
}
