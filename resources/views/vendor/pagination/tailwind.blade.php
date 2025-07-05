@if ($paginator->hasPages())
    <nav aria-label="Pagination">
        <div class="flex justify-center">
            <ul class="inline-flex items-center -space-x-px rounded-md shadow-sm">
                {{-- Tombol Halaman Pertama (<<) --}}
                @if ($paginator->onFirstPage())
                    <li class="disabled" aria-disabled="true">
                        <span class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-l-md">««</span>
                    </li>
                @else
                    <li>
                        {{-- DITAMBAHKAN KELAS HOVER --}}
                        <a href="{{ $paginator->url(1) }}" class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md transition-colors duration-200 hover:bg-green-600 hover:text-white" aria-label="Go to first page">««</a>
                    </li>
                @endif

                {{-- Tombol Sebelumnya (<) --}}
                @if ($paginator->onFirstPage())
                    <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </li>
                @else
                    <li>
                        {{-- DITAMBAHKAN KELAS HOVER --}}
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 transition-colors duration-200 hover:bg-green-600 hover:text-white" aria-label="@lang('pagination.previous')">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                @endif

                {{-- Elemen Angka Halaman --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled" aria-disabled="true"><span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active" aria-current="page">
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-green-600">{{ $page }}</span>
                                </li>
                            @else
                                <li>
                                    {{-- INI SUDAH KITA PERBAIKI SEBELUMNYA --}}
                                    <a href="{{ $url }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 transition-colors duration-200 hover:bg-green-600 hover:text-white">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Tombol Selanjutnya (>) --}}
                @if ($paginator->hasMorePages())
                    <li>
                        {{-- DITAMBAHKAN KELAS HOVER --}}
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 transition-colors duration-200 hover:bg-green-600 hover:text-white" aria-label="@lang('pagination.next')">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                @else
                    <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </li>
                @endif
                
                {{-- Tombol Halaman Terakhir (>>) --}}
                 @if ($paginator->hasMorePages())
                    <li>
                        {{-- DITAMBAHKAN KELAS HOVER --}}
                        <a href="{{ $paginator->url($paginator->lastPage()) }}" class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md transition-colors duration-200 hover:bg-green-600 hover:text-white" aria-label="Go to last page">»»</a>
                    </li>
                @else
                    <li class="disabled" aria-disabled="true">
                        <span class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-r-md">»»</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif