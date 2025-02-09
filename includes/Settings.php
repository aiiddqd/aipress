<?php


namespace AIPress;

Settings::init();
class Settings
{
    public static function init(): void
    {
        add_action('admin_menu', __CLASS__ . '::add_settings');
        add_action('admin_init', __CLASS__ . '::init_settings');

    }

    public static function get($key): mixed
    {
        $config = apply_filters('aipress_config', get_option('aipress_config', []));
        return $config[$key] ?? null;
    }

    public static function set($key, $value): void
    {
        $config = get_option('aipress_config', []);
        $config[$key] = $value;
        update_option('aipress_config', $config);
    }

    public static function add_settings(): void
    {
        // Add settings page
        add_options_page(
            'AIPress Settings Admin',
            'AIPress',
            'manage_options',
            'aipress-settings',
            __CLASS__ . '::create_admin_page'
        );

    }

    public static function create_admin_page(): void
    {
        // Display page
        ?>
        <div class="wrap">
            <h2>AIPress</h2>
            <p>Use hook <code>add_filter( 'aipress_config', function( $config ) { ... } )</code> to change the settings.</p>
            <?php settings_errors(); ?>

            <form method="post" action="options.php">
                <?php
                settings_fields('aipress_option_group');
                do_settings_sections('aipress-settings-admin');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public static function get_form_field_name($key = null): string
    {
        if (empty($key)) {
            return 'aipress_config';
        }

        return sprintf(
            'aipress_config[%s]',
            sanitize_title_with_dashes($key)
        );
    }

    public static function init_settings()
    {
        register_setting(
            'aipress_option_group',
            self::get_form_field_name(),
        );

        add_settings_section(
            'default',
            'Base Settings',
            '__return_null',
            'aipress-settings-admin'
        );

        self::add_setting_for_api_key();

    }

    public static function add_setting_for_api_key()
    {
        $key = 'api_key';
        add_settings_field(
            $key,
            'API Key',
            function ($args) {
                printf(
                    '<input type="text" name="%s" value="%s" />',
                    esc_attr($args['name']),
                    esc_attr($args['value'])
                );
            },
            'aipress-settings-admin',
            'default',
            [
                'name' => Settings::get_form_field_name($key),
                'value' => Settings::get($key) ?? null,
            ]
        );
    }
}