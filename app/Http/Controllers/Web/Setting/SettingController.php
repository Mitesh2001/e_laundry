<?php

namespace App\Http\Controllers\Web\Setting;

use App\Models\Setting;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Repositories\SettingRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingRepo;
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepo = $settingRepository;
    }

    public function pushNotifications()
    {
        return view('settings.push_notifications');
    }

    public function show($slug)
    {
        $setting = $this->settingRepo->findBySlug($slug);

        return view('settings.index', compact('setting'));
    }

    public function edit($slug)
    {
        $setting = $this->settingRepo->findBySlug($slug);

        return view('settings.edit', compact('setting'));
    }

    public function update(SettingRequest $request, Setting $setting)
    {
        $this->settingRepo->updateByRequest($request, $setting);

        return back();
    }

    public function notifyUsers(Request $request)
    {
        if ($request->users == 'all_users') {
            $users = User::all();

            $notificationDetails =  [
                'title' => "New Notification",
                'message' => $request->notification_content
            ];

            foreach($users as $user) {
                (new OrderRepository())->sendNotificationByRequest($user->id,$notificationDetails);
                (new OrderRepository())->sendPushNotification($user->id,$notificationDetails);
            }

        }

        return back();
    }

}
