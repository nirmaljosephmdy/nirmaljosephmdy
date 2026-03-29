@extends('layouts.app')

@section('title', 'Category Management')

@section('content')
@php
    $categoriesJson = collect($categories->items())->map(function($c) {
        $activeSubcats = $c->productCategories->where('is_active', true);
        return [
            'id' => $c->id,
            'name' => $c->name,
            'description' => $c->description,
            'is_active' => $c->is_active,
            'compliance_score' => $c->compliance_score ?? '0.0',
            'created_at_fmt' => $c->created_at->format('M d, Y'),
            'created_time_fmt' => $c->created_at->format('g:i A'),
            'manage_url' => route('admin.categories.sub-categories.index', $c->id),
            'update_url' => route('admin.categories.update', $c->id),
            'delete_url' => route('admin.categories.destroy', $c->id),
            'sub_categories_total' => $c->productCategories->count(),
            'sub_categories_active' => $activeSubcats->count(),
        ];
    })->values();
@endphp

<div class="category-page-content" x-data="{ 
        categories: {{ Js::from($categoriesJson) }},
        selectedCat: null,
        
        // Modals
        showCreateModal: false,
        showEditModal: false,
        showDeleteModal: false,
        
        openEditModal(cat) {
            this.selectedCat = cat;
            this.showEditModal = true;
        },
        openDeleteModal(cat) {
            this.selectedCat = cat;
            this.showDeleteModal = true;
        }
    }" x-init="setTimeout(() => { if(typeof lucide !== 'undefined') lucide.createIcons(); }, 100)">

    <div class="category-page-header">
        <div>
            <h1>Category Management</h1>
            <p>Organize and define regulatory compliance structures for the European Union market.</p>
        </div>
        <div style="display: flex; gap: 16px; align-items: center;">
            <button @click="showCreateModal = true" class="btn-primary" style="margin-left: 24px;">
                <i data-lucide="plus" style="width: 16px;"></i> Add New Category
            </button>
        </div>
    </div>

    <div class="category-layout">
        <!-- Main List -->
        <div class="category-main-list">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="category-filter-bar">
                <input type="text" name="search" class="search-input-cat" placeholder="Filter by category name..." value="{{ request('search') }}" onkeyup="clearTimeout(window.searchTimer); window.searchTimer = setTimeout(() => { this.form.submit(); }, 500);" {{ request()->has('search') ? 'autofocus onfocus="let v=this.value;this.value=\'\';this.value=v;"' : '' }}>
                
                <div style="display: flex; gap: 16px; align-items: center;">
                    <select name="status" class="modern-select" onchange="this.form.submit()" style="padding-top: 6px; padding-bottom: 6px;">
                        <option value="">All Statuses</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    
                    <span style="font-size: 11px; font-weight: 800; color: #0F172A; text-transform: uppercase; letter-spacing: 0.05em;">
                        Displaying {{ $categories->firstItem() ?? 0 }}-{{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }}
                    </span>
                </div>
            </form>

            <div class="category-row-list">
                <table class="cat-table">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Name</th>
                            <th style="width: 30%;">Description</th>
                            <th style="width: 12%;">Sub-cats</th>
                            <th style="width: 13%;">Status</th>
                            <th style="width: 15%;">Created At</th>
                            <th style="width: 5%; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="cat in categories" :key="cat.id">
                            <tr>
                                <td>
                                    <div class="cat-name-group">
                                        <div>
                                            <a x-bind:href="cat.manage_url" class="cat-title" style="color: #0F172A; text-decoration: none; display: inline-block;" onmouseover="this.style.color='#0052D1'" onmouseout="this.style.color='#0F172A'" x-text="cat.name"></a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="cat-desc" x-text="cat.description || 'No description provided.'"></span>
                                </td>
                                <td>
                                    <span style="font-size: 13px; font-weight: 700; color: #0052D1;" x-text="cat.sub_categories_total + ' total'"></span>
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
                                        <button @click="openEditModal(cat)" style="background: transparent; border: none; padding: 6px; cursor: pointer; color: #64748B; border-radius: 6px;" title="Edit Category" onmouseover="this.style.background='#F1F5F9'; this.style.color='#0052D1';" onmouseout="this.style.background='transparent'; this.style.color='#64748B';">
                                            <i data-lucide="edit-3" style="width: 18px;"></i>
                                        </button>
                                        <button @click="openDeleteModal(cat)" style="background: transparent; border: none; padding: 6px; cursor: pointer; color: #EF4444; border-radius: 6px;" title="Delete Category" onmouseover="this.style.background='#FEF2F2'; this.style.color='#DC2626';" onmouseout="this.style.background='transparent'; this.style.color='#EF4444';">
                                            <i data-lucide="trash-2" style="width: 18px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        @if($categories->isEmpty())
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 48px; color: #64748B;">No categories found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            @if($categories->hasPages())
                <div style="margin-top: 16px;">
                    {{ $categories->links('pagination::simple-tailwind') }}
                </div>
            @endif
        </div>
    </div>


    <!-- ==================== MODALS ==================== -->
    
    <!-- Create Modal -->
    <div x-show="showCreateModal" style="display: none;" class="modal-overlay">
        <div class="modal-content cat-modal-dialog" @click.away="showCreateModal = false">
            <div class="cat-modal-header">
                <h3>Create New Category</h3>
                <button @click="showCreateModal = false" class="cat-modal-close"><i data-lucide="x" style="width: 20px;"></i></button>
            </div>
            
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Category Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Electronic Devices" required>
                </div>
                
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Brief explanation of the category..."></textarea>
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
                    <button type="submit" class="btn-primary" style="flex: 1; justify-content: center; padding: 12px;">Save Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" style="display: none;" class="modal-overlay">
        <div class="modal-content cat-modal-dialog" @click.away="showEditModal = false">
            <div class="cat-modal-header">
                <h3>Edit Category</h3>
                <button @click="showEditModal = false" class="cat-modal-close"><i data-lucide="x" style="width: 20px;"></i></button>
            </div>
            
            <form x-bind:action="selectedCat ? selectedCat.update_url : ''" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Category Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" x-bind:value="selectedCat?.name" required>
                </div>
                
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" x-bind:value="selectedCat?.description"></textarea>
                </div>

                <div class="status-toggle-card" style="margin-top: 0; margin-bottom: 24px; padding: 16px;">
                    <div class="status-t-info">
                        <div class="t-text">
                            <h4 style="font-size: 13px;">Active Status</h4>
                        </div>
                    </div>
                    <select name="is_active" class="modern-select" x-bind:value="selectedCat?.is_active ? '1' : '0'" style="background: white;">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" @click="showEditModal = false">Cancel</button>
                    <button type="submit" class="btn-primary" style="flex: 1; justify-content: center; padding: 12px;">Update Category</button>
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
            <h3>Delete Category</h3>
            <p>Are you sure you want to delete <strong x-text="selectedCat?.name"></strong>? This cannot be undone.</p>
            
            <form x-bind:action="selectedCat ? selectedCat.delete_url : ''" method="POST">
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