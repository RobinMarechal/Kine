<?php

use Helpers\JsVar;
use Helpers\Template;
use Illuminate\Database\Eloquent\Collection;

$nbOfNotifications = Template::getNbOfNotifications();

$isCurrentPageHomePage = false;
if (Route::currentRouteName() === "home" || Route::currentRouteName() === "home") {
	$isCurrentPageHomePage = true;
}
$contentBootstrapClassCol = "col-lg-9";
//$contentBootstrapClassCol = $isCurrentPageHomePage ? "col-lg-12" : "col-lg-8";

$events = new Collection();

?>

		<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}"/>
{{--	<link rel="stylesheet" type="text/css" href="{{ url('css/font-awesome.min.css') }}"/>--}}
	{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">--}}


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<script src="{{ url('/js/bootbox.min.js') }}"></script>
	<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=6dsidl73nkp1p71n04g9rr7dieh5e1whc8kp1ju40t4wzgn4"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
	<script src="">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            Editor.prepare($('[data-toggle="editor"]'));
            $('.alert').delay(2500).fadeOut(700, function () {
                $(this).remove();
            })
        });

        $(document).on('focusin', function (e) {
            if ($(e.target).closest(".mce-window").length) {
                e.stopImmediatePropagation();
            }
        });
	</script>

	<title>Kine | @section('title') Accueil @show </title>
</head>
<body class="bg-white">

@include('layouts.partials.header.nav')

@include('layouts.partials.header.banner')