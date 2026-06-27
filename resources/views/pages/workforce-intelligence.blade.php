@extends('layouts.app')
@section('title', 'Workforce Intelligence™ - TSEA')

@section('content')
@php
    $activePrograms = \App\Models\Program::query()
        ->whereIn('status', ['active', 'published'])
        ->where('is_active', true)
        ->get();

    if ($activePrograms->isEmpty()) {
        $activePrograms = collect([
            (object) ['title' => 'Data Analytics', 'category' => 'Technology'],
            (object) ['title' => 'Digital Marketing', 'category' => 'Commercial'],
            (object) ['title' => 'Cybersecurity', 'category' => 'Technology'],
            (object) ['title' => 'AI & Prompt Engineering', 'category' => 'Digital Economy'],
        ]);
    }

    $programCount = $activePrograms->count();
    $categoryGroups = $activePrograms->groupBy(fn ($program) => $program->category ?: 'General');
    $categoryStats = $categoryGroups->map(function ($programs, $category) use ($programCount) {
        $count = $programs->count();
        $share = round(($count / max(1, $programCount)) * 100, 1);

        return [
            'name' => $category,
            'count' => $count,
            'share' => $share,
            'skills' => $programs->pluck('title')->take(3)->values()->toArray(),
        ];
    })->sortByDesc('share')->values();

    $topCategory = (string) $categoryGroups
        ->sortByDesc(fn ($items) => $items->count())
        ->keys()
        ->first();
    $topCategoryCount = (int) ($categoryGroups->get($topCategory)?->count() ?? 1);
    $topCategoryShare = round(($topCategoryCount / max(1, $programCount)) * 100, 1);

    $sectorDemand = $categoryStats->map(function ($stat) {
        $signal = $stat['share'] >= 40 ? 'Very High' : ($stat['share'] >= 25 ? 'High' : 'Rising');

        return [
            'name' => $stat['name'],
            'score' => $stat['share'],
            'count' => $stat['count'],
            'signal' => $signal,
            'skills' => $stat['skills'],
        ];
    })->values()->take(6)->toArray();

    $avgDemand = round(collect($sectorDemand)->avg('score') ?: 0, 1);
    $regionRoles = $activePrograms->pluck('title')->take(3)->values()->toArray();
    $regionalShares = collect($sectorDemand)->pluck('score')->pad(4, $avgDemand)->values();
    $regionalGrowth = collect($sectorDemand)->pluck('count')->pad(4, 0)->values();

    $regions = [
        ['code' => 'EA', 'name' => 'East Africa', 'opportunity' => $regionalShares[0], 'growth' => '+' . number_format(($regionalGrowth[0] / max(1, $programCount)) * 100, 1) . '%', 'focus' => 'Top mapped category concentration from active programs', 'roles' => $regionRoles],
        ['code' => 'WA', 'name' => 'West Africa', 'opportunity' => $regionalShares[1], 'growth' => '+' . number_format(($regionalGrowth[1] / max(1, $programCount)) * 100, 1) . '%', 'focus' => 'Top mapped category concentration from active programs', 'roles' => array_reverse($regionRoles)],
        ['code' => 'SA', 'name' => 'Southern Africa', 'opportunity' => $regionalShares[2], 'growth' => '+' . number_format(($regionalGrowth[2] / max(1, $programCount)) * 100, 1) . '%', 'focus' => 'Top mapped category concentration from active programs', 'roles' => $regionRoles],
        ['code' => 'NA', 'name' => 'North Africa', 'opportunity' => $regionalShares[3], 'growth' => '+' . number_format(($regionalGrowth[3] / max(1, $programCount)) * 100, 1) . '%', 'focus' => 'Top mapped category concentration from active programs', 'roles' => array_reverse($regionRoles)],
    ];

    $topRegion = collect($regions)->sortByDesc('opportunity')->first();
    $publishedShare = round(($activePrograms->where('status', 'published')->count() / max(1, $programCount)) * 100, 1);
    $withImageShare = round(($activePrograms->filter(fn ($program) => !empty($program->image))->count() / max(1, $programCount)) * 100, 1);

    $kpis = [
        ['label' => 'Active Programs', 'value' => $programCount, 'unit' => '', 'delta' => 'Live from program portfolio', 'tone' => 'up'],
        ['label' => 'Published Program Share', 'value' => $publishedShare, 'unit' => '%', 'delta' => 'Published status ratio from DB', 'tone' => 'up'],
        ['label' => 'Top Category Share', 'value' => $topCategoryShare, 'unit' => '%', 'delta' => $topCategory . ' leads current demand', 'tone' => 'up'],
        ['label' => 'Program Image Coverage', 'value' => $withImageShare, 'unit' => '%', 'delta' => 'Programs with uploaded images', 'tone' => 'up'],
        ['label' => 'Regional Opportunity Share', 'value' => $topRegion['opportunity'], 'unit' => '%', 'delta' => $topRegion['name'] . ' strongest this cycle', 'tone' => 'up'],
    ];

    $recommendations = [
        ['title' => 'Scale ' . $topCategory . ' Capacity', 'text' => 'Current program signals show highest concentration in ' . $topCategory . '. Expand delivery slots and employer placements.'],
        ['title' => 'Refresh Content Every 90 Days', 'text' => 'Use live program and demand shifts to adjust module focus, tooling, and assessment outcomes.'],
        ['title' => 'Increase Region-Specific Pathways', 'text' => 'Align top tracks to ' . $topRegion['name'] . ' opportunity trends for stronger readiness-to-role conversion.'],
    ];

    $skillBars = $categoryStats
        ->take(5)
        ->mapWithKeys(fn ($stat) => [$stat['name'] => $stat['share']])
        ->toArray();

    $lastUpdated = now()->format('d M Y, H:i');
@endphp

<section class="wi-hero">
    <div class="container wi-hero-grid">
        <div class="wi-copy">
            <span class="eyebrow">Workforce Intelligence™</span>
            <h1>Labour Market Intelligence Built For African Talent Decisions</h1>
            <p>Track demand signals, hiring momentum, and readiness outcomes in one operational view for employers, institutions, and workforce teams.</p>
            <div class="wi-actions">
                <a href="{{ route('programs') }}" class="btn btn-gold">Explore Programs</a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">Request Intelligence Brief</a>
            </div>
        </div>

        <aside class="wi-snapshot card" aria-label="Live intelligence snapshot">
            <div class="wi-snapshot-head">
                <strong>Live Snapshot</strong>
                <small>Updated {{ $lastUpdated }}</small>
            </div>
            <div class="wi-snapshot-grid">
                <div>
                    <span>Top Region</span>
                    <strong>{{ $topRegion['name'] }}</strong>
                </div>
                <div>
                    <span>Avg Demand</span>
                    <strong>{{ $avgDemand }}%</strong>
                </div>
                <div>
                    <span>Growth Signal</span>
                    <strong>{{ $topRegion['growth'] }}</strong>
                </div>
                <div>
                    <span>Regional Score</span>
                    <strong>{{ $topRegion['opportunity'] }}%</strong>
                </div>
            </div>
            <div class="wi-mini-chart">
                @include('partials.charts')
            </div>
        </aside>
    </div>
</section>

<section class="section wi-kpi-section">
    <div class="container wi-kpi-grid">
        @foreach($kpis as $kpi)
            <article class="wi-kpi-card">
                <span>{{ $kpi['label'] }}</span>
                <strong>{{ $kpi['value'] }}{{ $kpi['unit'] }}</strong>
                <small class="{{ $kpi['tone'] }}">{{ $kpi['delta'] }}</small>
            </article>
        @endforeach
    </div>
</section>

<section class="section wi-board">
    <div class="container wi-board-grid">
        <article class="card wi-wide">
            <div class="wi-title-row">
                <h2>Skills Demand Heat Map</h2>
                <span>Africa-wide vacancy and capability pull</span>
            </div>
            @include('partials.charts', ['type' => 'heatmap'])
        </article>

        <article class="card wi-wide">
            <div class="wi-title-row">
                <h2>Hiring Momentum Trend</h2>
                <span>Quarterly hiring movement across sectors</span>
            </div>
            @include('partials.charts')
        </article>

        <article class="card wi-sector-card">
            <div class="wi-title-row">
                <h2>Sector Intelligence Matrix</h2>
                <span>Dynamic demand by sector</span>
            </div>

            <div class="wi-sector-grid">
                @foreach($sectorDemand as $sector)
                    <div class="wi-sector-item">
                        <div class="wi-sector-top">
                            <strong>{{ $sector['name'] }}</strong>
                            <span>{{ $sector['signal'] }}</span>
                        </div>
                        <small>{{ $sector['count'] }} programs | {{ $sector['score'] }}% share</small>
                        <div class="wi-meter" aria-hidden="true">
                            <progress value="{{ $sector['score'] }}" max="100"></progress>
                        </div>
                        <p>Demand Score: {{ $sector['score'] }}%</p>
                        <ul>
                            @foreach($sector['skills'] as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </article>
    </div>
</section>

<section class="section wi-regions">
    <div class="container wi-region-grid">
        <article class="card">
            <div class="wi-title-row">
                <h2>Regional Opportunity Board</h2>
                <span>Select a region to inspect trend and target roles</span>
            </div>

            <div class="wi-region-pills" role="tablist" aria-label="Region selectors">
                @foreach($regions as $region)
                    <button type="button" data-region-btn="{{ $region['code'] }}" @class(['active' => $loop->first])>
                        {{ $region['name'] }}
                    </button>
                @endforeach
            </div>

            <div class="wi-region-details" id="regionDetails">
                <h3>{{ $regions[0]['name'] }}</h3>
                <p>{{ $regions[0]['focus'] }}</p>
                <div class="wi-region-metrics">
                    <span>Opportunity <strong>{{ $regions[0]['opportunity'] }}%</strong></span>
                    <span>Growth <strong>{{ $regions[0]['growth'] }}</strong></span>
                </div>
                <ul id="regionRoles">
                    @foreach($regions[0]['roles'] as $role)
                        <li>{{ $role }}</li>
                    @endforeach
                </ul>
            </div>
        </article>

        <article class="card">
            <div class="wi-title-row">
                <h2>Top In-Demand Skills</h2>
                <span>Cross-sector capability pull</span>
            </div>
            @include('partials.charts', ['type' => 'bars', 'items' => $skillBars])
        </article>
    </div>
</section>

<section class="section wi-recommendations">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Action Layer</span>
            <h2>Recommended Decision Actions</h2>
            <p>Operational guidance generated from live workforce indicators and readiness trends.</p>
        </div>

        <div class="grid three">
            @foreach($recommendations as $recommendation)
                <article class="compact-card wi-action-card">
                    <i class="fas fa-arrow-trend-up"></i>
                    <strong>{{ $recommendation['title'] }}</strong>
                    <span>{{ $recommendation['text'] }}</span>
                </article>
            @endforeach
        </div>
    </div>
</section>

<style>
    .wi-hero {
        background:
            radial-gradient(circle at 20% 20%, rgba(0, 141, 59, .14), transparent 34%),
            radial-gradient(circle at 78% 18%, rgba(229, 138, 0, .18), transparent 30%),
            linear-gradient(145deg, #031128, #0b1d33 62%, #10294a);
        color: #fff;
        padding: clamp(2.4rem, 6vw, 4.8rem) 0;
    }

    .wi-hero-grid {
        display: grid;
        grid-template-columns: minmax(320px, 1.1fr) minmax(320px, .9fr);
        gap: 1rem;
        align-items: center;
    }

    .wi-copy h1 {
        margin: .7rem 0 1rem;
        font-size: clamp(2rem, 4.8vw, 3.8rem);
        line-height: 1.03;
        max-width: 16ch;
        color: #fff;
    }

    .wi-copy p {
        margin: 0;
        max-width: 60ch;
        color: #dbeafe;
        line-height: 1.7;
        font-weight: 600;
    }

    .wi-actions {
        margin-top: 1.4rem;
        display: flex;
        gap: .8rem;
        flex-wrap: wrap;
    }

    .wi-actions .btn-secondary {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .32);
        color: #fff;
    }

    .wi-snapshot {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .22);
        color: #fff;
        backdrop-filter: blur(8px);
    }

    .wi-snapshot-head {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: .8rem;
        margin-bottom: .8rem;
    }

    .wi-snapshot-head strong {
        font-size: 1rem;
        color: #fff;
    }

    .wi-snapshot-head small {
        color: #bfdbfe;
        font-size: .75rem;
    }

    .wi-snapshot-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .7rem;
    }

    .wi-snapshot-grid div {
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 8px;
        padding: .7rem;
        background: rgba(2, 6, 23, .3);
    }

    .wi-snapshot-grid span {
        display: block;
        font-size: .74rem;
        color: #bfdbfe;
    }

    .wi-snapshot-grid strong {
        display: block;
        margin-top: .2rem;
        color: #fff;
        font-size: 1.05rem;
    }

    .wi-mini-chart {
        margin-top: .9rem;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 8px;
        padding: .5rem;
        background: rgba(2, 6, 23, .25);
    }

    .wi-mini-chart .line-chart svg path:first-child { stroke: #fbbf24; }
    .wi-mini-chart .line-chart svg path:last-child { stroke: #34d399; }

    .wi-kpi-section {
        padding-top: 1.2rem;
    }

    .wi-kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .9rem;
    }

    .wi-kpi-card {
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 1rem;
        background: #fff;
        box-shadow: var(--shadow);
    }

    .wi-kpi-card span {
        display: block;
        color: var(--muted);
        font-size: .78rem;
        font-weight: 700;
    }

    .wi-kpi-card strong {
        display: block;
        margin: .3rem 0 .35rem;
        color: var(--blue);
        font-size: clamp(1.3rem, 2.4vw, 1.9rem);
    }

    .wi-kpi-card small {
        font-size: .73rem;
        font-weight: 800;
    }

    .wi-kpi-card .up { color: #0f9d58; }

    .wi-board {
        background: #f8fafc;
    }

    .wi-board-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .wi-wide {
        grid-column: span 2;
    }

    .wi-title-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: .8rem;
        margin-bottom: .9rem;
    }

    .wi-title-row h2 {
        margin: 0;
    }

    .wi-title-row span {
        color: var(--muted);
        font-size: .76rem;
        font-weight: 700;
    }

    .wi-sector-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .8rem;
    }

    .wi-sector-item {
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: .9rem;
        background: #fff;
    }

    .wi-sector-top {
        display: flex;
        justify-content: space-between;
        gap: .7rem;
        align-items: center;
    }

    .wi-sector-top strong {
        color: #0b1f52;
        font-size: .95rem;
    }

    .wi-sector-top span {
        font-size: .7rem;
        color: #0f9d58;
        border: 1px solid rgba(15, 157, 88, .25);
        padding: .22rem .45rem;
        border-radius: 999px;
        font-weight: 800;
    }

    .wi-sector-item small {
        display: block;
        margin: .4rem 0 .55rem;
        color: var(--muted);
        font-size: .74rem;
    }

    .wi-meter {
        width: 100%;
        height: 8px;
        margin-bottom: .45rem;
    }

    .wi-meter progress {
        width: 100%;
        height: 8px;
        display: block;
        border: 0;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .wi-meter progress::-webkit-progress-bar {
        background: #e2e8f0;
        border-radius: 999px;
    }

    .wi-meter progress::-webkit-progress-value {
        border-radius: 999px;
        background: linear-gradient(90deg, #0f9d58, #0b1d33);
    }

    .wi-meter progress::-moz-progress-bar {
        border-radius: 999px;
        background: linear-gradient(90deg, #0f9d58, #0b1d33);
    }

    .wi-sector-item p {
        margin: 0;
        color: #334155;
        font-size: .8rem;
        font-weight: 700;
    }

    .wi-sector-item ul {
        margin: .55rem 0 0;
        padding-left: 1rem;
        color: #475569;
        font-size: .78rem;
        line-height: 1.45;
    }

    .wi-region-grid {
        display: grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 1rem;
    }

    .wi-region-pills {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem;
        margin-bottom: .85rem;
    }

    .wi-region-pills button {
        border: 1px solid var(--border);
        background: #fff;
        color: #334155;
        padding: .5rem .7rem;
        border-radius: 999px;
        font-weight: 800;
        font-size: .74rem;
        cursor: pointer;
        transition: all .2s ease;
    }

    .wi-region-pills button.active {
        color: #fff;
        background: #0b1d33;
        border-color: #0b1d33;
    }

    .wi-region-details {
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: .95rem;
        background: #fff;
    }

    .wi-region-details h3 {
        margin: 0;
        color: #0b1f52;
    }

    .wi-region-details p {
        margin: .5rem 0 .7rem;
        color: #475569;
        font-size: .9rem;
    }

    .wi-region-metrics {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .6rem;
        margin-bottom: .7rem;
    }

    .wi-region-metrics span {
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: .55rem;
        color: #334155;
        font-size: .8rem;
        font-weight: 700;
    }

    .wi-region-metrics strong {
        color: #0b1f52;
        margin-left: .35rem;
    }

    .wi-region-details ul {
        margin: 0;
        padding-left: 1rem;
        color: #475569;
        font-size: .84rem;
        line-height: 1.5;
    }

    .wi-recommendations {
        background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
    }

    .wi-action-card i {
        color: #0f9d58;
    }

    @media (max-width: 1080px) {
        .wi-hero-grid,
        .wi-board-grid,
        .wi-region-grid {
            grid-template-columns: 1fr;
        }

        .wi-wide {
            grid-column: auto;
        }

        .wi-kpi-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .wi-kpi-grid,
        .wi-sector-grid,
        .wi-region-metrics {
            grid-template-columns: 1fr;
        }

        .wi-title-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .wi-actions .btn {
            width: 100%;
        }
    }
</style>

<script id="regionData" type="application/json">@json(collect($regions)->keyBy('code'))</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const regionDataNode = document.getElementById('regionData');
        const regions = regionDataNode ? JSON.parse(regionDataNode.textContent) : {};
        const buttons = document.querySelectorAll('[data-region-btn]');
        const detailBox = document.getElementById('regionDetails');
        const rolesBox = document.getElementById('regionRoles');

        function renderRegion(code) {
            const data = regions[code];
            if (!data || !detailBox || !rolesBox) {
                return;
            }

            detailBox.querySelector('h3').textContent = data.name;
            detailBox.querySelector('p').textContent = data.focus;

            const metrics = detailBox.querySelectorAll('.wi-region-metrics strong');
            if (metrics.length >= 2) {
                metrics[0].textContent = data.opportunity + '%';
                metrics[1].textContent = data.growth;
            }

            rolesBox.innerHTML = '';
            data.roles.forEach(function (role) {
                const li = document.createElement('li');
                li.textContent = role;
                rolesBox.appendChild(li);
            });
        }

        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                buttons.forEach(function (b) { b.classList.remove('active'); });
                button.classList.add('active');
                renderRegion(button.getAttribute('data-region-btn'));
            });
        });
    });
</script>
@endsection
