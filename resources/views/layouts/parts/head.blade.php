
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/pikaday.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/libs/colors-2.2.0.min.css">
    {{--    <link rel="stylesheet" type="text/css" href="{{url('css/hover.min.css')}}"/>--}}

    <script src="/js/libs/jquery-3.2.1.min.js"></script>
    <script src="/js/libs/bootstrap-3.3.7.min.js"></script>
    <script defer src="/js/libs/bootbox-4.4.0.min.js"></script>
    <script src="/js/libs/tinymce/tinymce.min.js"></script>
    <script defer src="/js/libs/pikaday-1.6.1.min.js"></script>
    <script src="/js/libs/fontawesome-all.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{url('css/css.css')}}"/>

    <title>La Santé en Mouvement | @section('title') {{ $title }} @show </title>
</head>