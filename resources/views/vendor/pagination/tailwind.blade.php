@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">

        {{-- Mobile View --}}
        <div class="flex gap-2 items-center justify-between w-full sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-muted bg-white/70 border border-sand cursor-not-allowed rounded-lg shadow-xs">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink bg-white border border-sand rounded-lg shadow-xs transition hover:border-brand hover:text-brand">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-ink bg-white border border-sand rounded-lg shadow-xs transition hover:border-brand hover:text-brand">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-muted bg-white/70 border border-sand cursor-not-allowed rounded-lg shadow-xs">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between sm:gap-2 md:gap-4">
            <div class="shrink-0">
                <p class="text-xs md:text-sm text-muted">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-semibold text-ink">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-semibold text-ink">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-semibold text-ink">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div class="overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden py-1">
                <span class="inline-flex items-center gap-1 shrink-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="inline-flex items-center justify-center h-8 w-8 text-xs font-medium text-muted/50 bg-white/50 border border-sand/70 rounded-md cursor-not-allowed" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center h-8 w-8 text-xs font-medium text-ink bg-white border border-sand rounded-md transition hover:border-brand hover:text-brand hover:bg-cream-dark" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center justify-center h-8 px-2 text-xs font-medium text-muted bg-transparent">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center justify-center h-8 min-w-8 px-2.5 text-xs font-semibold text-white bg-brand border border-brand rounded-md shadow-xs">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center justify-center h-8 min-w-8 px-2.5 text-xs font-medium text-ink bg-white border border-sand rounded-md transition hover:border-brand hover:text-brand hover:bg-cream-dark" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center h-8 w-8 text-xs font-medium text-ink bg-white border border-sand rounded-md transition hover:border-brand hover:text-brand hover:bg-cream-dark" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="inline-flex items-center justify-center h-8 w-8 text-xs font-medium text-muted/50 bg-white/50 border border-sand/70 rounded-md cursor-not-allowed" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
