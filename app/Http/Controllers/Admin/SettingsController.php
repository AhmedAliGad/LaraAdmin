<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    /**
     * @var Setting
     */
    private $setting;

    public function __construct()
    {
        $this->setting = Setting::first();
    }
    public function edit(Request $request)
    {
        if ($request->filled('target') && in_array($request->get('target'), ['privacy', 'terms'])) {
            if ($request->get('target') == 'privacy') {
                return Inertia::render('Admin/Settings/Privacy', [
                    'setting' => $this->setting ,
                ]);
            } else {
                return Inertia::render('Admin/Settings/Terms', [
                    'setting' => $this->setting ,
                ]);
            }
        } else {
            $types = collect([['title' => 'facebook'], ['title' => 'twitter'], ['title' => 'youtube'],
                ['title' => 'website'], ['title' => 'instagram'], ['title' => 'snapchat'],
                ['title' => 'linkedin'], ['title' => 'tiktok']]);

            return Inertia::render('Admin/Settings/Edit', [
                'setting' => $this->setting ,
                'types' => $types
            ]);
        }
    }

    public function update(Request $request)
    {
        $this->setting->update($request->input());

        return redirect()->back()->with('message', 'Updated Successfully.');
    }
}
