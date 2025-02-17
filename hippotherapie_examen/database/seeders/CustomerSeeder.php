<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'Assoc1', 'email' => 'marie.durand@example.com', 'street' => ' Rue des Fleurs', 'number' => '56', 'postal_code' => '1000', 'city' => 'Bruxelles', 'phone' =>'+32 2 123 45 67'],
            ['name' => 'Assoc2', 'email' => 'paul.martin@test.com', 'street' => 'Avenue de la Liberté', 'number' => '23', 'postal_code' => '4000', 'city' => 'Liège', 'phone' =>'+32 3 987 65 43'],
            ['name' => 'Assoc3', 'email' => 'julie.leclerc@mail.com', 'street' => 'Boulevard Saint-Germain', 'number' => '78', 'postal_code' => '1060', 'city' => 'Bruxelles', 'phone' =>'+32 4 567 89 01'],
            ['name' => 'Assoc4', 'email' => 'thomas.dupont@demo.com', 'street' => 'Impasse des Écoles', 'number' => '90', 'postal_code' => '6000', 'city' => 'Charleroi', 'phone' =>'+32 2 234 56 78'],
            ['name' => 'Assoc5', 'email' => 'emilie.boucher@example.org', 'street' => 'Rue de la Paix', 'number' => '78', 'postal_code' => '2000', 'city' => 'Anvers', 'phone' =>'+32 10 12 34 56'],
            ['name' => 'Assoc6', 'email' => 'lucas.roux@test.com', 'street' => 'Chemin des Vignes', 'number' => '12', 'postal_code' => '8000', 'city' => 'Bruges', 'phone' =>'+32 9 876 54 32'],
            ['name' => 'Assoc7', 'email' => 'claire.morel@mail.com', 'street' => 'Rue du Moulin', 'number' => '09', 'postal_code' => '3000', 'city' => 'Louvain', 'phone' =>'+32 2 345 67 89'],
            ['name' => 'Assoc8', 'email' => 'nicolas.fournier@demo.com', 'street' => 'Place de la République', 'number' => '34', 'postal_code' => '1200', 'city' => 'Bruxelles', 'phone' =>'+32 4 321 09 87'],
            ['name' => 'Assoc9', 'email' => 'chloe.bernard@example.com', 'street' => 'Rue des Jardins', 'number' => '3', 'postal_code' => '5000', 'city' => 'Namur', 'phone' =>'+32 3 456 78 90'],
            ['name' => 'Assoc10','email' => 'maxime.leroy@test.com', 'street' => 'Allée des Chênes', 'number' => '87', 'postal_code' => '9000', 'city' => 'Gand', 'phone' =>'+32 2 678 90 12'],
        ];
        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
