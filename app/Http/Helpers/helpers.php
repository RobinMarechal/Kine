<?php

use App\Http\Controllers\NewsController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

function isAdmin()
{
    $user = Auth::user();

    return isset($user) && $user->is_doctor === 1;
}


function getGoogleConfigs()
{
    return Config::get('services.google');
}


function getGoogleApiKey()
{
    return getGoogleConfigs()['api_key'];
}


function getTimeString($time, $withSeconds = false)
{
    if (!isset($time)) {
        return null;
    }

    $time = Carbon::parse($time);

    $format = 'H:i';
    if ($withSeconds) {
        $format .= ':s';
    }

    return $time->format($format);
}


function array_set_if_not_exists(array &$array, $key, $val)
{
    if (!array_key_exists($key, $array)) {
        $array[$key] = $val;
    }
}


function generateButton($type, $dataNamespace, $dataId, array $attrs = [], $addClasses = '', $icon = 'pencil', $faOrGlyph = 'glyphicon', $tag = 'button')
{
    $attrs['data-namespace'] = $dataNamespace;
    $attrs['data-id'] = $dataId;

    if ($type === 'remove' || $type === 'delete') {
        $attrs['class'] = 'btn btn-edit btn-primary remove-data btn-remove trash ' . $addClasses;
    }
    else {
        $attrs['class'] = 'btn btn-edit btn-primary update-data ' . $addClasses;
    }

    if (array_key_exists('title', $attrs)) {
        array_set_if_not_exists($attrs, 'data-toggle', 'tooltip');
        array_set_if_not_exists($attrs, 'data-placement', 'top');
    }

    $attrStr = '';

    foreach ($attrs as $k => $v) {
        $attrStr .= " $k='$v'";
    }

    $iconClasses = glyph($icon, $faOrGlyph);

    return "<$tag $attrStr><i aria-hidden='true' class='$iconClasses'></i></$tag>";
}


/**
 * @param $obj
 * @param $frenchName ex: "la rubrique", "la news", "l'article"
 * @return string the edit and remove buttons
 */
function controlButtons($obj, $frenchName){
    $str = editButton($obj, ['title' => "Modifier $frenchName"]);
    $str .= "\n" . removeButton($obj, ['title' => "Supprimer $frenchName"]);
    return $str;
}

function editButton($obj, array $attrs = [], $addClasses = '', $icon = 'pencil', $faOrGlyph = 'glyphicon', $tag = 'button')
{
    return generateButton("edit", relatedNamespaceOf($obj), $obj->id, $attrs, $addClasses, $icon, $faOrGlyph, $tag);
}


function removeButton($obj, array $attrs = [], $addClasses = '', $icon = 'trash', $faOrGlyph = 'glyphicon', $tag = 'button')
{
    return generateButton("remove", relatedNamespaceOf($obj), $obj->id, $attrs, "btn-remove $addClasses", $icon, $faOrGlyph, $tag);
}

function addButton($class, array $attrs = [], $addClasses = '', $icon = 'plus', $faOrGlyph = 'glyphicon', $tag = 'a')
{
    $attrs['data-namespace'] = relatedNamespaceOf($class);
    $attrs['class'] = 'create-data create-new create-about title-btn-hover';

    if (array_key_exists('title', $attrs)) {
        array_set_if_not_exists($attrs, 'data-toggle', 'tooltip');
        array_set_if_not_exists($attrs, 'data-placement', 'top');
    }

    $attrStr = '';

    foreach ($attrs as $k => $v) {
        $attrStr .= " $k='$v'";
    }

    $iconClasses = glyph($icon, $faOrGlyph);

    return "<$tag $attrStr><i aria-hidden='true' class='$iconClasses'></i></$tag>";
}


function printButtonContent($name, array $attrs = [], $addClasses = '', $glyphicon = 'pencil', $glyphType = "glyphicon", $tag = 'button')
{
    if (isAdmin()) {
        $attrStr = '';
        if (!empty($attrs)) {
            if (array_has($attrs, 'title')) {
                if (!array_has($attrs, 'data-toggle')) {
                    $attrs['data-toggle'] = 'tooltip';
                }

                if (!array_has($attrs, 'data-placement')) {
                    $attrs['data-placement'] = 'top';
                }
            }
            foreach ($attrs as $a => $v) {
                if ($a != 'class') {
                    $attrStr .= ' ' . $a . '="' . $v . '"';
                }
            }
        }

        $str = "<$tag $attrStr data-name='$name' class='btn btn-edit btn-primary $addClasses'><span class='" . glyph($glyphicon, $glyphType) . "'></span></$tag>";
        return $str;
    }
}


function printButton($name, $glyphicon = 'pencil', array $attrs = [], $addClasses = '')
{
    if (Auth::check() && (Auth::user()->is_doctor || Auth::user()->level > 0)) {
        $attrStr = '';
        if (!empty($attrs)) {
            foreach ($attrs as $a => $v) {
                if ($a != 'class') {
                    $attrStr .= ' ' . $a . '="' . $v . '"';
                }
            }
        }
        $str = '<button' . $attrStr . ' data-name="' . $name . '" class="btn btn-edit btn-primary ' . $addClasses . '"><span class="glyphicon glyphicon-' . $glyphicon . '"></span></button>';

        return $str;
    }
}


function printButtonTrashRestore($id, array $attrs = [], $addClasses = '')
{
    $attrStr = '';
    if (!empty($attrs)) {
        foreach ($attrs as $a => $v) {
            if ($a != 'class') {
                $attrStr .= ' ' . $a . '="' . $v . '"';
            }
        }
    }
    $str = '<button' . $attrStr . ' data-id="' . $id . '" class="btn btn-edit btn-primary ' . $addClasses . '"><span class="glyphicon glyphicon-pencil"></span></button>';

    return $str;
}

function only($str, $length){
    if(isset($str[$length - 1])){
        return substr($str, 0, $length) . "...";
    }

    return $str;
}


function cut($str, $n, $link = false)
{
    $string = $str;
    if (strlen($str) > $n) {
        $substr = substr($str, 0, $n);
        $left = '<i><span data-toggle="tooltip" data-placement="right" title="Cliquez sur le titre de la news pour la voir en entier" class="cutting-dots">.....</span></i>';
        if ($link != false) {
            $left = '<a title="Cliquez pour voir la suite" href="' . url($link) . '">' . $left . '</a>';
        }
        $string = $substr . $left . '</p>';
    }

    return $string;
}


function glyph($str, $type = 'glyphicon')
{
    return "$type $type-$str";
}


function getWeekDay($date = "")
{
    if ($date == "") {
        $date = strtotime(date("Y-m-d"));
    }
    $day = date('N', $date) - 1;

    return day($day);
}


function printDay($id, $three = false)
{
    return day($id, $three);
}


/**
 * print a link which leads to $user's profile
 *
 * @param \App\User $user    : user's instance
 * @param string    $classes : tag classes
 *
 * @return string $link : HTML tag <a>
 */
function printUserLink(App\User $user, $classes = '')
{
    $name = $user->first_name . ' ' . $user->last_name;

    $link = '<a class="' . $classes . '" href="' . url('users/show/' . $user->id) . '">' . $name . '</a>';

    return $link;
}


/**
 * print a link which leads to $team's page
 *
 * @param \App\Team $team    : team's instance
 * @param string    $classes : tag classes
 *
 * @return string $link : HTML tag <a>
 */
function printTeamLink(App\Team $team, $classes = '')
{
    $link = '<a class="' . $classes . '" href="' . url('teams/show/' . $team->slug) . '">' . $team->name . '</a>';

    return $link;
}


/**
 * Get the current datetime with format 'Y-m-d H:i:s'
 * Example : '2017-05-23 16:15:30'
 * @return string the current datetime of format 'Y-m-d H:i:s'
 */
function getCurrentDatetime()
{
    return Carbon::now()
                 ->format('Y-m-d H:i:s');
}


function singular($str)
{
    if (ends_with($str, 'ies')) {
        return substr($str, 0, strlen($str) - 3) . 'y';
    }
    else if (ends_with($str, 's')) {
        return substr($str, 0, strlen($str) - 1);
    }

    return $str;
}


function getRelatedModelClassName(\App\Http\Controllers\Controller $controller)
{
    if ($controller instanceof NewsController) {
        return 'App\\News';
    }

    $fullName = get_class($controller);
    $reducedName = str_replace('Controller', '', array_last(explode('\\', $fullName)));

    return 'App\\' . singular($reducedName);
}


function isAdminZone()
{
    return strpos(Route::current()->uri, 'admin') !== false;
}


function generateRandomNumberString($nbNumbers)
{
    $str = "";
    for ($i = 0; $i < $nbNumbers; $i++) {
        $str .= rand(0, 9);
    }

    return $str;
}

function simpleClassNameOf($class){
    if(is_object($class)){
        $class = get_class($class);
    }

    return last(explode("\\", $class));
}

function relatedNamespaceOf($class){
    return str_plural(snake_case(simpleClassNameOf($class)));
}