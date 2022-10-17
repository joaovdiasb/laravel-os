<?php

namespace App\Policies;

use App\Models\{Order, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * @param  User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function view(User $user, Order $order): bool
    {
        return $user->client_id === null || $order->registered_id === $user->id || $order->registered->client_id === $user->client_id;
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function show(User $user, Order $order): bool
    {
        return $user->client_id === null || $order->registered_id === $user->id || $order->registered->client_id === $user->client_id;
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
     * @param Order $order
     * @return bool
     */
    public function update(User $user, Order $order): bool
    {
        return $user->hasPermission('order_update') && $order->order_situation_id !== 5;
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function updateFlow(User $user, Order $order): bool
    {
        return $order->order_situation_id !== 5 && ($user->client_id === null || $order->registered_id === $user->id || $order->registered->client_id === $user->client_id);
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->hasPermission('order_delete');
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->hasPermission('order_delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }
}
