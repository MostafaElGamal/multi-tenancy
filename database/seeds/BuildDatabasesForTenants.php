<?php

use Hyn\Tenancy\Contracts\Repositories\CustomerRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Database\Seeder;
use App\Models\System\Customer;


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
                'domain' => 'foo.tenancy.localhost',
                'name' => 'FooCustomer',
                'email' => 'customer@foo.com'
            ],
        ];

        foreach ($customers as $customer) {

            /*
            |--------------------------------------------------------------------------
            | CREATE THE CUSTOMER
            |--------------------------------------------------------------------------
             */
            $newCustomer = Customer::create(['name' => $customer['name'], 'email' => $customer['email']]);

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
            $hostname->customer_id = $newCustomer->id;
            $hostname->fqdn = $customer['domain'];
            app(HostnameRepository::class)->attach($hostname, $website);
        }
    }
}