@if ($paginator->hasPages())
    <div class="mt-6 flex justify-center items-center">
        <div class="flex space-x-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-400 cursor-not-allowed text-sm">
                    &laquo;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="w-8 h-8 flex items-center justify-center rounded-full bg-green-700 text-white hover:bg-green-800 transition-colors text-sm">
                    &laquo;
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 text-sm">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-green-700 text-white font-medium text-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" 
                               class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-700 hover:bg-green-700 hover:text-white transition-colors text-sm">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="w-8 h-8 flex items-center justify-center rounded-full bg-green-700 text-white hover:bg-green-800 transition-colors text-sm">
                    &raquo;
                </a>
            @else
                <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-400 cursor-not-allowed text-sm">
                    &raquo;
                </span>
            @endif
        </div>
    </div>
@endif