<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilePhotoRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\NotificationResource;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function update(UserRequest $request)
    {
        $user = (new UserRepository())->updateByRequest($request, auth()->user());

        return $this->json('Profile is updated successfully', [
            'user' => (new UserResource($user))
        ]);
    }
    public function updateProfilePhoto(ProfilePhotoRequest $request)
    {
        $user = (new UserRepository())->updateProfilePhotoByRequest($request, auth()->user());

        return $this->json('Profile photo is updated successfully', [
            'user' => (new UserResource($user))
        ]);
    }
    public function notificationsList()
    {
        $data = (new UserRepository())->getAllNotifications();
        $result = [];

        foreach ($data as $key => $notification) {
            $result[$key]['title'] = $notification->data['title'];
            $result[$key]['message'] = $notification->data['message'];
            $result[$key]['created_at'] = $notification->created_at;
        }

        return $this->json('All Notification fetched successfully !', [
            'notifications' => $result
        ]);
    }
}
