@extends('layouts.app')

@section('title', $arAddress->exists ? 'Edit AR Address' : 'Create AR Address')

@section('content')
<div class="ar-page-content" x-data="{ 
    isActive: {{ old('is_active', $arAddress->is_active ?? true) ? 'true' : 'false' }} 
}">
    
    <!-- Breadcrumbs & Header -->
    <div style="font-size: 11px; font-weight: 800; color: #64748B; letter-spacing: 0.05em; margin-bottom: 16px; text-transform: uppercase;">
        ADMIN <i data-lucide="chevron-right" style="width: 12px; display: inline-block; vertical-align: middle;"></i> 
        AR ADDRESSES <i data-lucide="chevron-right" style="width: 12px; display: inline-block; vertical-align: middle;"></i> 
        <span style="color: #0F172A;">{{ $arAddress->exists ? 'EDIT ENTRY' : 'CREATE NEW ENTRY' }}</span>
    </div>

    <div class="ar-page-header" style="margin-bottom: 40px;">
        <div>
            <h1>{{ $arAddress->exists ? 'Edit AR Address' : 'Create AR Address' }}</h1>
            <p>Register a new Authorized Representative (AR) physical address to the compliance registry. Ensure all details match official documentation.</p>
        </div>
        @if(!$arAddress->exists)
        <div style="background: #F1F5F9; padding: 12px 24px; border-radius: 999px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <span style="font-size: 9px; font-weight: 800; color: #64748B; letter-spacing: 0.05em;">STATUS PREVIEW</span>
            <span style="font-size: 11px; font-weight: 700; color: #0052D1; display: flex; align-items: center; gap: 4px;">
                <div style="width: 6px; height: 6px; background: #0052D1; border-radius: 50%;"></div>
                Draft Mode
            </span>
        </div>
        @endif
    </div>

    <form action="{{ $arAddress->exists ? route('admin.ar-addresses.update', $arAddress->id) : route('admin.ar-addresses.store') }}" method="POST">
        @csrf
        @if($arAddress->exists)
            @method('PUT')
        @endif

        <div class="ar-form-layout">
            <!-- Left Panel: Form -->
            <div class="ar-form-area">
                
                <!-- Entity ID -->
                <div class="form-section-title">Entity Identification</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">AR Entity Name <span class="req">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $arAddress->name) }}" placeholder="e.g. European Compliance Partners" required>
                        @error('name')<div class="invalid-feedback"><i data-lucide="alert-circle" style="width: 14px;"></i> {{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Region <span class="req">*</span></label>
                        <select name="region" class="modern-select @error('region') is-invalid @enderror" style="width: 100%; border: 1px solid transparent; background: #F8FAFC;" required>
                            <option value="1" {{ old('region', $arAddress->region?->value ?? '') == '1' ? 'selected' : '' }}>European Union (EU)</option>
                            <option value="2" {{ old('region', $arAddress->region?->value ?? '') == '2' ? 'selected' : '' }}>United Kingdom (UK)</option>
                        </select>
                        @error('region')<div class="invalid-feedback"><i data-lucide="alert-circle" style="width: 14px;"></i> {{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Physical Address -->
                <div class="form-section-title">Physical Address</div>
                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Address Line 1 <span class="req">*</span></label>
                        <input type="text" name="address_line_1" class="form-control @error('address_line_1') is-invalid @enderror" value="{{ old('address_line_1', $arAddress->address_line_1) }}" placeholder="Street name and number" required>
                        @error('address_line_1')<div class="invalid-feedback"><i data-lucide="alert-circle" style="width: 14px;"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">City <span class="req">*</span></label>
                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $arAddress->city) }}" placeholder="e.g. Berlin" required>
                        @error('city')<div class="invalid-feedback"><i data-lucide="alert-circle" style="width: 14px;"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Postcode <span class="req">*</span></label>
                        <input type="text" name="postcode" class="form-control @error('postcode') is-invalid @enderror" value="{{ old('postcode', $arAddress->postcode) }}" placeholder="e.g. 10115" required>
                        @error('postcode')<div class="invalid-feedback"><i data-lucide="alert-circle" style="width: 14px;"></i> {{ $message }}</div>@enderror
                    </div>

                    <!-- Requested: Basic Dropdown for Country -->
                    <div class="form-group full">
                        <label class="form-label">Country <span class="req">*</span></label>
                        <select name="country" class="modern-select @error('country') is-invalid @enderror" style="width: 100%; border: 1px solid transparent; background: #F8FAFC;" required>
                            <option value="">Select Country</option>
                            <optgroup label="EU Members">
                                <option value="Germany" {{ old('country', $arAddress->country) == 'Germany' ? 'selected' : '' }}>Germany</option>
                                <option value="France" {{ old('country', $arAddress->country) == 'France' ? 'selected' : '' }}>France</option>
                                <option value="Spain" {{ old('country', $arAddress->country) == 'Spain' ? 'selected' : '' }}>Spain</option>
                                <option value="Italy" {{ old('country', $arAddress->country) == 'Italy' ? 'selected' : '' }}>Italy</option>
                                <option value="Netherlands" {{ old('country', $arAddress->country) == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                                <option value="Sweden" {{ old('country', $arAddress->country) == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                            </optgroup>
                            <optgroup label="UK & Others">
                                <option value="United Kingdom" {{ old('country', $arAddress->country) == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                            </optgroup>
                        </select>
                        @error('country')<div class="invalid-feedback"><i data-lucide="alert-circle" style="width: 14px;"></i> {{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Contact Details -->
                <div class="form-section-title">Contact Details</div>
                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Contact Email <span class="req">*</span></label>
                        <div style="position: relative;">
                            <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" style="width: 100%; padding-right: 40px;" value="{{ old('contact_email', $arAddress->contact_email) }}" placeholder="e.g. compliance@domain.eu" required>
                            @error('contact_email')
                                <i data-lucide="alert-circle" style="position: absolute; right: 16px; top: 14px; color: #EF4444; width: 18px;"></i>
                            @enderror
                        </div>
                        @error('contact_email')
                            <div class="invalid-feedback" style="margin-top: 8px;">
                                <i data-lucide="info" style="width: 14px;"></i> Please enter a valid business email format
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Status Toggle -->
                <div class="status-toggle-card">
                    <div class="status-t-info">
                        <div class="t-icon" :class="!isActive ? 'inactive' : ''">
                            <i data-lucide="zap" style="width: 20px;"></i>
                        </div>
                        <div class="t-text">
                            <h4>Active Status</h4>
                            <p>Enable this address for current compliance chains</p>
                        </div>
                    </div>
                    <div class="custom-switch" :class="isActive ? '' : 'off'" @click="isActive = !isActive">
                        <div class="sw-knob"></div>
                        <input type="hidden" name="is_active" x-bind:value="isActive ? 1 : 0">
                    </div>
                </div>

                <!-- Form Buttons -->
                <div style="margin-top: 40px; display: flex; gap: 16px;">
                    <button type="submit" class="btn-primary" style="padding: 14px 32px;">Save AR Address</button>
                    <a href="{{ route('admin.ar-addresses.index') }}" class="btn-default" style="padding: 14px 32px;">Cancel</a>
                </div>
            </div>

            <!-- Right Panel: Guidance -->
            <div class="ar-guidance-panel">
                
                <div class="guidance-box">
                    <div class="guidance-header">
                        <i data-lucide="shield" style="width: 20px; color: #0052D1;"></i>
                        Compliance Requirement
                    </div>
                    <p>Under EU Regulation 2019/1020, economic operators must designate an authorized representative within the EU to ensure product safety and compliance documentation is available.</p>
                    
                    <ul class="guidance-list">
                        <li><i data-lucide="check-circle-2" class="g-check" style="width: 16px;"></i> Must be a physical address (no P.O. boxes).</li>
                        <li><i data-lucide="check-circle-2" class="g-check" style="width: 16px;"></i> Email must be monitored 24/7 for safety alerts.</li>
                        <li><i data-lucide="check-circle-2" class="g-check" style="width: 16px;"></i> Legal entity name must be precise for audit trails.</li>
                    </ul>
                </div>

                <!-- Requested CSS Mocked Coverage Map Card -->
                <div class="map-coverage-card">
                    <div class="map-bg-pattern"></div>
                    <i data-lucide="map" class="map-icon"></i>
                    
                    <div class="map-content">
                        <div class="map-label">
                            <i data-lucide="globe-2" style="width: 14px;"></i> REGIONAL COVERAGE
                        </div>
                        <h3>European Union Node</h3>
                        <p>Select regions will be verified against VIES automatically.</p>
                    </div>
                </div>

                <!-- Skeleton Registrations -->
                <div style="margin-top: 16px; padding: 0 16px;">
                    <div style="font-size: 11px; font-weight: 800; color: #0F172A; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 24px;">Recent Registrations</div>
                    
                    <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                        <div style="width: 32px; height: 32px; background: #F1F5F9; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="building" style="width: 16px; color: #94A3B8;"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="height: 12px; width: 60%; background: #E2E8F0; border-radius: 4px; margin-bottom: 8px;"></div>
                            <div style="height: 8px; width: 40%; background: #F1F5F9; border-radius: 4px;"></div>
                        </div>
                        <div style="font-size: 11px; color: #94A3B8;">2h ago</div>
                    </div>

                    <div style="display: flex; gap: 16px;">
                        <div style="width: 32px; height: 32px; background: #F1F5F9; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="building" style="width: 16px; color: #94A3B8;"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="height: 12px; width: 80%; background: #E2E8F0; border-radius: 4px; margin-bottom: 8px;"></div>
                            <div style="height: 8px; width: 30%; background: #F1F5F9; border-radius: 4px;"></div>
                        </div>
                        <div style="font-size: 11px; color: #94A3B8;">5h ago</div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
