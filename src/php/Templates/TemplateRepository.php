<?php
/**
 * Template CRUD abstraction.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Templates;

use WP_Post;
use WP_Query;

final class TemplateRepository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function list(int $perPage = 20, int $page = 1): array
    {
        $query = new WP_Query(
            [
                'post_type' => 'axiom_template',
                'post_status' => ['publish', 'draft'],
                'posts_per_page' => max(1, $perPage),
                'paged' => max(1, $page),
                'orderby' => 'modified',
                'order' => 'DESC',
            ]
        );

        $items = [];
        foreach ($query->posts as $post) {
            if (! $post instanceof WP_Post) {
                continue;
            }
            $items[] = $this->hydrate($post);
        }

        return $items;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function get(int $id): ?array
    {
        $post = get_post($id);
        if (! $post instanceof WP_Post || $post->post_type !== 'axiom_template') {
            return null;
        }

        return $this->hydrate($post);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>|null
     */
    public function create(array $payload): ?array
    {
        $postId = wp_insert_post(
            [
                'post_type' => 'axiom_template',
                'post_status' => isset($payload['status']) ? sanitize_key((string) $payload['status']) : 'draft',
                'post_title' => sanitize_text_field((string) ($payload['title'] ?? __('Untitled Template', 'axiom-wp-builder'))),
            ],
            true
        );

        if (is_wp_error($postId) || ! is_int($postId)) {
            return null;
        }

        $this->saveMeta($postId, $payload);

        return $this->get($postId);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>|null
     */
    public function update(int $id, array $payload): ?array
    {
        $post = get_post($id);
        if (! $post instanceof WP_Post || $post->post_type !== 'axiom_template') {
            return null;
        }

        $updateData = [
            'ID' => $id,
        ];

        if (isset($payload['title'])) {
            $updateData['post_title'] = sanitize_text_field((string) $payload['title']);
        }

        if (isset($payload['status'])) {
            $updateData['post_status'] = sanitize_key((string) $payload['status']);
        }

        $result = wp_update_post($updateData, true);
        if (is_wp_error($result)) {
            return null;
        }

        $this->saveMeta($id, $payload);

        return $this->get($id);
    }

    public function delete(int $id): bool
    {
        $post = get_post($id);
        if (! $post instanceof WP_Post || $post->post_type !== 'axiom_template') {
            return false;
        }

        return wp_delete_post($id, true) !== false;
    }

    /**
     * @return array<string, mixed>
     */
    private function hydrate(WP_Post $post): array
    {
        return [
            'id' => $post->ID,
            'title' => $post->post_title,
            'status' => $post->post_status,
            'elements' => get_post_meta($post->ID, '_axiom_elements', true),
            'conditions' => get_post_meta($post->ID, '_axiom_conditions', true),
            'settings' => get_post_meta($post->ID, '_axiom_template_settings', true),
            'css' => get_post_meta($post->ID, '_axiom_css', true),
            'updatedAt' => $post->post_modified_gmt,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function saveMeta(int $postId, array $payload): void
    {
        if (array_key_exists('elements', $payload)) {
            update_post_meta($postId, '_axiom_elements', wp_json_encode($payload['elements']));
        }

        if (array_key_exists('conditions', $payload)) {
            update_post_meta($postId, '_axiom_conditions', wp_json_encode($payload['conditions']));
        }

        if (array_key_exists('settings', $payload)) {
            update_post_meta($postId, '_axiom_template_settings', wp_json_encode($payload['settings']));
        }

        if (array_key_exists('css', $payload)) {
            update_post_meta($postId, '_axiom_css', wp_kses_post((string) $payload['css']));
            update_post_meta($postId, '_axiom_css_timestamp', time());
        }
    }
}
