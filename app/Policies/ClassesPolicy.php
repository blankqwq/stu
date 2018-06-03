<?php

namespace App\Policies;

use App\User;
use App\Classes;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the classes.
     *
     * @param  \App\User  $user
     * @param  \App\Classes  $classes
     * @return mixed
     */
    public function view(User $user, Classes $classes)
    {
        //
    }

    /**
     * Determine whether the user can create classes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the classes.
     *
     * @param  \App\User  $user
     * @param  \App\Classes  $classes
     * @return mixed
     */
    public function update(User $user, Classes $classes)
    {
        //
    }

    /**
     * Determine whether the user can delete the classes.
     *
     * @param  \App\User  $user
     * @param  \App\Classes  $classes
     * @return mixed
     */
    public function delete(User $user, Classes $classes)
    {
        //
    }

    public function classhome(User $user, Classes $classes){

//        return 1;
        return $user->classes()->wherePivot('class_id',$classes->id)->count()>0;
    }
}
