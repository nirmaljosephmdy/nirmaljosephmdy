<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ArRegion;
class StoreArAddressRequest extends FormRequest { public function authorize() { return true; } public function rules() { return ['name' => 'required|string|max:255', 'region' => ['required', Rule::enum(ArRegion::class)], 'address_line_1' => 'required|string', 'city' => 'required|string', 'postcode' => 'required|string', 'country' => 'required|string', 'contact_email' => 'required|email']; } }