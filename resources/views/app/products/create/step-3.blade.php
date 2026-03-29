@extends('layouts.app')
@section('title', 'Product Images | EUVerify')
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
        <h3 style="font-size: 26px; font-weight: 700; color: #00183F; margin: 0 0 8px 0;">Product Images</h3>
        <p style="color: #64748B; font-size: 14px; margin: 0 0 32px 0;">
            Upload 1–5 product images. The first image will be set as the primary image shown in the registry.
        </p>

        @if($errors->any())
            <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px;">
                @foreach($errors->all() as $err)
                    <p style="color: #DC2626; font-size: 13px; margin: 0;">{{ $err }}</p>
                @endforeach
            </div>
        @endif

        {{-- Existing images --}}
        @if($product->images->isNotEmpty())
            <div style="margin-bottom: 24px;">
                <p style="font-size: 12px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.06em; margin: 0 0 12px 0;">CURRENT IMAGES</p>
                <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                    @foreach($product->images as $img)
                        <div style="position: relative;">
                            <img src="{{ asset('storage/' . $img->file_path) }}" alt="Product image"
                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid {{ $img->is_primary ? '#0052D1' : '#E2E8F0' }};">
                            @if($img->is_primary)
                                <span style="position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); background: #0052D1; color: #fff; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 10px; white-space: nowrap;">PRIMARY</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <p style="font-size: 12px; color: #94A3B8; margin: 16px 0 0 0;">Uploading new images will replace the existing ones.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('app.products.step3.save', $product->id) }}" enctype="multipart/form-data">
            @csrf

            <label for="images" style="display: block; cursor: pointer;">
                <div id="dropzone" style="border: 2px dashed #CBD5E1; border-radius: 12px; padding: 48px 24px; text-align: center; background: #F8FAFC; margin-bottom: 24px; transition: border-color 0.2s;"
                     ondragover="event.preventDefault(); this.style.borderColor='#0052D1'"
                     ondragleave="this.style.borderColor='#CBD5E1'"
                     ondrop="handleDrop(event)">
                    <i data-lucide="image-plus" style="width: 40px; height: 40px; color: #94A3B8; margin-bottom: 16px;"></i>
                    <p style="font-weight: 600; color: #374151; margin: 0 0 4px 0; font-size: 15px;">Drag &amp; Drop Images Here</p>
                    <p style="color: #94A3B8; font-size: 13px; margin: 0 0 16px 0;">or click to browse — JPG, PNG, WebP — max 5MB each</p>
                    <span style="background: #00183F; color: #fff; padding: 8px 20px; border-radius: 6px; font-size: 13px; font-weight: 600;">Browse Files</span>
                </div>
            </label>
            <input type="file" id="images" name="images[]" multiple accept="image/jpeg,image/png,image/webp" style="display: none;"
                   onchange="previewImages(this)">

            <div id="preview-grid" style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px;"></div>

            <div style="display: flex; justify-content: space-between;">
                <a href="{{ route('app.products.step', ['product' => $product->id, 'step' => 2]) }}"
                   style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; border: 1px solid #E2E8F0; border-radius: 8px; color: #374151; text-decoration: none; font-weight: 600; font-size: 14px; background: #fff;">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Back
                </a>
                <button type="submit" id="submit-btn"
                    style="display: flex; align-items: center; gap: 8px; background: #00183F; color: #fff; padding: 12px 28px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer;">
                    Save &amp; Continue <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
                </button>
            </div>
        </form>
    </div>

    <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
            <i data-lucide="info" style="width: 18px; height: 18px; color: #0052D1;"></i>
            <h4 style="font-size: 14px; font-weight: 700; color: #00183F; margin: 0;">Image Guidelines</h4>
        </div>
        <ul style="font-size: 13px; color: #64748B; line-height: 1.8; margin: 0; padding-left: 18px;">
            <li>Minimum 400×400 pixels</li>
            <li>Max 5MB per image</li>
            <li>1 to 5 images allowed</li>
            <li>First image becomes the primary</li>
            <li>White or neutral background preferred</li>
        </ul>
    </div>
</div>

<script>
function previewImages(input) {
    const grid = document.getElementById('preview-grid');
    grid.innerHTML = '';
    Array.from(input.files).forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const wrap = document.createElement('div');
            wrap.style.cssText = 'position: relative; width: 80px; height: 80px;';
            wrap.innerHTML = `
                <img src="${e.target.result}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid ${i === 0 ? '#0052D1' : '#E2E8F0'};">
                ${i === 0 ? '<span style="position:absolute;bottom:-8px;left:50%;transform:translateX(-50%);background:#0052D1;color:#fff;font-size:9px;font-weight:700;padding:2px 6px;border-radius:10px;white-space:nowrap;">PRIMARY</span>' : ''}
            `;
            grid.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });
}

function handleDrop(event) {
    event.preventDefault();
    event.currentTarget.style.borderColor = '#CBD5E1';
    const input = document.getElementById('images');
    input.files = event.dataTransfer.files;
    previewImages(input);
}
</script>

@endsection
