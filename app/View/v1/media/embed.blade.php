<html>
<head>
  <base href="{{ Config::get('app.url') }}" />
  <title>{{ $title }} - {{ Config::get('app.name') }}</title>
  <link rel="shortcut icon" type="image/png" href="resources/images/icons/favicon16.png"/>

  @foreach ($css as $each_css)
      <link rel="stylesheet" type="text/css" href="{{url($each_css)}}">
  @endforeach

  @foreach ($js as $each_js)
        <script type="text/javascript" src="{{url($each_js)}}"></script>
  @endforeach

</head>

@include('media.filemanager')

</html>