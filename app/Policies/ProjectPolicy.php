<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view the project.
     * Public projects are viewable by anyone.
     */
    public function view(?User $user, Project $project)
    {
        return true; // public viewing allowed
    }

    /**
     * Determine whether the user can create a project.
     */
    public function create(User $user)
    {
        return true; // any authenticated user can create
    }

    /**
     * Determine whether the user can update the project.
     * Only the owner (uid) can update.
     */
    public function update(User $user, Project $project)
    {
        return $project->uid === $user->id;
    }

    /**
     * Determine whether the user can delete the project.
     * Only the owner can delete.
     */
    public function delete(User $user, Project $project)
    {
        return $project->uid === $user->id;
    }
}
