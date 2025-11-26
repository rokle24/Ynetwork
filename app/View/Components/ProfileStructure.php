<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class ProfileStructure extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public User $profiledata)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile-structure');
    }
}
