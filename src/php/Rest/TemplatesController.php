<?php
/**
 * Templates REST endpoints.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Rest;

use AxiomWPBuilder\Templates\TemplateRepository;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

final class TemplatesController
{
    private const NAMESPACE = 'axiom/v1';

    public static function registerRoutes(): void
    {
        register_rest_route(
            self::NAMESPACE,
            '/templates',
            [
                [
                    'methods' => 'GET',
                    'callback' => [self::class, 'listTemplates'],
                    'permission_callback' => [RestAuth::class, 'canEdit'],
                ],
                [
                    'methods' => 'POST',
                    'callback' => [self::class, 'createTemplate'],
                    'permission_callback' => [RestAuth::class, 'canEdit'],
                ],
            ]
        );

        register_rest_route(
            self::NAMESPACE,
            '/templates/(?P<id>\d+)',
            [
                [
                    'methods' => 'GET',
                    'callback' => [self::class, 'getTemplate'],
                    'permission_callback' => [RestAuth::class, 'canEdit'],
                ],
                [
                    'methods' => 'PUT,PATCH',
                    'callback' => [self::class, 'updateTemplate'],
                    'permission_callback' => [RestAuth::class, 'canEdit'],
                ],
                [
                    'methods' => 'DELETE',
                    'callback' => [self::class, 'deleteTemplate'],
                    'permission_callback' => [RestAuth::class, 'canEdit'],
                ],
            ]
        );
    }

    /**
     * @return WP_REST_Response
     */
    public static function listTemplates(WP_REST_Request $request): WP_REST_Response
    {
        $repo = new TemplateRepository();
        $items = $repo->list((int) $request->get_param('perPage'), (int) $request->get_param('page'));

        return new WP_REST_Response(['items' => $items], 200);
    }

    /**
     * @return WP_REST_Response|WP_Error
     */
    public static function getTemplate(WP_REST_Request $request)
    {
        $repo = new TemplateRepository();
        $item = $repo->get((int) $request['id']);

        if ($item === null) {
            return new WP_Error('axiom_template_not_found', __('Template not found.', 'axiom-wp-builder'), ['status' => 404]);
        }

        return new WP_REST_Response($item, 200);
    }

    /**
     * @return WP_REST_Response|WP_Error
     */
    public static function createTemplate(WP_REST_Request $request)
    {
        $repo = new TemplateRepository();
        $payload = self::normalizePayload($request);
        $item = $repo->create($payload);

        if ($item === null) {
            return new WP_Error('axiom_template_create_failed', __('Unable to create template.', 'axiom-wp-builder'), ['status' => 400]);
        }

        do_action('axiom/template/after_save', (int) $item['id'], $payload);

        return new WP_REST_Response($item, 201);
    }

    /**
     * @return WP_REST_Response|WP_Error
     */
    public static function updateTemplate(WP_REST_Request $request)
    {
        $repo = new TemplateRepository();
        $templateId = (int) $request['id'];
        $payload = self::normalizePayload($request);

        do_action('axiom/template/before_save', $templateId, $payload);

        $item = $repo->update($templateId, $payload);
        if ($item === null) {
            return new WP_Error('axiom_template_update_failed', __('Unable to update template.', 'axiom-wp-builder'), ['status' => 400]);
        }

        do_action('axiom/template/after_save', $templateId, $payload);

        return new WP_REST_Response($item, 200);
    }

    /**
     * @return WP_REST_Response|WP_Error
     */
    public static function deleteTemplate(WP_REST_Request $request)
    {
        $repo = new TemplateRepository();
        $deleted = $repo->delete((int) $request['id']);

        if (! $deleted) {
            return new WP_Error('axiom_template_delete_failed', __('Unable to delete template.', 'axiom-wp-builder'), ['status' => 400]);
        }

        return new WP_REST_Response(['deleted' => true], 200);
    }

    /**
     * @return array<string, mixed>
     */
    private static function normalizePayload(WP_REST_Request $request): array
    {
        $params = $request->get_json_params();
        if (! is_array($params)) {
            $params = [];
        }

        $payload = [];

        if (array_key_exists('title', $params)) {
            $payload['title'] = sanitize_text_field((string) $params['title']);
        }

        if (array_key_exists('status', $params)) {
            $allowedStatus = ['draft', 'publish', 'private'];
            $status = sanitize_key((string) $params['status']);
            $payload['status'] = in_array($status, $allowedStatus, true) ? $status : 'draft';
        }

        foreach (['elements', 'conditions', 'settings'] as $jsonField) {
            if (array_key_exists($jsonField, $params)) {
                $payload[$jsonField] = $params[$jsonField];
            }
        }

        if (array_key_exists('css', $params)) {
            $payload['css'] = (string) $params['css'];
        }

        return $payload;
    }
}
