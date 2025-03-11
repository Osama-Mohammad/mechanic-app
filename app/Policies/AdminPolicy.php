<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AdminPolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(?Admin $admin): bool
    {
        return $admin !== null; // Ensure it's checking the 'admin' guard
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin): bool
    {
        return true; // Adjust logic as needed
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return true; // Adjust logic as needed
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin): bool
    {
        return true; // Adjust logic as needed
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return true; // Adjust logic as needed
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin): bool
    {
        return true; // Adjust logic as needed
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin): bool
    {
        return true; // Adjust logic as needed
    }
}
