<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArAddress;
use App\Services\ArAddressService;
use App\Http\Requests\Admin\StoreArAddressRequest;
use App\Http\Requests\Admin\UpdateArAddressRequest;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class ArAddressController extends Controller {

    public function index(Request $request, ArAddressService $service) 
    { 
        $filters = $request->only(['search', 'region', 'status']);
        $arAddresses = $service->getPaginated($filters, 25);
        $stats = $service->getStats();

        return view('admin.ar-addresses.index', compact('arAddresses', 'filters', 'stats')); 
    }

    public function create()
    {
        $arAddress = new ArAddress();
        return view('admin.ar-addresses.form', compact('arAddress'));
    }

    public function store(StoreArAddressRequest $request, ArAddressService $service) 
    { 
        $ar = $service->createAr($request->validated()); 
        
        if ($request->expectsJson()) {
            return ApiResponse::success($ar);
        }

        return redirect()->route('admin.ar-addresses.index')->with('success', 'AR Address created successfully.'); 
    }

    public function edit($id, ArAddressService $service)
    {
        // the service doesn't have a direct getById, so we use Eloquent here mostly or we can add find to repo
        $arAddress = ArAddress::findOrFail($id);
        return view('admin.ar-addresses.form', compact('arAddress'));
    }

    public function update(UpdateArAddressRequest $request, $id, ArAddressService $service) 
    { 
        $ar = $service->updateAr($id, $request->validated()); 
        
        if ($request->expectsJson()) {
            return ApiResponse::success($ar);
        }
        
        return redirect()->route('admin.ar-addresses.index')->with('success', 'AR Address updated successfully.'); 
    }

    public function destroy($id, ArAddressService $service) 
    { 
        $service->deleteAr($id); 
        
        if (request()->expectsJson()) {
            return ApiResponse::success(null);
        }
        
        return redirect()->route('admin.ar-addresses.index')->with('success', 'AR Address deleted successfully.'); 
    }
}