<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use App\Models\Company;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      //   \App\Models\User::factory(1)->create();
     //   Company::factory(20)->create();
        Employee::factory(15)->create();
    }
}
