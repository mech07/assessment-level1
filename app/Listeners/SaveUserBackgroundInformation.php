<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\Services\UserServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveUserBackgroundInformation
{
    protected $userService;
    /**
     * Create the event listener.
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     */
    public function handle(UserSaved $event)
    {

        // Extract user attributes
        $user = $event->user;

        // Save user details
        $this->userService->saveUserDetails($user);
    }




}
