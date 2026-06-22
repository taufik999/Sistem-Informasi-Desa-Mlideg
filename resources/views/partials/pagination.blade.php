@if ($paginator->hasPages())
    <div class="pagination">
        <div class="page-info">
            Menampilkan {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </div>
        <div class="page-links">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="page-link" style="opacity: 0.5; cursor: not-allowed;"><i class="fa-solid fa-angle-left"></i></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="fa-solid fa-angle-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-link" style="pointer-events: none;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="fa-solid fa-angle-right"></i></a>
            @else
                <span class="page-link" style="opacity: 0.5; cursor: not-allowed;"><i class="fa-solid fa-angle-right"></i></span>
            @endif
        </div>
    </div>
@else
    <div class="pagination">
        <div class="page-info">
            Menampilkan {{ $paginator->count() }} data
        </div>
    </div>
@endif
