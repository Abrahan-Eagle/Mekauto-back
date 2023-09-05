<?php

namespace Database\Seeders;

use App\Models\vehicle_types;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $type_vehicles = [
            ['id' => 1,'name' => 'car'],
            ['id' => 2,'name' => 'motorcycles'],
            ['id' => 3,'name' => 'truck'],
            ['id' => 4,'name' => 'ship'],
            ['id' => 5,'name' => 'aircraft']
          ];

        // Insertar datos en la tabla tipo_vehiculos
        foreach ($type_vehicles as $type_vehicle) {
            $type_vehiclex = vehicle_types::create($type_vehicle);
            echo $type_vehiclex . "Vehiculo:";
        }

    }
}
