@if($paginator->hasPages())
    <div class="d-flex justify-content-center mb-3">
        @if(view()->exists(Theme::getThemeNamespace('partials.pagination')))
            {{ $paginator->links(Theme::getThemeNamespace('partials.pagination')) }}
        @else
            {{ $paginator->links() }}
        @endif
    </div>
@endif
