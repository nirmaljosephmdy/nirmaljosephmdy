<?php
namespace App\Http\Controllers\Manufacturer;
use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use App\Http\Requests\Manufacturer\StoreCompanyRequest;
use App\Http\Requests\Manufacturer\UpdateCompanyRequest;
use App\Support\ApiResponse;
class CompanyController extends Controller {
 public function create() { return view('app.company.create'); }
 public function store(StoreCompanyRequest $request, CompanyService $service) { 
    $user = auth()->user();
    if ($user->company) {
        $company = $service->updateCompany($user->company->id, $request->validated());
    } else {
        $company = $service->createCompany($request->validated(), $user->id); 
    }
    return $request->expectsJson() ? ApiResponse::success($company, 'Company created', 201) : redirect()->route('app.dashboard')->with('success', 'Company profile setup complete'); 
 }
 public function edit() { return view('app.company.edit', ['company' => auth()->user()->company]); }
 public function update(UpdateCompanyRequest $request, $id, CompanyService $service) { $company = $service->updateCompany($id, $request->validated()); return $request->expectsJson() ? ApiResponse::success($company, 'Company updated') : redirect()->back()->with('success', 'Company updated'); }
}