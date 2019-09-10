<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
| 
| To get API details you have to create a Google Project
| at Google API Console (https://console.developers.google.com)
| 
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
// die($config);


$config['google']['client_id']        = '1062650776072-mrj05vrdmccdqvgki18iqoq96kju9m9h.apps.googleusercontent.com';
$config['google']['client_secret']    = 'mgOgNMVDGNUNwIgY2mBjE2Um';
$config['google']['redirect_uri']     = 'authentication/google';
$config['google']['application_name'] = 'Login to Ghahealth';
$config['google']['api_key']          = '';
$config['google']['scopes']           = array();