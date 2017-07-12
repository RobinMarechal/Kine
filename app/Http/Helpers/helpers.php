<?php

function getGoogleConfigs()
{
    return Config::get('services.google');
}

function getGoogleApiKey()
{
    return getGoogleConfigs()['api_key'];
}