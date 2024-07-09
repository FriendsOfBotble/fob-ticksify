<x-core::stat-widget class="row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 mb-3">
    <x-core::stat-widget.item
        :label="trans('plugins/fob-ticksify::ticksify.total')"
        value="{{ $stats->total }}"
        color="primary"
        icon="ti ti-ticket"
        :url="$statUrl()"
    />

    <x-core::stat-widget.item
        :label="trans('plugins/fob-ticksify::ticksify.enums.statuses.open')"
        value="{{ $stats->open }}"
        color="success"
        icon="ti ti-check"
        :url="$statUrl('open')"
    />

    <x-core::stat-widget.item
        :label="trans('plugins/fob-ticksify::ticksify.enums.statuses.in_progress')"
        value="{{ $stats->in_progress }}"
        color="warning"
        icon="ti ti-reload"
        :url="$statUrl('in_progress')"
    />

    <x-core::stat-widget.item
        :label="trans('plugins/fob-ticksify::ticksify.enums.statuses.closed')"
        value="{{ $stats->closed }}"
        color="secondary"
        icon="ti ti-x"
        :url="$statUrl('closed')"
    />

    <x-core::stat-widget.item
        :label="trans('plugins/fob-ticksify::ticksify.enums.statuses.on_hold')"
        value="{{ $stats->on_hold }}"
        color="danger"
        icon="ti ti-hand-grab"
        :url="$statUrl('on_hold')"
    />
</x-core::stat-widget>
