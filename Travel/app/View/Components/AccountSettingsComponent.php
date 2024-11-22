<?php

namespace App\View\Components;

use App\Models\Profile;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AccountSettingsComponent extends Component
{
    public $profileUser;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->profileUser = Profile::getByUserId(Auth::id());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.account-settings-component',['profileUser',$this->profileUser]);
    }
}
