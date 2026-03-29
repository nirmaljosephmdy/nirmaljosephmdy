@extends('layouts.setup')

@section('title', 'Identity Setup | EUVerify')

@section('content')
<style>
    /* Styling to match the design */
    .setup-container {
        max-width: 1100px;
        width: 100%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .alert-banner {
        background-color: #EEF2FF;
        border-left: 4px solid #4F46E5;
        border-radius: 8px;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        color: #3730A3;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .alert-icon {
        background: #4F46E5;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }

    .setup-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 40px;
        background: #FFFFFF;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.04);
    }

    /* Left Pane */
    .setup-left {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .step-label {
        color: #4F46E5;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .setup-left h1 {
        font-size: 36px;
        font-weight: 800;
        color: #0F172A;
        margin: 0;
        line-height: 1.1;
    }

    .setup-left p {
        font-size: 15px;
        color: #475569;
        line-height: 1.6;
        margin: 0;
    }

    .feature-image-box {
        margin-top: auto;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        height: 240px;
        background: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=600&auto=format&fit=crop') center/cover;
    }

    .feature-image-box::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(0,24,63,0.9), transparent);
    }

    .feature-quote {
        position: absolute;
        bottom: 24px;
        left: 24px;
        right: 24px;
        color: white;
        font-size: 14px;
        font-style: italic;
        font-weight: 500;
        line-height: 1.5;
        margin: 0;
    }

    /* Right Pane / Form */
    .setup-right {
        background: #FFFFFF;
    }

    .section-title {
        font-size: 11px;
        font-weight: 800;
        color: #475569;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 24px;
    }

    .logo-upload-box {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 32px;
    }

    .upload-area {
        width: 80px;
        height: 80px;
        background: #E0E7FF;
        border: 2px dashed #A5B4FC;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #6366F1;
        cursor: pointer;
        transition: all 0.2s;
    }

    .upload-area:hover {
        background: #C7D2FE;
    }

    .upload-area span {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.05em;
    }

    .upload-text h4 {
        margin: 0 0 4px 0;
        font-size: 14px;
        font-weight: 700;
        color: #0F172A;
    }

    .upload-text p {
        margin: 0;
        font-size: 12px;
        color: #64748B;
    }

    .browse-link {
        color: #4F46E5;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        margin-top: 8px;
        display: inline-block;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .form-group-full {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 13px;
        font-weight: 700;
        color: #0F172A;
        display: block;
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #EF4444;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        background: #F8FAFC;
        font-size: 14px;
        color: #0F172A;
        font-family: inherit;
        transition: border-color 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: #4F46E5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-input::placeholder {
        color: #94A3B8;
    }

    .form-input.has-error {
        border-color: #EF4444;
        background: #FEF2F2;
    }

    .error-msg {
        color: #EF4444;
        font-size: 12px;
        font-weight: 500;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748B'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
        cursor: pointer;
    }

    .website-prefix {
        display: flex;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        overflow: hidden;
    }

    .website-prefix span {
        background: #F1F5F9;
        padding: 12px 16px;
        color: #64748B;
        font-size: 14px;
        font-weight: 500;
        border-right: 1px solid #E2E8F0;
    }

    .website-prefix input {
        border: none;
        border-radius: 0;
        background: #F8FAFC;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 24px;
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid #E2E8F0;
    }

    .btn-reset {
        background: none;
        border: none;
        color: #475569;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-save {
        background: #00183F;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }

    .btn-save:hover {
        background: #002866;
    }
</style>

<div class="setup-container">
    <div class="alert-banner">
        <div class="alert-icon">i</div>
        Complete your company profile to access all features
    </div>

    <form action="{{ route('app.company.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="setup-grid">
            <!-- Left Pane Info -->
            <div class="setup-left">
                <div>
                    <div class="step-label">STEP 1 OF 1</div>
                    <h1>Identity Setup</h1>
                </div>
                <p>Establish your legal entity on the EUVerify network. This information is used for regulatory compliance and product certification authenticity.</p>
                
                <div class="feature-image-box">
                    <p class="feature-quote">"Accuracy in documentation is the foundation of market trust."</p>
                </div>
            </div>

            <!-- Right Pane Form -->
            <div class="setup-right">
                <div class="section-title">CORPORATE IDENTITY</div>

                <div class="logo-upload-box">
                    <label class="upload-area" for="logo-upload">
                        <i data-lucide="camera" style="width: 20px; height: 20px;"></i>
                        <span>UPLOAD</span>
                    </label>
                    <input type="file" id="logo-upload" name="logo" accept="image/jpeg, image/png, image/webp" style="display: none;">
                    
                    <div class="upload-text">
                        <h4>Company Logo</h4>
                        <p>Drag and drop JPG, PNG or WEBP. Max size 2MB.</p>
                        <a href="#" class="browse-link" onclick="document.getElementById('logo-upload').click(); return false;">Browse files</a>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group-full">
                        <label class="form-label">Company Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-input @error('name') has-error @enderror" placeholder="e.g. Acme Manufacturing Ltd" value="{{ old('name') }}">
                        @error('name')
                            <div class="error-msg"><i data-lucide="alert-circle" style="width: 14px; height: 14px;"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Registration Number</label>
                        <input type="text" name="registration_number" class="form-input @error('registration_number') has-error @enderror" placeholder="VAT / TAX ID" value="{{ old('registration_number') }}">
                    </div>

                    <div>
                        <label class="form-label">Country</label>
                        <select name="country" class="form-input form-select @error('country') has-error @enderror">
                            <option value="" disabled selected>Select Country</option>
                            <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                            <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                            <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                            <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                            <!-- Add more as needed -->
                        </select>
                    </div>

                    <div class="form-group-full">
                        <label class="form-label">Registered Address</label>
                        <input type="text" name="address" class="form-input @error('address') has-error @enderror" placeholder="Street name and number" value="{{ old('address') }}">
                    </div>

                    <div>
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-input @error('city') has-error @enderror" value="{{ old('city') }}">
                    </div>

                    <div>
                        <label class="form-label">Postcode</label>
                        <input type="text" name="postcode" class="form-input @error('postcode') has-error @enderror" value="{{ old('postcode') }}">
                    </div>

                    <div class="form-group-full">
                        <label class="form-label">Website <span style="font-weight: normal; color: #64748B;">(Optional)</span></label>
                        <div class="website-prefix">
                            <span>https://</span>
                            <input type="text" name="website" class="form-input" placeholder="www.company.com" value="{{ old('website') }}">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="reset" class="btn-reset">Reset Form</button>
                    <button type="submit" class="btn-save">
                        Save & Continue <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection