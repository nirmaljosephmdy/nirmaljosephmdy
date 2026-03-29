@extends('layouts.app')
@section('title', 'Product Classification | EUVerify')
@section('header', 'New Product')
@section('content')

<div style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748B;">
    <span style="font-weight: 600; color: #0052D1;">NEW PRODUCT</span>
    <span>/</span>
    <span>CREATION WIZARD</span>
    <span style="margin-left: auto; display: flex; align-items: center; gap: 6px; color: #10B981; font-size: 13px; font-weight: 500;">
        <i data-lucide="cloud" style="width: 14px; height: 14px;"></i> AUTO-SAVED
    </span>
</div>

@include('app.products.create._wizard-header')

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start;">

    <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 40px;">
        <h3 style="font-size: 26px; font-weight: 700; color: #00183F; margin: 0 0 8px 0;">Classification</h3>
        <p style="color: #64748B; font-size: 14px; margin: 0 0 32px 0;">
            Select the product category and sub-category. This determines which compliance frameworks apply.
        </p>

        @if($errors->any())
            <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px;">
                @foreach($errors->all() as $err)
                    <p style="color: #DC2626; font-size: 13px; margin: 0;">{{ $err }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('app.products.step1.save', $product->id) }}">
            @csrf

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">PRODUCT CATEGORY *</label>
                <select name="category_id" id="category-select" required
                    style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #0F172A; background: #fff; outline: none; appearance: none; background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E\"); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px;">
                    <option value="">Select a category...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 40px;">
                <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">SUB-CATEGORY *</label>
                <select name="product_category_id" id="sub-select" required
                    style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #0F172A; background: #fff; outline: none; appearance: none; background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E\"); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px;">
                    <option value="">Select a sub-category...</option>
                    @foreach($categories as $cat)
                        @foreach($cat->productCategories as $sub)
                            <option value="{{ $sub->id }}"
                                data-parent="{{ $cat->id }}"
                                {{ old('product_category_id', $product->product_category_id) == $sub->id ? 'selected' : '' }}
                                style="display: none;">
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
                @error('product_category_id') <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit"
                    style="display: flex; align-items: center; gap: 8px; background: #00183F; color: #fff; padding: 12px 28px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer;">
                    Save &amp; Continue <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- Right info panel --}}
    <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
            <i data-lucide="lightbulb" style="width: 18px; height: 18px; color: #F59E0B;"></i>
            <h4 style="font-size: 14px; font-weight: 700; color: #00183F; margin: 0;">Why Classification Matters</h4>
        </div>
        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">
            The product category determines which EU compliance directives and standards apply. Selecting the wrong category may result in the wrong documentation requirements during the review stage.
        </p>
    </div>
</div>

<script>
const categories = @json($categories->keyBy('id')->map(fn($c) => $c->productCategories->values()));

function filterSubs(selectedCatId) {
    const subSelect = document.getElementById('sub-select');
    const opts = subSelect.querySelectorAll('option[data-parent]');
    opts.forEach(o => {
        o.style.display = o.dataset.parent == selectedCatId ? '' : 'none';
    });
    subSelect.value = '';
}

document.getElementById('category-select').addEventListener('change', function() {
    filterSubs(this.value);
});

// Init on load
filterSubs(document.getElementById('category-select').value);
</script>

@endsection
