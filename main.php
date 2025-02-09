<?php
/*
Plugin Name: @ AI Press
Description: AI agent for WordPress
Author: AI
Author URI: https://github.com/aiiddqd/aipress
License: GPL-2.0+
Version: 0.250209
Domain Path: /languages
Text Domain: aipress
*/

namespace AIPress;

Main::init();

class Main
{
    public static function init()
    {
        foreach (glob(__DIR__ . '/includes/*.php') as $file) {
            require_once $file;
        }
    }
}