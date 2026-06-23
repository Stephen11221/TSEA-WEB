<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    /**
     * Determine if the user can view any applications.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can view the application.
     */
    public function view(User $user, Application $application): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can update the application.
     */
    public function update(User $user, Application $application): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can download the application's resume.
     */
    public function downloadResume(User $user, Application $application): bool
    {
        return $user->isAdmin();
    }
}
