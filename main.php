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

add_action(
    'aipress_tests',
    function () {
        // prompt('test', ['dd' => 'dd']);
    }
);

function prompt($text = '', $args_custom = []): string
{
    $url = 'https://openrouter.ai/api/v1/chat/completions';
    $args = array_merge([
        'model' => 'deepseek/deepseek-chat',
        'messages' => [
            [
                'role' => 'user',
                'content' => $text
            ]
        ]
    ], $args_custom);

    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . Settings::get('api_key')
    ];

    $response = wp_remote_request(
        $url,
        [
            'method' => 'POST',
            'headers' => $headers,
            'body' => json_encode($args)
        ]
    );
    if (is_wp_error($response)) {
        return $response->get_error_message();
    }

    $result = json_decode(wp_remote_retrieve_body($response), true);

    return $result['choices'][0]['message']['content'];
}

foreach (glob(__DIR__ . '/includes/*.php') as $file) {
    require_once $file;
}

// Main::init();

class Main
{
    public static function init()
    {

    }
}