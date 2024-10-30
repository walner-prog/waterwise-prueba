<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
       // $this->call(PermissionsDemoSeeder::class);
     
      //  $this->call(ClienteSeeder::class);
        $this->call(ClientesTableSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(AssignPermissionsToAdminSeeder::class);
        $this->call(ProductSeeder::class);

        

    }
}
