<div class="bg-white p-3 mb-3 card-header">
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
            <h1 class="mt-0">{{ $page_title }}

                @if (isset($page_title_small))
                    <small class="text-secondary">{{ $page_title_small }}</small>
                @endif
            </h1>
        </div>

        <div class="col-4 pt-2 text-end">

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


            @if (!isset($stats) && isset($buttons_right))

                @foreach ($buttons_right as $button)
                    <a @if (isset($button['route'])) href="{{ $button['route'] }}" @endif
                        class="btn {{ $button['class'] }}" {{ isset($button['data']) ? $button['data'] : '' }}>
                        @if (isset($button['icon']))
                            <i class="fa {{ $button['icon'] }}" aria-hidden="true"></i>
                        @endif
                        {{ $button['label'] }}
                    </a>
                @endforeach

            @endif
        </div>


    </div>

    @if (isset($buttons) || isset($buttons_right))
            <div class="container">
        <div class="row my-3">

                @if (isset($buttons))
                    <div class="col">
                        @foreach ($buttons as $button)
                            <a @if (isset($button['route'])) href="{{ $button['route'] }}" @endif
                                class="btn {{ $button['class'] }}" {{ isset($button['data'])? $button['data'] : '' }}>
                                @if (isset($button['icon']))
                                    <i class="fa {{ $button['icon'] }}" aria-hidden="true"></i>
                                @endif
                                {{ $button['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif

                @if (isset($stats) && isset($buttons_right))
                    <div class="col text-end">
                        @foreach ($buttons_right as $button)
                            <a @if (isset($button['route'])) href="{{ $button['route'] }}" @endif
                                class="btn {{ $button['class'] }}" {{ isset($button['data'])? $button['data'] : '' }}>
                                @if (isset($button['icon']))
                                    <i class="fa {{ $button['icon'] }}" aria-hidden="true"></i>
                                @endif
                                {{ $button['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif


</div>
