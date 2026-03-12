<?php
/**
 * Main plugin orchestrator.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Core;

use AxiomWPBuilder\Assets\AssetManager;
use AxiomWPBuilder\Rest\SettingsController;
use AxiomWPBuilder\Rest\TemplatesController;
use AxiomWPBuilder\Rest\WidgetsController;
use AxiomWPBuilder\Templates\PostTypeRegistrar;

final class Plugin
{
    private static ?self $instance = null;

    private bool $booted = false;

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function activate(): void
    {
        Capabilities::addCapabilities();
        PostTypeRegistrar::register();
        flush_rewrite_rules();
    }

    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }

    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        do_action('axiom/before_init');

        add_action('init', [PostTypeRegistrar::class, 'register']);
        add_action('init', [Capabilities::class, 'addCapabilities']);
        add_action('rest_api_init', [TemplatesController::class, 'registerRoutes']);
        add_action('rest_api_init', [SettingsController::class, 'registerRoutes']);
        add_action('rest_api_init', [WidgetsController::class, 'registerRoutes']);

        AssetManager::register();

        do_action('axiom/after_init');

        $this->booted = true;
    }

    private function __construct()
    {
    }
}
