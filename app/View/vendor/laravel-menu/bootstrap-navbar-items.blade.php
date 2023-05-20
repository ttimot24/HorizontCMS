@foreach ($items as $item)
    <li class="nav-item  {{ $item->hasChildren() ? 'dropdown"' : '' }}">
        @if ($item->link)
            <a @if ($item->hasChildren()) class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"
            @else
                class="nav-link" @endif
                href="{!! $item->url() !!}"> {!! $item->title !!}

                @if ($item->hasChildren())
                    <b class="caret"></b>
                @endif

            </a>
        @else
            <span class="navbar-text">{!! $item->title !!}</span>
        @endif

        @if ($item->hasChildren())
            <ul class="dropdown-menu bg-dark m-0">
                @include(config('laravel-menu.views.bootstrap-items'), ['items' => $item->children()])
            </ul>
        @endif

    </li>

    @if ($item->divider)
        <li {!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
    @endif
@endforeach
