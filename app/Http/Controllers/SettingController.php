<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch current values from .env
        $settings = [
            'PUSHER_APP_ID'     => env('PUSHER_APP_ID'),
            'PUSHER_APP_KEY'    => env('PUSHER_APP_KEY'),
            'PUSHER_APP_SECRET' => env('PUSHER_APP_SECRET'),
            'PUSHER_APP_CLUSTER' => env('PUSHER_APP_CLUSTER'),
            'PUSHER_PORT' => env('PUSHER_PORT'),
            'PUSHER_SCHEME' => env('PUSHER_SCHEME'),

            'MAIL_MAILER'       => env('MAIL_MAILER'),
            'MAIL_HOST'         => env('MAIL_HOST'),
            'MAIL_PORT'         => env('MAIL_PORT'),
            'MAIL_USERNAME'     => env('MAIL_USERNAME'),
            'MAIL_PASSWORD'     => env('MAIL_PASSWORD'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME'    => env('MAIL_FROM_NAME'),
        ];
        return view('pages.settings.index', compact('settings'));
    }

    public function update(UpdateSettingRequest $request)
    {
        try {
            $path = base_path('.env');
            $env = File::get($path);
            foreach ($request->validated() as $key => $value) {
                $escaped = preg_quote($key, '/');

                if (preg_match("/^{$escaped}=.*/m", $env)) {
                    $env = preg_replace("/^{$escaped}=.*/m", "{$key}=\"{$value}\"", $env);
                } else {
                    $env .= "\n{$key}=\"{$value}\"";
                }
            }
            File::put($path, $env);
            Artisan::call('config:clear');

            return back()->with('success', 'Settings updated successfully and configuration reloaded!');
        } catch (\Exception $e) {
            logger()->error("Failed to update settings", ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
