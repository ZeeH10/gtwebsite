<?php

namespace App\Filament\Concerns;

use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

/**
 * Role-based access for a Filament resource. Every Filament permission check
 * (view, create, edit, delete…) routes through getAuthorizationResponse().
 *
 *   protected static array $roles = [...];          // may view and edit
 *   protected static array $managerRoles = [...];   // optional: may also create/delete (defaults to $roles)
 *
 * Row-level limits (e.g. home group leaders) are applied in each resource's getEloquentQuery().
 */
trait RestrictedToRoles
{
    public static function getAuthorizationResponse(string|UnitEnum $action, ?Model $record = null): Response
    {
        $action = $action instanceof UnitEnum ? $action->name : $action;
        $managing = in_array($action, ['create', 'delete', 'deleteAny', 'forceDelete', 'forceDeleteAny', 'replicate'], true);
        $roles = $managing && property_exists(static::class, 'managerRoles') ? static::$managerRoles : static::$roles;

        return auth()->user()?->hasRole(...$roles) ? Response::allow() : Response::deny();
    }
}
