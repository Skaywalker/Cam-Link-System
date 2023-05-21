<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCustomerRequest;
use App\Http\Requests\Api\V1\UpdateCustomerRequest;
use App\Http\Resources\Api\V1\CustomerCollection;
use App\Http\Resources\Api\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    //todo: Teljes kontroller kérések validációkkal jogosultságokkal.
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $includeRecorders=$request->query('includeRecorders');
        $customers = Customer::query();
        if ($includeRecorders)
        {
            $customers=$customers->with('customerToRecorders');
        }
        $customers=$customers->get();
        return new CustomerCollection( $customers->append($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, Request $request)
    {
//        todo: Megnézni miért adja vissza a rögzitők mezőtt mikor a kérés nem tartalmazza a includeRecorders-t
        $includeRecorders=$request->query('includeRecorders');
        if ($includeRecorders){
            return new CustomerResource($customer->loadMissing('customerToRecorders'));

        }
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if (Auth::user()->tokenCan('instalelr')){
            $customer->delete();
            return response()->json(['alert' =>['type' => 'success', 'message' => 'A ügyfél törlése sikeres!']]);
        }
        return response()->json(['alert' => ['type' => 'danger', 'message' => 'Ehez a funciohoz nincs jogosultságod!']]);


    }
}
