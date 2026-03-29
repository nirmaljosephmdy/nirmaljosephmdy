<?php
namespace App\Http\Requests\Manufacturer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\DocumentType;
class StoreProductDocumentRequest extends FormRequest { public function authorize() { return true; } public function rules() { return ['document_type' => ['required', Rule::enum(DocumentType::class)], 'file' => 'required|file|mimes:pdf,docx,jpg,png|max:20480', 'title' => 'required_if:document_type,' . DocumentType::Other->value . '|nullable|string']; } }