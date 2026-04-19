<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'master.admin@poc.example'],
            [
                'name' => 'Master Admin',
                'password' => Hash::make('DummyAdmin!2026'),
            ],
        );

        // Sample clients
        $clients = [
            [
                'name' => 'Sunrise Pharmacy',
                'company_name' => 'Sunrise Pharmacy',
                'email' => 'info@sunrisepharmacy.lk',
                'phone' => '+94112345678',
                'address' => 'Colombo 03',
                'client_access_code' => 'BS-SUNPH-2024',
                'status' => 'active',
                'plan' => 'medium',
                'users' => 8,
                'user_limit' => 10,
                'mrr' => 4800,
                'joined_at' => now()->subMonths(3),
                'vertical' => 'Pharmacy',
            ],
            [
                'name' => 'Grand Colombo Hotel',
                'company_name' => 'Grand Colombo Hotel',
                'email' => 'admin@grandcolombo.lk',
                'phone' => '+94112234567',
                'address' => 'Colombo 01',
                'client_access_code' => 'BS-GNDH-0092',
                'status' => 'active',
                'plan' => 'large',
                'users' => 24,
                'user_limit' => 50,
                'mrr' => 12500,
                'joined_at' => now()->subMonths(8),
                'vertical' => 'Hospitality',
            ],
            [
                'name' => 'Pages & Prose Books',
                'company_name' => 'Pages & Prose Books',
                'email' => 'hello@pagesandprose.lk',
                'phone' => '+94812234567',
                'address' => 'Kandy',
                'client_access_code' => 'BS-PGST-0471',
                'status' => 'trial',
                'plan' => 'small',
                'users' => 2,
                'user_limit' => 5,
                'mrr' => 0,
                'joined_at' => now()->subWeeks(2),
                'vertical' => 'Retail',
            ],
            [
                'name' => 'BuildRight Hardware',
                'company_name' => 'BuildRight Hardware',
                'email' => 'support@buildright.lk',
                'phone' => '+94115678912',
                'address' => 'Colombo 02',
                'client_access_code' => 'BS-BLDR-1183',
                'status' => 'active',
                'plan' => 'medium',
                'users' => 6,
                'user_limit' => 10,
                'mrr' => 4800,
                'joined_at' => now()->subMonths(6),
                'vertical' => 'Retail',
            ],
            [
                'name' => 'FreshMart Supermarket',
                'company_name' => 'FreshMart Supermarket',
                'email' => 'admin@freshmart.lk',
                'phone' => '+94703456789',
                'address' => 'Colombo 10',
                'client_access_code' => 'BS-FRSMT-2290',
                'status' => 'suspended',
                'plan' => 'large',
                'users' => 18,
                'user_limit' => 50,
                'mrr' => 0,
                'joined_at' => now()->subMonths(12),
                'vertical' => 'Retail',
            ],
            [
                'name' => 'Café Mocha',
                'company_name' => 'Café Mocha',
                'email' => 'info@cafemocha.lk',
                'phone' => '+94112567890',
                'address' => 'Colombo 04',
                'client_access_code' => 'BS-CAFMC-3314',
                'status' => 'trial',
                'plan' => 'small',
                'users' => 3,
                'user_limit' => 5,
                'mrr' => 0,
                'joined_at' => now()->subWeeks(1),
                'vertical' => 'Food & Beverage',
            ],
            [
                'name' => 'Galle Fort Boutique',
                'company_name' => 'Galle Fort Boutique',
                'email' => 'contact@gallefort.lk',
                'phone' => '+94912345678',
                'address' => 'Galle',
                'client_access_code' => 'BS-GLFT-0887',
                'status' => 'active',
                'plan' => 'small',
                'users' => 1,
                'user_limit' => 5,
                'mrr' => 1800,
                'joined_at' => now()->subMonths(4),
                'vertical' => 'Fashion',
            ],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(
                ['client_access_code' => $client['client_access_code']],
                $client
            );
        }
    }
}
