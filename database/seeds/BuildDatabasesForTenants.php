<?php

use Hyn\Tenancy\Contracts\Repositories\CustomerRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Database\Seeder;
use App\System\Customers;


class BuildDatabasesForTenants extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'database' => 'laravel__FooCustomer',
                'domain' => 'test.localhost',
                'name' => 'FooCustomer',
                'email' => 'customer@foo.com'
            ],
        ];

        foreach ($customers as $customer) {

            /*
            |--------------------------------------------------------------------------
            | CREATE THE WEBSITE
            |--------------------------------------------------------------------------
            */
            $website = new Website();
            app(WebsiteRepository::class)->create($website);

            /*
            |--------------------------------------------------------------------------
            | CREATE THE HOSTNAME
            |--------------------------------------------------------------------------
             */
            $hostname = new Hostname();
            $hostname->fqdn = $customer['domain'];
            app(HostnameRepository::class)->attach($hostname, $website);

            /*
            |--------------------------------------------------------------------------
            | CREATE THE CUSTOMER
            |--------------------------------------------------------------------------
             */
            Customers::create(['name' => $customer['name'], 'email' => $customer['email'], 'id' => $website->id]);

            /*
            |--------------------------------------------------------------------------
            | SAVE THE CUSTOMER WITH HIS HOSTNAME AND WEBSITE
            |--------------------------------------------------------------------------
             */
            // $hostname->customer()->associate($customer)->save();
            // $website->customer()->associate($customer)->save();
        }
    }
}
