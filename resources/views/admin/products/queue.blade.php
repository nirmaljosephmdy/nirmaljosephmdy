@extends('layouts.app')
@section('title', 'Product Review Queue — EUVerify')
@section('header', 'Products Queue')

@section('content')
<div style="display:flex; flex-direction:column; gap:28px;">

    {{-- Page heading --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <p style="font-size:11px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#64748B; margin:0 0 4px;">COMPLIANCE PORTAL</p>
            <h2 style="font-size:26px; font-weight:700; color:#0F172A; margin:0 0 4px;">Product Review Queue</h2>
            <p style="color:#64748B; font-size:14px; margin:0;">Review and take action on submitted products</p>
        </div>
        <a href="{{ route('admin.products.queue', array_merge(request()->query(), ['export'=>1])) }}"
           style="display:inline-flex; align-items:center; gap:8px; background:#00183F; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; font-size:13px;">
            <i data-lucide="download" style="width:16px;height:16px;"></i> Export Queue
        </a>
    </div>

    {{-- Stats + Alert row --}}
    <div style="display:grid; grid-template-columns:1fr auto; gap:20px;">
        <div style="background:#fff; border-radius:16px; padding:28px 32px; box-shadow:0 4px 20px -2px rgba(0,0,0,.05); display:flex; align-items:center; gap:48px;">
            <div>
                <p style="font-size:11px; font-weight:700; text-transform:uppercase; color:#64748B; letter-spacing:.08em; margin:0 0 6px;">In Review</p>
                <p style="font-size:36px; font-weight:700; color:#0F172A; margin:0;">{{ $products->total() }}</p>
            </div>
            <div>
                <p style="font-size:11px; font-weight:700; text-transform:uppercase; color:#64748B; letter-spacing:.08em; margin:0 0 6px;">Avg. TAT</p>
                <p style="font-size:36px; font-weight:700; color:#0F172A; margin:0;">—</p>
            </div>
        </div>
        <div style="background:#00183F; border-radius:16px; padding:24px 28px; min-width:260px; display:flex; flex-direction:column; justify-content:space-between;">
            <p style="font-size:11px; font-weight:700; text-transform:uppercase; color:#F59E0B; margin:0 0 8px; letter-spacing:.08em;">Priority Review Required</p>
            <p style="font-size:20px; font-weight:700; color:#fff; margin:0 0 16px;">{{ $products->total() }} items pending<br>in queue</p>
            <a href="{{ route('admin.products.queue', ['sort'=>'oldest']) }}"
               style="display:inline-flex; align-items:center; gap:6px; background:#fff; color:#00183F; padding:8px 16px; border-radius:6px; text-decoration:none; font-weight:700; font-size:13px; width:fit-content;">
                View Priority <i data-lucide="arrow-right" style="width:14px;height:14px;"></i>
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.products.queue') }}"
          style="background:#fff; border-radius:14px; padding:20px 24px; box-shadow:0 4px 20px -2px rgba(0,0,0,.05); display:flex; align-items:center; gap:12px; flex-wrap:wrap;">

        {{-- Category --}}
        <select name="category_id"
                onchange="this.form.submit()"
                style="border:1px solid #E2E8F0; border-radius:8px; padding:9px 12px; font-size:13px; color:#334155; background:#F8FAFC; cursor:pointer; min-width:160px;">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        {{-- Date from --}}
        <input type="date" name="date_from" value="{{ request('date_from') }}"
               style="border:1px solid #E2E8F0; border-radius:8px; padding:9px 12px; font-size:13px; color:#334155; background:#F8FAFC;"
               placeholder="From date">

        {{-- Date to --}}
        <input type="date" name="date_to" value="{{ request('date_to') }}"
               style="border:1px solid #E2E8F0; border-radius:8px; padding:9px 12px; font-size:13px; color:#334155; background:#F8FAFC;"
               placeholder="To date">

        {{-- Sort --}}
        <select name="sort" onchange="this.form.submit()"
                style="border:1px solid #E2E8F0; border-radius:8px; padding:9px 12px; font-size:13px; color:#334155; background:#F8FAFC; cursor:pointer;">
            <option value="oldest" {{ request('sort','oldest') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
        </select>

        {{-- Search --}}
        <div style="flex:1; min-width:220px; position:relative;">
            <i data-lucide="search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:#94A3B8;"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search product or company..."
                   style="width:100%; border:1px solid #E2E8F0; border-radius:8px; padding:9px 12px 9px 36px; font-size:13px; color:#334155; background:#F8FAFC;">
        </div>

        <button type="submit"
                style="background:#0052D1; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:600; cursor:pointer;">
            Apply
        </button>

        @if(request()->hasAny(['search','category_id','date_from','date_to']))
            <a href="{{ route('admin.products.queue') }}"
               style="color:#64748B; font-size:13px; text-decoration:none; font-weight:500;">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div style="background:#fff; border-radius:16px; box-shadow:0 4px 20px -2px rgba(0,0,0,.05); overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#F8FAFC; border-bottom:1px solid #F1F5F9;">
                    <th style="text-align:left; font-size:11px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:.08em; padding:16px 24px;">Product Name</th>
                    <th style="text-align:left; font-size:11px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:.08em; padding:16px 16px;">Manufacturer</th>
                    <th style="text-align:left; font-size:11px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:.08em; padding:16px 16px;">Company</th>
                    <th style="text-align:left; font-size:11px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:.08em; padding:16px 16px;">Category</th>
                    <th style="text-align:left; font-size:11px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:.08em; padding:16px 16px;">Submission Date</th>
                    <th style="text-align:left; font-size:11px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:.08em; padding:16px 16px;">Status</th>
                    <th style="text-align:center; font-size:11px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:.08em; padding:16px 24px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr style="border-bottom:1px solid #F1F5F9; transition:background .15s;" onmouseover="this.style.background='#FAFBFC'" onmouseout="this.style.background='transparent'">
                    <td style="padding:18px 24px;">
                        <p style="font-weight:600; color:#0F172A; margin:0 0 2px; font-size:14px;">{{ $product->name }}</p>
                        <p style="font-size:11px; color:#94A3B8; margin:0;">ID: PRD-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}-EU</p>
                    </td>
                    <td style="padding:18px 16px; font-size:13px; color:#334155;">
                        {{ $product->brand?->name ?? '—' }}
                    </td>
                    <td style="padding:18px 16px; font-size:13px; color:#334155;">
                        {{ $product->company?->name ?? '—' }}
                    </td>
                    <td style="padding:18px 16px;">
                        @if($product->category)
                            <span style="display:inline-block; background:#EFF6FF; color:#1D4ED8; font-size:11px; font-weight:600; padding:4px 10px; border-radius:6px;">
                                {{ $product->category->name }}
                            </span>
                        @else
                            <span style="color:#94A3B8; font-size:13px;">—</span>
                        @endif
                    </td>
                    <td style="padding:18px 16px; font-size:13px; color:#334155;">
                        {{ $product->submitted_at?->format('M d, Y') ?? '—' }}
                    </td>
                    <td style="padding:18px 16px;">
                        <span style="display:inline-flex; align-items:center; gap:6px; background:#FEF3C7; color:#B45309; font-size:11px; font-weight:700; padding:5px 12px; border-radius:6px; text-transform:uppercase; letter-spacing:.05em;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#F59E0B;display:inline-block;"></span>
                            In Review
                        </span>
                    </td>
                    <td style="padding:18px 24px; text-align:center;">
                        <a href="{{ route('admin.products.review', $product->id) }}"
                           title="Open Review"
                           style="display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:8px; background:#F1F5F9; color:#334155; transition:background .15s;"
                           onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">
                            <i data-lucide="external-link" style="width:16px;height:16px;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:48px 24px; text-align:center; color:#94A3B8; font-size:14px;">
                        <i data-lucide="inbox" style="width:40px;height:40px;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;"></i>
                        No products currently in review queue.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($products->hasPages())
        <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 24px; border-top:1px solid #F1F5F9;">
            <p style="font-size:13px; color:#64748B; margin:0;">
                Showing <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> results
            </p>
            <div style="display:flex; gap:4px; align-items:center;">
                {{-- Prev --}}
                @if($products->onFirstPage())
                    <span style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;color:#CBD5E1;cursor:default;">
                        <i data-lucide="chevron-left" style="width:16px;height:16px;"></i>
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}"
                       style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;color:#334155;text-decoration:none;background:#F8FAFC;border:1px solid #E2E8F0;">
                        <i data-lucide="chevron-left" style="width:16px;height:16px;"></i>
                    </a>
                @endif

                {{-- Pages --}}
                @foreach($products->getUrlRange(max(1, $products->currentPage()-2), min($products->lastPage(), $products->currentPage()+2)) as $page => $url)
                    @if($page == $products->currentPage())
                        <span style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;background:#00183F;color:#fff;font-size:13px;font-weight:600;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;color:#334155;font-size:13px;text-decoration:none;background:#F8FAFC;border:1px solid #E2E8F0;">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}"
                       style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;color:#334155;text-decoration:none;background:#F8FAFC;border:1px solid #E2E8F0;">
                        <i data-lucide="chevron-right" style="width:16px;height:16px;"></i>
                    </a>
                @else
                    <span style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:6px;color:#CBD5E1;cursor:default;">
                        <i data-lucide="chevron-right" style="width:16px;height:16px;"></i>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
@endsection
