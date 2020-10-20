<?php

use App\Sheep;
use Illuminate\Database\Seeder;

class SheepTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0;$i < 4 ; $i++){
            Sheep::create([
                'group_id' => $i+1,
                'name' => "Sheep $i"
            ]);
        }
        for ($i = 4;$i < 10 ; $i++){
            Sheep::create([
                'group_id' => rand(1,4),
                'name' => "Sheep $i"
            ]);
        }
    }
}
