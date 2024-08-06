<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();

        DB::table('marital_status')->insert([
            ['name' => 'Single', 'status' => 'active', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Married', 'status' => 'active', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Divorced', 'status' => 'active', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Widowed', 'status' => 'active', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Separated', 'status' => 'inactive', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);
    }
}
