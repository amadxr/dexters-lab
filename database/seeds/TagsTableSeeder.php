<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'name' => 'php'
            ],
            [
                'name' => 'ruby on rails'
            ],
            [
                'name' => 'ruby'
            ],
            [
                'name' => 'blockchain'
            ],
            [
                'name' => 'react'
            ],
            [
                'name' => 'react native'
            ],
            [
                'name' => 'automated qa'
            ],
            [
                'name' => 'noram'
            ]
        ]);
    }
}
