@if ($paginator->hasPages())

<!-- Pagination -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <ul class="pagination-wrap">

                        {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled d-none" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="ti-angle-left"></i></a>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="ti-angle-left"></i></a>
                </li>
            @endif
                     
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li  aria-current="page"><a href="{{ $url }}" class="active">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach   
                        
                        {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="ti-angle-right" ></i></a>
                </li>
            @else
                <li class="d-none" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <a href="{{ $paginator->nextPageUrl() }}" class="disabled" rel="next" aria-label="@lang('pagination.next')"><i class="ti-angle-right" ></i></a>
                </li>
            @endif
                    </ul>
                </div>
            </div>
    
@endif
