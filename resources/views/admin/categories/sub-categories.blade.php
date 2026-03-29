@extends('layouts.app')

@section('title', $category->name . ' - Sub-Categories')

@section('content')
@php
    $subCategoriesJson = collect($subCategories->items())->map(function($sc) use ($category) {
        return [
            'id' => $sc->id,
            'name' => $sc->name,
            'description' => $sc->description,
            'is_active' => $sc->is_active,
            'created_at_fmt' => $sc->created_at->format('M d, Y'),
            'created_time_fmt' => $sc->created_at->format('g:i A'),
            'update_url' => route('admin.categories.sub-categories.update', [$category->id, $sc->id]),
            'delete_url' => route('admin.categories.sub-categories.destroy', [$category->id, $sc->id])
        ];
    })->values();
@endphp

<div class="category-page-content" x-data="{ 
        subCats: {{ Js::from($subCategoriesJson) }},
        selectedSub: null,
        
        // Modals
        showCreateModal: false,
        showEditModal: false,
        showDeleteModal: false,
        
        openEditModal(sub) {
            this.selectedSub = sub;
            this.showEditModal = true;
        },
        openDeleteModal(sub) {
            this.selectedSub = sub;
            this.showDeleteModal = true;
        }
    }" x-init="setTimeout(() => { if(typeof lucide !== 'undefined') lucide.createIcons(); }, 100)">

    <div style="font-size: 11px; font-weight: 800; color: #64748B; letter-spacing: 0.05em; margin-bottom: 16px; text-transform: uppercase;">
        <a href="{{ route('admin.categories.index') }}" style="color: #0052D1; text-decoration: none;">CATEGORIES</a> 
        <i data-lucide="chevron-right" style="width: 12px; display: inline-block; vertical-align: middle;"></i> 
        <span style="color: #0F172A;">{{ strtoupper($category->name) }}</span>
    </div>

    <div class="category-page-header">
        <div>
            <h1>{{ $category->name }} Sub-Categories</h1>
            <p>Manage nested structures to narrow down regulatory compliance definitions.</p>
        </div>
        <div style="display: flex; gap: 16px; align-items: center;">
            <button @click="showCreateModal = true" class="btn-primary">
                <i data-lucide="plus" style="width: 16px;"></i> Add Sub-Category
            </button>
        </div>
    </div>

    <div class="category-layout">
        <!-- Main List -->
        <div class="category-main-list">
            <form action="{{ route('admin.categories.sub-categories.index', $category->id) }}" method="GET" class="category-filter-bar">
                <input type="text" name="search" class="search-input-cat" placeholder="Filter sub-categories..." value="{{ request('search') }}" onkeyup="clearTimeout(window.searchTimer); window.searchTimer = setTimeout(() => { this.form.submit(); }, 500);" {{ request()->has('search') ? 'autofocus onfocus="let v=this.value;this.value=\'\';this.value=v;"' : '' }}>
                
                <div style="display: flex; gap: 16px; align-items: center;">
                    <select name="status" class="modern-select" onchange="this.form.submit()" style="padding-top: 6px; padding-bottom: 6px;">
                        <option value="">All Statuses</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    
                    <span style="font-size: 11px; font-weight: 800; color: #0F172A; text-transform: uppercase; letter-spacing: 0.05em;">
                        Displaying {{ $subCategories->firstItem() ?? 0 }}-{{ $subCategories->lastItem() ?? 0 }} of {{ $subCategories->total() }}
                    </span>
                </div>
            </form>

            <div class="category-row-list">
                <table class="cat-table">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Name</th>
                            <th style="width: 35%;">Description</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 15%;">Created At</th>
                            <th style="width: 10%; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="cat in subCats" :key="cat.id">
                            <tr>
                                <td>
                                    <div class="cat-name-group">
                                        <div class="cat-icon-box" style="background: #E0E7FF; color: #4F46E5;">
                                            <i data-lucide="layout-grid" style="width: 20px;"></i>
                                        </div>
                                        <div>
                                            <div class="cat-title" x-text="cat.name"></div>
                                            <div class="cat-subtitle" x-text="'Nested inside {{ current(explode(' ', $category->name)) }}'"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="cat-desc" x-text="cat.description || 'No description provided.'"></span>
                                </td>
                                <td>
                                    <span class="badge-status active" x-show="cat.is_active">ACTIVE</span>
                                    <span class="badge-status inactive" x-show="!cat.is_active">INACTIVE</span>
                                </td>
                                <td>
                                    <div class="cat-date" x-text="cat.created_at_fmt"></div>
                                    <div style="font-size: 10px; color: #94A3B8; margin-top:2px;" x-text="cat.created_time_fmt"></div>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <button @click="openEditModal(cat)" style="background: transparent; border: none; padding: 6px; cursor: pointer; color: #64748B; border-radius: 6px;" title="Edit Sub-Category" onmouseover="this.style.background='#F1F5F9'; this.style.color='#0052D1';" onmouseout="this.style.background='transparent'; this.style.color='#64748B';">
                                            <i data-lucide="edit-3" style="width: 18px;"></i>
                                        </button>
                                        <button @click="openDeleteModal(cat)" style="background: transparent; border: none; padding: 6px; cursor: pointer; color: #EF4444; border-radius: 6px;" title="Delete Sub-Category" onmouseover="this.style.background='#FEF2F2'; this.style.color='#DC2626';" onmouseout="this.style.background='transparent'; this.style.color='#EF4444';">
                                            <i data-lucide="trash-2" style="width: 18px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        @if($subCategories->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 48px; color: #64748B;">No sub-categories found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            @if($subCategories->hasPages())
                <div style="margin-top: 16px;">
                    {{ $subCategories->links('pagination::simple-tailwind') }}
                </div>
            @endif
        </div>
    </div>


    <!-- ==================== MODALS ==================== -->
    
    <!-- Create Modal -->
    <div x-show="showCreateModal" style="display: none;" class="modal-overlay">
        <div class="modal-content cat-modal-dialog" @click.away="showCreateModal = false">
            <div class="cat-modal-header">
                <h3>Add Sub-Category</h3>
                <button @click="showCreateModal = false" class="cat-modal-close"><i data-lucide="x" style="width: 20px;"></i></button>
            </div>
            
            <form action="{{ route('admin.categories.sub-categories.store', $category->id) }}" method="POST">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Mobile Devices" required>
                </div>
                
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Brief explanation..."></textarea>
                </div>

                <div class="status-toggle-card" style="margin-top: 0; margin-bottom: 24px; padding: 16px;">
                    <div class="status-t-info">
                        <div class="t-text">
                            <h4 style="font-size: 13px;">Active Status</h4>
                        </div>
                    </div>
                    <select name="is_active" class="modern-select" style="background: white;">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" @click="showCreateModal = false">Cancel</button>
                    <button type="submit" class="btn-primary" style="flex: 1; justify-content: center; padding: 12px;">Save Sub-Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" style="display: none;" class="modal-overlay">
        <div class="modal-content cat-modal-dialog" @click.away="showEditModal = false">
            <div class="cat-modal-header">
                <h3>Edit Sub-Category</h3>
                <button @click="showEditModal = false" class="cat-modal-close"><i data-lucide="x" style="width: 20px;"></i></button>
            </div>
            
            <form x-bind:action="selectedSub ? selectedSub.update_url : ''" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" x-bind:value="selectedSub?.name" required>
                </div>
                
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" x-bind:value="selectedSub?.description"></textarea>
                </div>

                <div class="status-toggle-card" style="margin-top: 0; margin-bottom: 24px; padding: 16px;">
                    <div class="status-t-info">
                        <div class="t-text">
                            <h4 style="font-size: 13px;">Active Status</h4>
                        </div>
                    </div>
                    <select name="is_active" class="modern-select" x-bind:value="selectedSub?.is_active ? '1' : '0'" style="background: white;">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" @click="showEditModal = false">Cancel</button>
                    <button type="submit" class="btn-primary" style="flex: 1; justify-content: center; padding: 12px;">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDeleteModal" style="display: none;" class="modal-overlay">
        <div class="modal-content" @click.away="showDeleteModal = false">
            <div class="modal-icon">
                <i data-lucide="alert-triangle" style="width: 32px; height: 32px;"></i>
            </div>
            <h3>Delete Sub-Category</h3>
            <p>Are you sure you want to delete <strong x-text="selectedSub?.name"></strong>? This cannot be undone.</p>
            
            <form x-bind:action="selectedSub ? selectedSub.delete_url : ''" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" @click="showDeleteModal = false">Cancel</button>
                    <button type="submit" class="btn-danger">Confirm Delete</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
