<?php
/**
 * Plugin Name: Axiom WP Builder
 * Plugin URI: https://example.com/axiom-wp-builder
 * Description: Performance-focused visual WordPress page builder with full feature access.
 * Version: 0.1.0
 * Author: Axiom Development Team
 * Author URI: https://example.com
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Text Domain: axiom-wp-builder
 * Domain Path: /languages
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

define('AXIOM_WP_BUILDER_VERSION', '0.1.0');
define('AXIOM_WP_BUILDER_FILE', __FILE__);
define('AXIOM_WP_BUILDER_PATH', plugin_dir_path(__FILE__));
define('AXIOM_WP_BUILDER_URL', plugin_dir_url(__FILE__));

require_once AXIOM_WP_BUILDER_PATH . 'src/php/Core/Autoloader.php';

\AxiomWPBuilder\Core\Autoloader::register();

register_activation_hook(
    AXIOM_WP_BUILDER_FILE,
    static function (): void {
        \AxiomWPBuilder\Core\Plugin::activate();
    }
);

register_deactivation_hook(
    AXIOM_WP_BUILDER_FILE,
    static function (): void {
        \AxiomWPBuilder\Core\Plugin::deactivate();
    }
);

add_action(
    'plugins_loaded',
    static function (): void {
        \AxiomWPBuilder\Core\Plugin::instance()->boot();
    }
);
