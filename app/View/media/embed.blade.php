<html>

<head>
    <base href="{{ config('app.url') }}" />
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <link rel="shortcut icon" type="image/png" href="resources/images/icons/favicon16.png" />

</head>

<body>
    <div id="hcms">
        @include('media.filemanager')

        @foreach ($css as $each_css)
            <link rel="stylesheet" type="text/css" href="{{ url($each_css) }}">
        @endforeach

        @foreach ($js as $each_js)
            <script type="text/javascript" src="{{ url($each_js) }}"></script>
        @endforeach
    </div>

</body>

</html>
