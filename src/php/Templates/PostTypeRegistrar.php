<?php
/**
 * Register plugin post types.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Templates;

final class PostTypeRegistrar
{
    public static function register(): void
    {
        register_post_type(
            'axiom_template',
            [
                'labels' => [
                    'name' => __('Axiom Templates', 'axiom-wp-builder'),
                    'singular_name' => __('Axiom Template', 'axiom-wp-builder'),
                ],
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => false,
                'supports' => ['title', 'revisions'],
                'capability_type' => 'post',
                'menu_icon' => 'dashicons-layout',
            ]
        );

        register_post_type(
            'axiom_popup',
            [
                'labels' => [
                    'name' => __('Axiom Popups', 'axiom-wp-builder'),
                    'singular_name' => __('Axiom Popup', 'axiom-wp-builder'),
                ],
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => false,
                'supports' => ['title', 'revisions'],
                'capability_type' => 'post',
                'menu_icon' => 'dashicons-welcome-widgets-menus',
            ]
        );
    }
}
