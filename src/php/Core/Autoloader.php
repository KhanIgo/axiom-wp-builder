<?php
/**
 * PSR-4-like autoloader for plugin classes.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Core;

final class Autoloader
{
    private const PREFIX = 'AxiomWPBuilder\\';

    public static function register(): void
    {
        spl_autoload_register([self::class, 'autoload']);
    }

    /**
     * @param string $className Fully-qualified class name.
     */
    private static function autoload(string $className): void
    {
        if (strpos($className, self::PREFIX) !== 0) {
            return;
        }

        $relativeClass = substr($className, strlen(self::PREFIX));
        $relativePath  = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
        $filePath      = AXIOM_WP_BUILDER_PATH . 'src/php/' . $relativePath;

        if (is_readable($filePath)) {
            require_once $filePath;
        }
    }
}
