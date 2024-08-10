<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Company;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'soya',
            'email' => 'soya@example.com',
            'password' => bcrypt('soy@ten@k@321'),
        ]);

        $company = Company::create(['name' => 'Soya Tenaka']);

        $paymentMethods = [
            ['method' => 'Cash', 'company_id' => $company->id],
            ['method' => 'QR Code', 'company_id' => $company->id],
            ['method' => 'Online Transfer', 'company_id' => $company->id],
        ];

        foreach ($paymentMethods as $paymentMethod) {
            PaymentMethod::create($paymentMethod);
        }

        $clients = [
            ['name' => 'Walk In', 'company_id' => $company->id],
            ['name' => 'Rojak Rembau', 'company_id' => $company->id],
            ['name' => 'Pasar Nelayan Rembau', 'company_id' => $company->id],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }

        $products = [
            ['name' => 'Air Soya', 'price' => 3.00, 'company_id' => $company->id],
            ['name' => 'Taufufa', 'price' => 3.00, 'company_id' => $company->id],
            ['name' => 'Tauhu', 'price' => 1.00, 'company_id' => $company->id],
            ['name' => 'Tauhu 1 pek', 'price' => 5.00, 'company_id' => $company->id],
            ['name' => 'Tauhu pasar', 'price' => 0.75, 'company_id' => $company->id],
            ['name' => 'Fucuk 1 pek', 'price' => 5.00, 'company_id' => $company->id],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
