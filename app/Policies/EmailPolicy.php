<?php

namespace App\Policies;

use App\Models\User;
use App\Models\email;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailPolicy
{
    use HandlesAuthorization;



    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\email  $email
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, email $email)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\email  $email
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, email $email)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\email  $email
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, email $email)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\email  $email
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, email $email)
    {
        //
    }
}
