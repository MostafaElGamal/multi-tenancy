<?php

namespace App\Http\Controllers\System;

use Hyn\Tenancy\Contracts\Repositories\CustomerRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Environment;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Permission;
use App\Models\System\Customer;
use Illuminate\Http\Request;
use App\Models\Tenant\User;

class CustomersController extends Controller
{

    private function makeDBForCustomer($customer, $domain)
    {
        // Create New website that have db hash name.
        $website = new Website();
        app(WebsiteRepository::class)->create($website);

        // Create New hostname that include the domain and the conication between the db and the domain.
        $hostname = new Hostname();
        $hostname->customer_id = $customer->id;
        $hostname->fqdn = $domain;
        app(HostnameRepository::class)->attach($hostname, $website);
        
        // Now after created all of that switch to the new tenant and add the data that we need.
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);

        $this->makeAdmin($customer);

        // Switch back to the default config
        $tenancy->identifyHostname();
    }

    private function makeAdmin($customer)
    {
        $permissions = $this->permissions($customer);
        $user = User::create([
            'name' => 'tenant name',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => 'password', 
        ]);
        $user->givePermissionTo($permissions);
    }

    private function permissions($customer)
    {
        $customerPermissions = $customer->getAllPermissions();
        $customerUserPermissions = Permission::all();
        $permissions = [];
        foreach ($customerUserPermissions as $permission) {
            if (linearSearch($permission, $customerPermissions)) {
                array_push($permissions, $permission);
            }
        }
        return $permissions;
    }

    private function getCustomer($id)
    {
        $customer = Customer::find($id);
        $customer->domain = $customer->hostname->fqdn;
        $permissions =  $customer->getAllPermissions()->pluck('id');
        return ['customer' => $customer,'permissions' => $permissions];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customer::with('hostname')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create Custoemr and give this customer peromissions
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $customer->givePermissionTo($permissions);
        
        // Now Create the database for that customer and contact all of that together
    
        $this->makeDBForCustomer($customer, $request->domain);
        return $customer;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customers
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = $this->getCustomer($id);
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $customer = Customer::find($id);
        $customer->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        if( $request->domain ){
            $customer->hostname->update(['fqdn' => $request->domain]);
        }
        $customer->syncPermissions($permissions);
        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        // $hostname = $customer->hostname;
        // $website = $hostname->website->first();
        // \Schema::dropIfExists($website['uuid']);
        // $website->delete();
        // $hostname->delete();
        // $customer->delete();
        // return 'Deleted';
        // $hostname = Hostname::find($customer->hostname->id);
        // $website = Website::find( $hostname->website->first()->id);
        // dd( $website );
        // $website = $hostname->website->first();

        
    }
}