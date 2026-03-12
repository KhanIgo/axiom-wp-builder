<?php
/**
 * Cleanup plugin data on uninstall.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('axiom_wp_builder_settings');

$postTypes = ['axiom_template', 'axiom_popup'];

foreach ($postTypes as $postType) {
    $posts = get_posts(
        [
            'post_type' => $postType,
            'post_status' => 'any',
            'posts_per_page' => -1,
            'fields' => 'ids',
        ]
    );

    foreach ($posts as $postId) {
        wp_delete_post((int) $postId, true);
    }
}
