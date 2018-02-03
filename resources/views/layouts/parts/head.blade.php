
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/hover.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('css/pikaday.min.css') }}"/>

    <link rel="stylesheet" type="text/css" href="{{url('css/css.css')}}"/>

    <title>La Santé en Mouvement | @section('title') {{ $title }} @show </title>
</head>