<?php
/**
 * Settings REST endpoints.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Rest;

use WP_REST_Request;
use WP_REST_Response;

final class SettingsController
{
    private const NAMESPACE = 'axiom/v1';
    private const OPTION_KEY = 'axiom_wp_builder_settings';

    public static function registerRoutes(): void
    {
        register_rest_route(
            self::NAMESPACE,
            '/settings',
            [
                [
                    'methods' => 'GET',
                    'callback' => [self::class, 'getSettings'],
                    'permission_callback' => [RestAuth::class, 'canManageOptions'],
                ],
                [
                    'methods' => 'PUT,PATCH',
                    'callback' => [self::class, 'updateSettings'],
                    'permission_callback' => [RestAuth::class, 'canManageOptions'],
                ],
            ]
        );
    }

    public static function getSettings(): WP_REST_Response
    {
        $settings = get_option(self::OPTION_KEY, []);
        if (! is_array($settings)) {
            $settings = [];
        }

        return new WP_REST_Response(['settings' => $settings], 200);
    }

    public static function updateSettings(WP_REST_Request $request): WP_REST_Response
    {
        $params = $request->get_json_params();
        $settings = is_array($params) ? $params : [];

        $normalized = [
            'defaultLayoutWidth' => isset($settings['defaultLayoutWidth']) ? absint($settings['defaultLayoutWidth']) : 1200,
            'contentWidth' => isset($settings['contentWidth']) ? absint($settings['contentWidth']) : 1140,
            'breakpoints' => isset($settings['breakpoints']) && is_array($settings['breakpoints']) ? $settings['breakpoints'] : [],
            'customCss' => isset($settings['customCss']) ? (string) $settings['customCss'] : '',
            'customJs' => isset($settings['customJs']) ? (string) $settings['customJs'] : '',
        ];

        update_option(self::OPTION_KEY, $normalized, false);

        return new WP_REST_Response(['settings' => $normalized], 200);
    }
}
