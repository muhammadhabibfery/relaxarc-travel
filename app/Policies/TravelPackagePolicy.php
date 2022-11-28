<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TravelPackage;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TravelPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelPackage  $travelPackage
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TravelPackage $travelPackage)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelPackage  $travelPackage
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TravelPackage $travelPackage)
    {
        return $travelPackage->date_departure_available
            ? Response::allow()
            : Response::deny('errors.403.text', 403);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelPackage  $travelPackage
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TravelPackage $travelPackage)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelPackage  $travelPackage
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TravelPackage $travelPackage)
    {
        return $this->update($user, $travelPackage);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TravelPackage  $travelPackage
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TravelPackage $travelPackage)
    {
        //
    }
}
