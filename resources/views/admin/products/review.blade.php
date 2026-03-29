@extends('layouts.app')
@section('title', 'Review Product — EUVerify')
@section('header', 'Product Review')

@section('content')
<div style="display:flex; flex-direction:column; gap:28px;">

    {{-- Header --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <a href="{{ route('admin.products.queue') }}" style="display:inline-flex; align-items:center; gap:6px; color:#64748B; font-size:13px; text-decoration:none; margin-bottom:12px; font-weight:500;">
                <i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Back to Queue
            </a>
            <h2 style="font-size:26px; font-weight:700; color:#0F172A; margin:0 0 8px;">{{ $product->name }}</h2>
            <div style="display:flex; gap:12px; align-items:center; font-size:13px; color:#64748B;">
                <span>ID: PRD-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span>
                <span style="width:4px;height:4px;background:#CBD5E1;border-radius:50%;"></span>
                <span>Submitted: {{ $product->submitted_at?->format('M d, Y') ?? '—' }}</span>
                <span style="width:4px;height:4px;background:#CBD5E1;border-radius:50%;"></span>
                <span>By: {{ $product->company->name ?? '—' }}</span>
            </div>
        </div>
        
        {{-- Status badge --}}
        <div>
            <span style="display:inline-flex; align-items:center; gap:6px; background:#FEF3C7; color:#B45309; font-size:12px; font-weight:700; padding:6px 14px; border-radius:6px; text-transform:uppercase; letter-spacing:.05em;">
                <span style="width:6px;height:6px;border-radius:50%;background:#F59E0B;display:inline-block;"></span>
                In Review
            </span>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#ECFDF5; color:#065F46; padding:16px; border-radius:8px; border:1px solid #10B981; font-size:14px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#FEF2F2; color:#991B1B; padding:16px; border-radius:8px; border:1px solid #EF4444; font-size:14px;">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background:#FEF2F2; color:#991B1B; padding:16px; border-radius:8px; border:1px solid #EF4444; font-size:14px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display:grid; grid-template-columns:2fr 1fr; gap:28px; align-items:start;">
        
        {{-- Left Column: Product Details, Images, Documents --}}
        <div style="display:flex; flex-direction:column; gap:28px;">
            
            {{-- Product Info Card --}}
            <div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px -2px rgba(0,0,0,.05); border:1px solid #F1F5F9; overflow:hidden;">
                <div style="padding:20px 24px; border-bottom:1px solid #F1F5F9;">
                    <h3 style="margin:0; font-size:16px; font-weight:600; color:#0F172A;">Product Details</h3>
                </div>
                <div style="padding:24px; display:grid; grid-template-columns:1fr 1fr; gap:24px;">
                    <div>
                        <p style="font-size:12px; font-weight:600; color:#64748B; margin:0 0 4px; text-transform:uppercase; letter-spacing:.05em;">Category</p>
                        <p style="font-size:14px; color:#334155; margin:0;">{{ $product->category?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p style="font-size:12px; font-weight:600; color:#64748B; margin:0 0 4px; text-transform:uppercase; letter-spacing:.05em;">Subcategory</p>
                        <p style="font-size:14px; color:#334155; margin:0;">{{ $product->productCategory?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p style="font-size:12px; font-weight:600; color:#64748B; margin:0 0 4px; text-transform:uppercase; letter-spacing:.05em;">Brand</p>
                        <p style="font-size:14px; color:#334155; margin:0;">{{ $product->brand?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p style="font-size:12px; font-weight:600; color:#64748B; margin:0 0 4px; text-transform:uppercase; letter-spacing:.05em;">SKU</p>
                        <p style="font-size:14px; color:#334155; margin:0;">{{ $product->sku ?? '—' }}</p>
                    </div>
                    <div>
                        <p style="font-size:12px; font-weight:600; color:#64748B; margin:0 0 4px; text-transform:uppercase; letter-spacing:.05em;">Batch Number</p>
                        <p style="font-size:14px; color:#334155; margin:0;">{{ $product->batch_number ?? '—' }}</p>
                    </div>
                    <div style="grid-column:1/-1;">
                        <p style="font-size:12px; font-weight:600; color:#64748B; margin:0 0 4px; text-transform:uppercase; letter-spacing:.05em;">Description</p>
                        <p style="font-size:14px; color:#334155; margin:0; line-height:1.6;">{{ $product->description ?: '—' }}</p>
                    </div>
                    <div style="grid-column:1/-1;">
                        <p style="font-size:12px; font-weight:600; color:#64748B; margin:0 0 4px; text-transform:uppercase; letter-spacing:.05em;">Intended Use</p>
                        <p style="font-size:14px; color:#334155; margin:0; line-height:1.6;">{{ $product->intended_use ?: '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Images Card --}}
            <div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px -2px rgba(0,0,0,.05); border:1px solid #F1F5F9; overflow:hidden;">
                <div style="padding:20px 24px; border-bottom:1px solid #F1F5F9;">
                    <h3 style="margin:0; font-size:16px; font-weight:600; color:#0F172A;">Product Images</h3>
                </div>
                <div style="padding:24px; display:flex; gap:16px; flex-wrap:wrap;">
                    @forelse($product->images as $img)
                        <div style="width:120px; position:relative; {{ $img->is_primary ? 'border:2px solid #0052D1; border-radius:8px;' : 'border:1px solid #E2E8F0; border-radius:8px;' }} overflow:hidden; background:#F8FAFC;">
                            <img src="{{ Storage::url($img->file_path) }}" alt="Product Image" style="width:100%; height:120px; object-fit:cover; display:block;">
                            @if($img->is_primary)
                                <div style="position:absolute; bottom:0; left:0; right:0; background:#0052D1; color:#fff; font-size:10px; font-weight:700; text-align:center; padding:4px;">PRIMARY</div>
                            @endif
                        </div>
                    @empty
                        <p style="color:#94A3B8; font-size:14px; margin:0;">No images uploaded.</p>
                    @endforelse
                </div>
            </div>

            {{-- Documents Card --}}
            <div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px -2px rgba(0,0,0,.05); border:1px solid #F1F5F9; overflow:hidden;">
                <div style="padding:20px 24px; border-bottom:1px solid #F1F5F9;">
                    <h3 style="margin:0; font-size:16px; font-weight:600; color:#0F172A;">Documents</h3>
                </div>
                <div style="padding:0;">
                    @forelse($product->documents as $doc)
                        <div style="padding:20px 24px; border-bottom:1px solid #F1F5F9;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                                <div>
                                    <h4 style="margin:0 0 4px; font-size:14px; font-weight:600; color:#0F172A; display:flex; align-items:center; gap:8px;">
                                        {{ $doc->title ?: 'Document' }}
                                        @if($doc->status->value === 2)
                                            <span style="background:#DCFCE7; color:#166534; font-size:10px; font-weight:700; padding:2px 6px; border-radius:4px; text-transform:uppercase;">Accepted</span>
                                        @elseif($doc->status->value === 3)
                                            <span style="background:#FEE2E2; color:#991B1B; font-size:10px; font-weight:700; padding:2px 6px; border-radius:4px; text-transform:uppercase;">Rejected</span>
                                        @else
                                            <span style="background:#FEF3C7; color:#92400E; font-size:10px; font-weight:700; padding:2px 6px; border-radius:4px; text-transform:uppercase;">Pending</span>
                                        @endif
                                    </h4>
                                    <p style="margin:0; font-size:12px; color:#64748B;">
                                        Type: {{ str($doc->document_type->name)->headline() }} • Version: {{ $doc->version ?? '1.0' }}
                                    </p>
                                </div>
                                <a href="{{ route('app.documents.download', $doc->id) }}" target="_blank" style="color:#0052D1; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; gap:6px; align-items:center;">
                                    <i data-lucide="download" style="width:14px;height:14px;"></i> Download
                                </a>
                            </div>

                            @if($doc->status->value === 3 && $doc->admin_note)
                                <div style="background:#FEF2F2; padding:12px; border-radius:6px; font-size:13px; color:#991B1B; margin-bottom:12px;">
                                    <strong>Rejection Note:</strong> {{ $doc->admin_note }}
                                </div>
                            @endif

                            @if($doc->status->value === 1)
                                <div style="display:flex; gap:8px;">
                                    {{-- Accept Document --}}
                                    <form action="{{ route('admin.documents.accept', $doc->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" style="background:#10B981; color:#fff; border:none; border-radius:6px; padding:6px 12px; font-size:12px; font-weight:600; cursor:pointer;">
                                            Accept Document
                                        </button>
                                    </form>

                                    {{-- Reject Document (triggers inline form) --}}
                                    <button type="button" onclick="document.getElementById('reject-doc-form-{{ $doc->id }}').style.display='block'" style="background:#fff; color:#EF4444; border:1px solid #EF4444; border-radius:6px; padding:6px 12px; font-size:12px; font-weight:600; cursor:pointer;">
                                        Reject...
                                    </button>
                                </div>

                                {{-- Inline Reject Form --}}
                                <div id="reject-doc-form-{{ $doc->id }}" style="display:none; margin-top:12px; background:#F8FAFC; padding:12px; border-radius:8px; border:1px solid #E2E8F0;">
                                    <form action="{{ route('admin.documents.reject', $doc->id) }}" method="POST">
                                        @csrf
                                        <textarea name="admin_note" rows="2" placeholder="Reason for rejection..." required style="width:100%; border:1px solid #CBD5E1; border-radius:6px; padding:8px; font-size:13px; margin-bottom:8px; font-family:inherit; box-sizing:border-box;"></textarea>
                                        <div style="display:flex; gap:8px; justify-content:flex-end;">
                                            <button type="button" onclick="document.getElementById('reject-doc-form-{{ $doc->id }}').style.display='none'" style="background:transparent; border:none; color:#64748B; font-size:12px; font-weight:600; cursor:pointer;">Cancel</button>
                                            <button type="submit" style="background:#EF4444; color:#fff; border:none; border-radius:6px; padding:6px 12px; font-size:12px; font-weight:600; cursor:pointer;">Confirm Reject</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div style="padding:24px; text-align:center; color:#94A3B8; font-size:14px;">No documents uploaded.</div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Right Column: Issues & Core Actions --}}
        <div style="display:flex; flex-direction:column; gap:28px;">
            
            {{-- Issues Section --}}
            <div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px -2px rgba(0,0,0,.05); border:1px solid #F1F5F9; overflow:hidden;">
                <div style="padding:20px 24px; border-bottom:1px solid #F1F5F9; background:#FEF2F2; display:flex; justify-content:space-between; align-items:center;">
                    <h3 style="margin:0; font-size:16px; font-weight:600; color:#991B1B; display:flex; align-items:center; gap:8px;">
                        <i data-lucide="alert-triangle" style="width:18px;height:18px;"></i> Product Issues
                    </h3>
                    <span style="background:#EF4444; color:#fff; font-size:11px; font-weight:700; padding:2px 8px; border-radius:12px;">{{ $product->issues->where('is_resolved', false)->count() }} Open</span>
                </div>
                <div style="padding:0;">
                    @forelse($product->issues as $issue)
                        <div style="padding:16px 24px; border-bottom:1px solid #F1F5F9;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                                <p style="margin:0; font-size:13px; color:#1E293B; line-height:1.5;">{{ $issue->issue_text }}</p>
                                @if($issue->is_resolved)
                                    <span style="background:#DCFCE7; color:#166534; font-size:10px; font-weight:700; padding:2px 6px; border-radius:4px; text-transform:uppercase; margin-left:12px; white-space:nowrap;">Resolved</span>
                                @endif
                            </div>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="font-size:11px; color:#64748B;">Date: {{ \Carbon\Carbon::parse($issue->created_at)->format('M d, Y') }}</span>
                                @if(!$issue->is_resolved)
                                    <form action="{{ route('admin.products.issues.resolve', [$product->id, $issue->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn-resolve" type="submit" style="background:#F3F4F6; color:#374151; border:1px solid #D1D5DB; border-radius:6px; padding:4px 10px; font-size:11px; font-weight:600; cursor:pointer;" onmouseover="this.style.background='#E5E7EB'" onmouseout="this.style.background='#F3F4F6'">
                                            Mark Resolved
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="padding:24px; text-align:center; color:#94A3B8; font-size:14px;">No issues reported yet.</div>
                    @endforelse
                </div>
                
                <div style="padding:20px 24px; background:#F8FAFC; border-top:1px solid #F1F5F9;">
                    <form action="{{ route('admin.products.issues.store', $product->id) }}" method="POST">
                        @csrf
                        <p style="margin:0 0 8px; font-size:13px; font-weight:600; color:#334155;">Report New Issue</p>
                        <textarea name="issue_text" rows="3" required placeholder="Describe the issue here..." style="width:100%; border:1px solid #CBD5E1; border-radius:8px; padding:10px 12px; font-size:13px; font-family:inherit; margin-bottom:12px; box-sizing:border-box;"></textarea>
                        <button type="submit" style="background:#0F172A; color:#fff; border:none; border-radius:6px; padding:8px 16px; font-size:13px; font-weight:600; cursor:pointer; width:100%;">Add Issue</button>
                    </form>
                </div>
            </div>

            {{-- Final Actions Card --}}
            <div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px -2px rgba(0,0,0,.05); border:1px solid #F1F5F9; overflow:hidden;">
                <div style="padding:20px 24px; border-bottom:1px solid #F1F5F9; background:#00183F; color:#fff;">
                    <h3 style="margin:0; font-size:16px; font-weight:600; color:#fff; display:flex; align-items:center; gap:8px;">
                        <i data-lucide="shield-check" style="width:18px;height:18px;"></i> Final Decision
                    </h3>
                </div>
                <div style="padding:24px;">
                    <div style="display:flex; flex-direction:column; gap:16px;">
                        
                        {{-- Mark Compliant --}}
                        <div style="border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                            <h4 style="margin:0 0 4px; font-size:14px; font-weight:600; color:#10B981;">Approve Product</h4>
                            <p style="margin:0 0 12px; font-size:12px; color:#64748B;">Requires at least one accepted document.</p>
                            <form action="{{ route('admin.products.compliant', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background:#10B981; color:#fff; border:none; border-radius:6px; padding:10px; font-size:13px; font-weight:600; cursor:pointer; width:100%; display:flex; align-items:center; justify-content:center; gap:6px;">
                                    <i data-lucide="check-circle" style="width:16px;height:16px;"></i> Mark as Compliant
                                </button>
                            </form>
                        </div>

                        {{-- Mark Incompliant --}}
                        <div style="border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                            <h4 style="margin:0 0 4px; font-size:14px; font-weight:600; color:#F59E0B;">Flag as Incompliant</h4>
                            <p style="margin:0 0 12px; font-size:12px; color:#64748B;">Requires at least one open issue.</p>
                            <form action="{{ route('admin.products.incompliant', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background:#F59E0B; color:#fff; border:none; border-radius:6px; padding:10px; font-size:13px; font-weight:600; cursor:pointer; width:100%; display:flex; align-items:center; justify-content:center; gap:6px;">
                                    <i data-lucide="alert-circle" style="width:16px;height:16px;"></i> Mark as Incompliant
                                </button>
                            </form>
                        </div>

                        {{-- Reject Product --}}
                        <div style="border:1px solid #FEE2E2; border-radius:8px; padding:16px; background:#FEF2F2;">
                            <h4 style="margin:0 0 4px; font-size:14px; font-weight:600; color:#EF4444;">Reject Permanently</h4>
                            <p style="margin:0 0 12px; font-size:12px; color:#991B1B;">Cannot be undone. Min 20 characters required.</p>
                            <form action="{{ route('admin.products.reject', $product->id) }}" method="POST">
                                @csrf
                                <textarea name="reason" rows="2" placeholder="Provide detailed rejection reason..." required minlength="20" style="width:100%; border:1px solid #FCA5A5; border-radius:6px; padding:8px; font-size:12px; font-family:inherit; margin-bottom:12px; box-sizing:border-box; background:#fff;"></textarea>
                                <button type="submit" style="background:#EF4444; color:#fff; border:none; border-radius:6px; padding:10px; font-size:13px; font-weight:600; cursor:pointer; width:100%; display:flex; align-items:center; justify-content:center; gap:6px;">
                                    <i data-lucide="x-circle" style="width:16px;height:16px;"></i> Reject Product
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection