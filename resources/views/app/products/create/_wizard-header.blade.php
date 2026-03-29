@php
$steps = [
    1 => 'Classification',
    2 => 'Product Details',
    3 => 'Images',
    4 => 'AR Address',
    5 => 'Documents',
    6 => 'Review',
];
@endphp
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
    <div style="display: flex; align-items: center; gap: 0; flex: 1;">
        @foreach($steps as $num => $label)
            @php $isDone = $num < $step; $isCurrent = $num === $step; @endphp
            <div style="display: flex; align-items: center; flex: 1;">
                <div style="display: flex; flex-direction: column; align-items: center; gap: 6px; position: relative;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;
                        background: {{ $isDone ? '#10B981' : ($isCurrent ? '#00183F' : '#E2E8F0') }};
                        color: {{ ($isDone || $isCurrent) ? '#fff' : '#94A3B8' }};">
                        @if($isDone)
                            <i data-lucide="check" style="width: 16px; height: 16px;"></i>
                        @else
                            {{ str_pad($num, 2, '0', STR_PAD_LEFT) }}
                        @endif
                    </div>
                    <span style="font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; white-space: nowrap;
                        color: {{ $isCurrent ? '#00183F' : '#94A3B8' }};">{{ strtoupper($label) }}</span>
                </div>
                @if(!$loop->last)
                    <div style="flex: 1; height: 2px; background: {{ $num < $step ? '#10B981' : '#E2E8F0' }}; margin: 0 4px; margin-bottom: 18px;"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>
