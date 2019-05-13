<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(Services::class);
        $this->call(Pages::class);
        $this->call(Peoples::class);
        $this->call(Portfolios::class);
    }
}
