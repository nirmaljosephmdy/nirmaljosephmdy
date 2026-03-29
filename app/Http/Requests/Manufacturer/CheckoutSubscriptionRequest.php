<?php
namespace App\Http\Requests\Manufacturer;
use Illuminate\Foundation\Http\FormRequest;
class CheckoutSubscriptionRequest extends FormRequest { public function authorize() { return true; } public function rules() { return ['plan_id' => 'required|exists:subscription_plans,id']; } }