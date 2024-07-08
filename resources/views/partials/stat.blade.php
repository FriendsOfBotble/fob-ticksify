<div class="fob-ticksify-stats">
    <div class="fob-ticksify-stat-item">
        <div class="row">
            <div class="col-7">
                <span class="fob-ticksify-stat-title">{{ $title }}</span>
                <h3 class="fob-ticksify-stat-count">{{ number_format($count) }}</h3>
            </div>
            <div class="col-5">
                <div class="fob-ticksify-stat-icon">
                    <x-core::icon :name="$icon" class="text-{{ $color }}" />
                </div>
            </div>
        </div>
    </div>
</div>
