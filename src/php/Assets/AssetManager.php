<?php
/**
 * Asset loading for admin and frontend.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Assets;

final class AssetManager
{
    public static function register(): void
    {
        add_action('admin_menu', [self::class, 'registerAdminPage']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueueAdminAssets']);
        add_action('wp_enqueue_scripts', [self::class, 'enqueueFrontendAssets']);
    }

    public static function registerAdminPage(): void
    {
        add_menu_page(
            __('Axiom Builder', 'axiom-wp-builder'),
            __('Axiom Builder', 'axiom-wp-builder'),
            'axiom_edit',
            'axiom-wp-builder',
            [self::class, 'renderAdminPage'],
            'dashicons-layout',
            58
        );
    }

    public static function renderAdminPage(): void
    {
        echo '<div class="wrap axiom-builder-admin">';
        echo '<h1>' . esc_html__('Axiom WP Builder', 'axiom-wp-builder') . '</h1>';
        echo '<div id="axiom-editor-app" data-endpoint="' . esc_url_raw(rest_url('axiom/v1')) . '"></div>';
        echo '</div>';
    }

    public static function enqueueAdminAssets(string $hook): void
    {
        if ($hook !== 'toplevel_page_axiom-wp-builder') {
            return;
        }

        wp_enqueue_style(
            'axiom-admin',
            AXIOM_WP_BUILDER_URL . 'assets/css/admin.css',
            [],
            AXIOM_WP_BUILDER_VERSION
        );

        wp_enqueue_script(
            'axiom-editor',
            AXIOM_WP_BUILDER_URL . 'assets/js/editor.js',
            [],
            AXIOM_WP_BUILDER_VERSION,
            true
        );

        wp_localize_script(
            'axiom-editor',
            'AxiomBuilderConfig',
            [
                'restUrl' => esc_url_raw(rest_url('axiom/v1')),
                'nonce' => wp_create_nonce('wp_rest'),
            ]
        );
    }

    public static function enqueueFrontendAssets(): void
    {
        wp_register_style(
            'axiom-frontend',
            AXIOM_WP_BUILDER_URL . 'assets/css/frontend.css',
            [],
            AXIOM_WP_BUILDER_VERSION
        );

        wp_register_script(
            'axiom-frontend',
            AXIOM_WP_BUILDER_URL . 'assets/js/frontend.js',
            [],
            AXIOM_WP_BUILDER_VERSION,
            true
        );
    }
}
