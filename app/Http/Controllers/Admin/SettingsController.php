<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();

        return Inertia::render('Admin/Settings/Edit', [
            'setting' => $setting ,
        ]);
    }

    public function update(Request $request)
    {
        dd($request->input());
    }
}
