@extends('layouts.app2')
<?php
    $themeConfig = app(\App\Services\ThemeConfig::class);
    $styleFile = $themeConfig->getThemeCssFile();
?>

@include("{$styleFile}")
@include('inc.navbar')

@section('content')
@include('inc.title')
<br><br>

    <form action="{{route('codestand.store')}}" method="post" enctype="multipart/form-data">
    @csrf

        Coding Standard Name :<input type="text" name="codestand_name" style="margin-left:2.5em">
        <div class="error"><font color="red" size="2">{{ $errors->first('codestand_name') }}</p></font></div>
        <br>
        

        <button type="submit">Add Coding Standard</button>
    </form>
 <br>
 @endsection