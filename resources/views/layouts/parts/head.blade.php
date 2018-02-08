
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/hover.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('css/pikaday.min.css') }}"/>
    <link rel=stylesheet href="https://s3-us-west-2.amazonaws.com/colors-css/2.2.0/colors.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=6dsidl73nkp1p71n04g9rr7dieh5e1whc8kp1ju40t4wzgn4"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

    <link rel="stylesheet" type="text/css" href="{{url('css/css.css')}}"/>

    <title>La Santé en Mouvement | @section('title') {{ $title }} @show </title>
</head>