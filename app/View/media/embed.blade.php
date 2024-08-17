<html>

<head>
    <base href="{{ config('app.url') }}" />
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" type="image/png" href="resources/images/icons/favicon16.png" />

        @foreach ($css as $each_css)
            <link rel="stylesheet" type="text/css" href="{{ url($each_css) }}">
        @endforeach

        <script type="text/javascript" src="{{ asset('resources/js/main.js') }}" defer></script>

        @yield('head')

        @foreach ($js as $each_js)
            <script type="text/javascript" src="{{ asset($each_js) }}" defer></script>
        @endforeach

        @foreach ($jsplugins as $each_js)
            <script type="text/javascript" src="{{ asset($each_js) }}" defer></script>
        @endforeach

</head>

<body>
    <div id="hcms">
        @include('media.filemanager', ['mode' => 'embed'])
    </div>

</body>

</html>
