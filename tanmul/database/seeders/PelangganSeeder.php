<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        for($i=0; $i<100; $i++) {
            DB::table('pelanggan')->insert([
                'nama_plg'=>$faker->name,
                'telp_plg'=>$faker->phoneNumber,
                'alamat_utama'=>$faker->address,
            ]);
        };
    }
}
