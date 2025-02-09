<?php


namespace AIPress;

Settings::init();
class Settings
{
    public static function init(): void
    {
        add_action('admin_menu', __CLASS__ . '::add_settings');
        add_action('admin_init', __CLASS__ . '::page_init');

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

    public static function page_init()
    {
        register_setting(
            'aipress_option_group',
            'aipress_config',
        );

        add_settings_section(
            'default',
            'Base Settings',
            function () {
                echo 'TBD';
            },
            'aipress-settings-admin'
        );

        add_settings_field(
            'id_number',
            'ID Number',
            function () {
                echo 'TBD';
            },
            'aipress-settings-admin',
        );

    }
}