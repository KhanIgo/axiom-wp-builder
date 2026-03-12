<?php
/**
 * Capabilities manager.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Core;

final class Capabilities
{
    /**
     * @return array<string>
     */
    public static function list(): array
    {
        $defaultCaps = [
            'axiom_edit',
            'axiom_design',
            'axiom_manage_options',
            'axiom_access_library',
        ];

        /**
         * Filter plugin capabilities.
         *
         * @param array<string> $defaultCaps Capability keys.
         */
        return (array) apply_filters('axiom/config/capabilities', $defaultCaps);
    }

    public static function addCapabilities(): void
    {
        $caps = self::list();

        $admin = get_role('administrator');
        $editor = get_role('editor');
        $author = get_role('author');

        foreach ($caps as $cap) {
            if ($admin !== null) {
                $admin->add_cap($cap);
            }
        }

        if ($editor !== null) {
            $editor->add_cap('axiom_edit');
            $editor->add_cap('axiom_design');
        }

        if ($author !== null) {
            $author->add_cap('axiom_edit');
        }
    }
}
