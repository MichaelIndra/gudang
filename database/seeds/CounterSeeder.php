<?php

use Illuminate\Database\Seeder;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Counter::create([
            'nama' => 'INV-CUST',
            'counter' => 1
        ],[
            'nama' => 'INV-SUPP',
            'counter' => 1
        ]);
    }
}
