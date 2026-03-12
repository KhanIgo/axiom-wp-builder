<?php
/**
 * Widgets REST endpoints.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Rest;

use WP_REST_Response;

final class WidgetsController
{
    private const NAMESPACE = 'axiom/v1';

    public static function registerRoutes(): void
    {
        register_rest_route(
            self::NAMESPACE,
            '/widgets',
            [
                [
                    'methods' => 'GET',
                    'callback' => [self::class, 'listWidgets'],
                    'permission_callback' => [RestAuth::class, 'canEdit'],
                ],
            ]
        );
    }

    public static function listWidgets(): WP_REST_Response
    {
        $widgets = [
            ['name' => 'heading', 'title' => __('Heading', 'axiom-wp-builder'), 'category' => 'basic'],
            ['name' => 'text-editor', 'title' => __('Text Editor', 'axiom-wp-builder'), 'category' => 'basic'],
            ['name' => 'image', 'title' => __('Image', 'axiom-wp-builder'), 'category' => 'basic'],
            ['name' => 'button', 'title' => __('Button', 'axiom-wp-builder'), 'category' => 'basic'],
            ['name' => 'tabs', 'title' => __('Tabs', 'axiom-wp-builder'), 'category' => 'content'],
            ['name' => 'accordion', 'title' => __('Accordion', 'axiom-wp-builder'), 'category' => 'content'],
            ['name' => 'video', 'title' => __('Video', 'axiom-wp-builder'), 'category' => 'media'],
            ['name' => 'form', 'title' => __('Form', 'axiom-wp-builder'), 'category' => 'forms'],
        ];

        /**
         * Filter available widgets.
         *
         * @param array<int, array<string, string>> $widgets Widget descriptors.
         */
        $widgets = (array) apply_filters('axiom/widgets/register', $widgets);

        return new WP_REST_Response(['items' => array_values($widgets)], 200);
    }
}
