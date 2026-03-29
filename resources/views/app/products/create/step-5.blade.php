@extends('layouts.app')
@section('title', 'Compliance Documents | EUVerify')
@section('header', 'New Product')
@section('content')

<div style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748B;">
    <span style="font-weight: 600; color: #0052D1;">NEW PRODUCT</span>
    <span>/</span>
    <span>CREATION WIZARD</span>
</div>

@include('app.products.create._wizard-header')

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start;">

    <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 40px;">
        <h3 style="font-size: 26px; font-weight: 700; color: #00183F; margin: 0 0 8px 0;">Compliance Documents</h3>
        <p style="color: #64748B; font-size: 14px; margin: 0 0 32px 0;">
            Upload required compliance documentation. At least 1 document is required before submission.
        </p>

        @if(session('success'))
            <div style="background: #D1FAE5; border: 1px solid #6EE7B7; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px; color: #065F46; font-size: 13px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px; color: #991B1B; font-size: 13px;">
                {{ session('error') }}
            </div>
        @endif

        {{-- Existing documents --}}
        @if($product->documents->isNotEmpty())
            <div style="margin-bottom: 28px;">
                <p style="font-size: 12px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.06em; margin: 0 0 12px 0;">UPLOADED DOCUMENTS</p>
                @foreach($product->documents as $doc)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; margin-bottom: 8px; background: #F8FAFC;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i data-lucide="file-text" style="width: 18px; height: 18px; color: #0052D1;"></i>
                            <div>
                                <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0;">{{ $doc->title ?? $doc->document_type->name }}</p>
                                <p style="font-size: 11px; color: #94A3B8; margin: 0;">v{{ $doc->version }} · {{ $doc->document_type->name }}</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 12px;
                                background: {{ $doc->status->name === 'Accepted' ? '#D1FAE5' : ($doc->status->name === 'Rejected' ? '#FEE2E2' : '#FEF3C7') }};
                                color: {{ $doc->status->name === 'Accepted' ? '#065F46' : ($doc->status->name === 'Rejected' ? '#991B1B' : '#92400E') }};">
                                {{ strtoupper($doc->status->name) }}
                            </span>
                            <form method="POST" action="{{ route('app.documents.destroy', $doc->id) }}" style="display: inline;" onsubmit="return confirm('Delete this document?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #DC2626; cursor: pointer; padding: 4px;">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Upload form --}}
        <div style="border: 1px solid #E2E8F0; border-radius: 12px; padding: 24px; background: #F8FAFC;">
            <h4 style="font-size: 14px; font-weight: 700; color: #0F172A; margin: 0 0 20px 0;">Upload New Document</h4>
            <form method="POST" action="{{ route('app.products.documents.store', $product->id) }}" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">DOCUMENT TYPE *</label>
                    <select name="document_type" required
                        style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #0F172A; background: #fff; outline: none; appearance: none; background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E\"); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px; box-sizing: border-box;"
                        onchange="document.getElementById('title-field').style.display = this.value == '{{ \App\Enums\DocumentType::Other->value }}' ? 'block' : 'none'">
                        @foreach(\App\Enums\DocumentType::cases() as $type)
                            <option value="{{ $type->value }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="title-field" style="margin-bottom: 16px; display: none;">
                    <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">DOCUMENT TITLE *</label>
                    <input type="text" name="title" placeholder="e.g. Internal Test Certificate 2024"
                           style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #0F172A; outline: none; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">FILE * <span style="color: #94A3B8; font-weight: 400;">PDF, DOCX, JPG, PNG — max 20MB</span></label>
                    <input type="file" name="file" required accept=".pdf,.docx,.jpg,.jpeg,.png"
                           style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; background: #fff; box-sizing: border-box;">
                </div>

                <button type="submit"
                    style="display: flex; align-items: center; gap: 8px; background: #0052D1; color: #fff; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer;">
                    <i data-lucide="upload" style="width: 16px; height: 16px;"></i> Upload Document
                </button>
            </form>
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 32px;">
            <a href="{{ route('app.products.step', ['product' => $product->id, 'step' => 4]) }}"
               style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; border: 1px solid #E2E8F0; border-radius: 8px; color: #374151; text-decoration: none; font-weight: 600; font-size: 14px; background: #fff;">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Back
            </a>
            <a href="{{ route('app.products.step', ['product' => $product->id, 'step' => 6]) }}"
               style="display: flex; align-items: center; gap: 8px; background: #00183F; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;">
                Continue to Review <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
            </a>
        </div>
    </div>

    <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
            <i data-lucide="file-check" style="width: 18px; height: 18px; color: #10B981;"></i>
            <h4 style="font-size: 14px; font-weight: 700; color: #00183F; margin: 0;">Required Documents</h4>
        </div>
        <ul style="font-size: 13px; color: #64748B; line-height: 2; margin: 0; padding-left: 18px;">
            <li>Declaration of Conformity (DoC)</li>
            <li>Technical File</li>
            <li>Risk Assessment</li>
            <li>Test Report</li>
            <li>User Manual</li>
            <li>Certificate (if applicable)</li>
        </ul>
        <p style="font-size: 12px; color: #94A3B8; margin: 12px 0 0 0;">At least 1 document is required to submit.</p>
    </div>
</div>

@endsection
