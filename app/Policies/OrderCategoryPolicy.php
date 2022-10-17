<?php

namespace App\Policies;

use App\Models\{OrderCategory, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('order_category_index');
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param OrderCategory $orderCategory
     * @return bool
     */
    public function view(User $user, OrderCategory $orderCategory): bool
    {
        return $user->hasPermission('order_category_index');
    }

    /**
     * Determine whether the user can create models.
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('order_category_create');
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param OrderCategory $orderCategory
     * @return bool
     */
    public function update(User $user, OrderCategory $orderCategory): bool
    {
        return $user->hasPermission('order_category_update');
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param OrderCategory $orderCategory
     * @return bool
     */
    public function delete(User $user, OrderCategory $orderCategory): bool
    {
        return $user->hasPermission('order_category_delete');
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param OrderCategory $orderCategory
     * @return bool
     */
    public function restore(User $user, OrderCategory $orderCategory): bool
    {
        return $user->hasPermission('order_category_delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param OrderCategory $orderCategory
     * @return bool
     */
    public function forceDelete(User $user, OrderCategory $orderCategory): bool
    {
        return false;
    }
}
