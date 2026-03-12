<?php
/**
 * REST permissions helpers.
 *
 * @package AxiomWPBuilder
 */

declare(strict_types=1);

namespace AxiomWPBuilder\Rest;

final class RestAuth
{
    public static function canEdit(): bool
    {
        return current_user_can('axiom_edit') || current_user_can('manage_options');
    }

    public static function canManageOptions(): bool
    {
        return current_user_can('axiom_manage_options') || current_user_can('manage_options');
    }
}
