@extends('layouts.app')
@section('title', 'Create Brand | EUVerify')
@section('header', 'Brands')
@section('content')

<div style="margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748B; margin-bottom: 16px;">
        <a href="{{ route('app.brands.index') }}" style="color: #64748B; text-decoration: none;">Brands</a>
        <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
        <span style="color: #0052D1; font-weight: 500;">Create Brand</span>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 28px; font-weight: 700; color: #00183F; margin: 0;">Create Brand Identity</h2>
            <p style="color: #64748B; margin: 4px 0 0 0; font-size: 14px;">Configure your brand assets for compliance verification.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('app.brands.index') }}"
               style="padding: 10px 20px; border: 1px solid #E2E8F0; border-radius: 8px; color: #374151; text-decoration: none; font-weight: 600; font-size: 14px; background: #fff;">
                Cancel
            </a>
            <button type="submit" form="brand-form"
                style="padding: 10px 24px; background: #00183F; color: #fff; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer;">
                Create Brand
            </button>
        </div>
    </div>
</div>

<form id="brand-form" method="POST" action="{{ route('app.brands.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start;">

        {{-- Left: Main Fields --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 32px;">

            <div style="margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151;">BRAND NAME</label>
                    @error('name')
                        <span style="font-size: 12px; color: #DC2626; font-weight: 500;">Validation Error</span>
                    @enderror
                </div>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="e.g. Lumina Essentials"
                       style="width: 100%; padding: 12px 16px; border: 1px solid {{ $errors->has('name') ? '#DC2626' : '#E2E8F0' }}; border-radius: 8px; font-size: 14px; color: #0F172A; outline: none; box-sizing: border-box;">
                @error('name')
                    <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0; display: flex; align-items: center; gap: 4px;">
                        <i data-lucide="alert-circle" style="width: 14px; height: 14px;"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">WEBSITE URL</label>
                <div style="display: flex; border: 1px solid #E2E8F0; border-radius: 8px; overflow: hidden;">
                    <span style="padding: 12px 14px; background: #F8FAFC; color: #94A3B8; font-size: 14px; border-right: 1px solid #E2E8F0; white-space: nowrap;">https://</span>
                    <input type="text" name="website" value="{{ old('website') ? ltrim(old('website'), 'https://') : '' }}"
                           id="website-input"
                           placeholder="your-brand.eu"
                           style="flex: 1; padding: 12px 16px; border: none; font-size: 14px; color: #0F172A; outline: none;">
                </div>
                @error('website')
                    <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151;">BRAND DESCRIPTION</label>
                    <span id="char-count" style="font-size: 12px; color: #94A3B8;">0 / 500 characters</span>
                </div>
                <textarea name="description" id="description" rows="5"
                          oninput="document.getElementById('char-count').textContent = this.value.length + ' / 500 characters'"
                          style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #0F172A; outline: none; resize: vertical; box-sizing: border-box; font-family: inherit;">{{ old('description') }}</textarea>
                @error('description')
                    <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Right: Logo + Sidebar --}}
        <div style="display: flex; flex-direction: column; gap: 16px;">

            {{-- Logo Upload --}}
            <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
                <h4 style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin: 0 0 16px 0;">BRAND LOGO</h4>
                <label for="logo" style="display: block; cursor: pointer;">
                    <div style="border: 2px dashed #CBD5E1; border-radius: 12px; padding: 40px 20px; text-align: center; background: #F8FAFC; transition: border-color 0.2s;"
                         id="logo-dropzone"
                         ondragover="event.preventDefault(); this.style.borderColor='#0052D1'"
                         ondragleave="this.style.borderColor='#CBD5E1'">
                        <div id="logo-preview-wrap">
                            <i data-lucide="upload-cloud" style="width: 32px; height: 32px; color: #94A3B8; margin-bottom: 12px;"></i>
                            <p style="font-weight: 600; color: #374151; margin: 0 0 4px 0; font-size: 14px;">Drag &amp; Drop Logo</p>
                            <p style="color: #94A3B8; font-size: 12px; margin: 0;">SVG, PNG or JPG (min. 400×400px)</p>
                        </div>
                        <img id="logo-preview" src="" style="display: none; width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                    </div>
                </label>
                <input type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/webp" class="sr-only" style="display: none;"
                       onchange="previewLogo(this)">
                @error('logo')
                    <p style="color: #DC2626; font-size: 13px; margin: 8px 0 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Active Status --}}
            <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0;">ACTIVE STATUS</p>
                        <p style="font-size: 12px; color: #64748B; margin: 2px 0 0 0;">Control brand visibility in portal</p>
                    </div>
                    <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked
                               style="opacity: 0; width: 0; height: 0; position: absolute;"
                               onchange="this.previousElementSibling.value = this.checked ? '1' : '0'; this.nextElementSibling.style.background = this.checked ? '#0052D1' : '#CBD5E1'">
                        <span style="position: absolute; inset: 0; background: #0052D1; border-radius: 24px; transition: 0.3s;"></span>
                        <span style="position: absolute; left: 2px; top: 2px; width: 20px; height: 20px; background: #fff; border-radius: 50%; transition: 0.3s; transform: translateX(20px);"></span>
                    </label>
                </div>
            </div>

            {{-- Compliance Tip --}}
            <div style="background: #00183F; border-radius: 12px; padding: 20px; color: #fff;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <i data-lucide="lightbulb" style="width: 18px; height: 18px; color: #34D399;"></i>
                    <span style="font-size: 13px; font-weight: 700;">Compliance Tip</span>
                </div>
                <p style="font-size: 13px; color: #94A3B8; margin: 0; line-height: 1.6;">
                    Ensuring your Brand Logo is high-resolution SVG will speed up the automatic AR address verification process by 40%.
                </p>
            </div>
        </div>
    </div>
</form>

<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('logo-preview');
            const wrap    = document.getElementById('logo-preview-wrap');
            preview.src   = e.target.result;
            preview.style.display = 'block';
            wrap.style.display    = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Prepend https:// to website on form submit
document.getElementById('brand-form').addEventListener('submit', function() {
    const websiteInput = document.getElementById('website-input');
    if (websiteInput.value && !websiteInput.value.startsWith('http')) {
        websiteInput.name = '';
        const hidden = document.createElement('input');
        hidden.type  = 'hidden';
        hidden.name  = 'website';
        hidden.value = 'https://' + websiteInput.value;
        this.appendChild(hidden);
    }
});
</script>

@endsection
