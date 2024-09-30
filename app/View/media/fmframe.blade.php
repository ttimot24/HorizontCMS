@extends('layout', ['title' => trans('File Manager')])

@section('content')

@include('media.filemanager', ['mode' => ''])

@endsection