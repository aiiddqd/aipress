<?php

namespace AIPress;


Perplexity::init();

class Perplexity
{
    public static function prompt($text, $params = [])
    {
        $api_key = Settings::get('perplexity_api_key');

        $args = array_merge([
            'model' => 'sonar-pro',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $text
                ]
            ]
        ], $params);

        $url = 'https://api.perplexity.ai/chat/completions';
        $args = [
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $api_key",
            ],
            'body' => json_encode($args),
            'timeout' => 333,
        ];

        $response = wp_remote_request($url, $args);

        $body = json_decode(wp_remote_retrieve_body($response), true);

        return $body['choices'][0]['message']['content'];
    }

    public static function init()
    {
        add_action('admin_init', __CLASS__ . '::add_settings');
    }

    public static function add_settings()
    {
        $id = 'perplexity';
        add_settings_section(
            $id,
            'Perplexity',
            function () {
                echo (
                    '<p>App: <a href="https://www.perplexity.ai/" target="_blank" rel="noopener">https://www.perplexity.ai/</a></p>'
                );
            },
            'aipress-settings-admin'
        );

        self::add_setting_for_api_key();
    }

    public static function add_setting_for_api_key()
    {
        $key = 'perplexity_api_key';
        add_settings_field(
            $key,
            'Perplexity API key',
            function ($args) {
                printf(
                    '<input type="text" name="%s" value="%s" size="50" />',
                    esc_attr($args['name']),
                    esc_attr($args['value'])
                );

                echo ('<p>get key <a href="https://www.perplexity.ai/settings/api" target="_blank" rel="noopener">https://www.perplexity.ai/settings/api</a></p>');

            },
            'aipress-settings-admin',
            'perplexity',
            [
                'name' => Settings::get_form_field_name($key),
                'value' => Settings::get($key) ?? null,
            ]
        );
    }
}