@php
    $type = $type ?? 'line';
@endphp

@if ($type === 'gauge')
    <div class="gauge" style="--score: {{ $score ?? 82 }};">
        <div><strong>{{ $score ?? 82 }}</strong><span>{{ $label ?? 'Ready' }}</span></div>
    </div>
@elseif ($type === 'radar')
    <div class="radar-chart" aria-label="Competency radar chart">
        <span>Communication</span><span>Leadership</span><span>Digital</span><span>Professionalism</span><span>Problem Solving</span>
    </div>
@elseif ($type === 'bars')
    <div class="bar-chart">
        @foreach (($items ?? ['Digital Literacy' => 88, 'Communication' => 76, 'AI Basics' => 68, 'Project Delivery' => 82]) as $label => $value)
            <div>
                <span>{{ $label }}</span>
                <i><b style="width: {{ $value }}%"></b></i>
            </div>
        @endforeach
    </div>
@elseif ($type === 'heatmap')
    <div class="africa-map" aria-label="Africa skills demand heat map">
        @for ($i = 1; $i <= 28; $i++)
            <span style="--level: {{ ($i % 4) + 1 }}"></span>
        @endfor
    </div>
@else
    <div class="line-chart" aria-label="Workforce trend chart">
        <svg viewBox="0 0 360 160" preserveAspectRatio="none">
            <path d="M10 130 C40 70 70 96 95 88 S145 28 180 62 230 118 260 58 315 84 350 28" fill="none" stroke="var(--blue)" stroke-width="5"/>
            <path d="M10 145 C55 116 88 120 128 95 S205 88 248 100 302 74 350 62" fill="none" stroke="var(--green)" stroke-width="4"/>
        </svg>
    </div>
@endif
