@extends('layouts.app2')
@include('inc.style')
@include('inc.navbar')

@section('content')
@include('inc.title')
@unless ($response->successful())
<table>
    <tr>
        <th>{{$errorMsg}}</th>
    </tr>
</table>
@endunless

@if ($response->successful())
<img src="{{ $dataUri }}" alt="Image">
@endif

@endsection