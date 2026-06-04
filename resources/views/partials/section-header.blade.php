<div class="section-header">
    <span class="eyebrow">{{ $eyebrow ?? 'TSEA Platform' }}</span>
    <h2>{{ $title }}</h2>
    @isset($copy)
        <p>{{ $copy }}</p>
    @endisset
</div>
