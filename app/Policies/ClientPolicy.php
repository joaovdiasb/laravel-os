<?php

namespace App\Policies;

use App\Models\{Client, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('client_index');
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param Client $client
     * @return bool
     */
    public function view(User $user, Client $client): bool
    {
        return $user->hasPermission('client_index');
    }

    /**
     * Determine whether the user can create models.
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('order_create');
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param Client $client
     * @return bool
     */
    public function update(User $user, Client $client): bool
    {
        return $user->hasPermission('client_update');
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param Client $client
     * @return bool
     */
    public function delete(User $user, Client $client): bool
    {
        return $user->hasPermission('client_delete');
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param Client $client
     * @return bool
     */
    public function restore(User $user, Client $client): bool
    {
        return $user->hasPermission('client_delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param Client $client
     * @return bool
     */
    public function forceDelete(User $user, Client $client): bool
    {
        return false;
    }
}
