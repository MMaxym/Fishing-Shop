@php
    use Illuminate\Support\Facades\Request;

    $query = Request::except('page');
    $queryString = http_build_query($query);
    $append = $queryString ? '&' . $queryString : '';
@endphp

@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li>
                    <span style="
                       background-color: var(--main-light);
                       display: flex;
                       justify-content: center;
                       align-items: center;
                       text-decoration: none;
                       width: 40px;
                       height: 40px;
                       border-radius: 50%;
                       border: 1px solid var(--light-2);
                       color: var(--light-1);
                       transition: all 0.3s;">
                        <img src="{{ asset('images/v2/icon/ArrowSmallLeftPagination.svg') }}" alt="ByIcon" style="width: 20px; height: 20px; opacity: 0.3;">
                    </span>
                </li>
            @else
                <li>
                    <a id="button-paggination-left" href="{{ $paginator->url($paginator->currentPage() - 1) . $append }}" rel="prev">
                        <img src="{{ asset('images/v2/icon/ArrowSmallLeftPagination.svg') }}" alt="ByIcon" style="width: 20px; height: 20px;">
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url . $append }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a id="button-paggination" href="{{ $paginator->url($paginator->currentPage() + 1) . $append }}" rel="next">
                        <img src="{{ asset('images/v2/icon/ArrowSmallRightPagination.svg') }}" alt="ByIcon" style="width: 20px; height: 20px;">
                    </a>
                </li>
            @else
                <li>
                    <span style="
                       background-color: var(--main-light);
                       display: flex;
                       justify-content: center;
                       align-items: center;
                       text-decoration: none;
                       width: 40px;
                       height: 40px;
                       border-radius: 50%;
                       border: 1px solid var(--light-2);
                       color: var(--light-1);
                       transition: all 0.3s;">
                        <img src="{{ asset('images/v2/icon/ArrowSmallRightPagination.svg') }}" alt="ByIcon" style="width: 20px; height: 20px; opacity: 0.3;">
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
