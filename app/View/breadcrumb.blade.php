<div class="card-header">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach ($links as $link)
                <li class="breadcrumb-item"><a
                        @if (isset($link['url'])) href="{{ $link['url'] }}" @endif>{{ $link['name'] }}</a></li>
            @endforeach
        </ol>
    </nav>
    <div class="row">
        <div class="col-8">
            <h1>{{ $page_title }}

                @if (isset($page_title_small))
                    <small class="text-secondary">{{ $page_title_small }}</small>
                @endif
            </h1>
        </div>

        <div class="col-4 pt-4 text-end">

            @if (isset($stats))
                <small class='text-end text-muted fs-4'>

                    @foreach ($stats as $stat)
                        @if (!$loop->first)
                            |
                        @endif
                        {{ $stat['label'] }}: {{ $stat['value'] }}
                    @endforeach

                </small>
            @endif

        </div>
    </div>
</div>
