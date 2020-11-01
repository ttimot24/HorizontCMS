<ol class="breadcrumb">
@foreach($panels as $each)
  <li><a href="{{ $each['link'] }}">{{ $each['name'] }}</a></li>
@endforeach
</ol>