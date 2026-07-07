<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use App\Services\MediaService;
use App\Services\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /** Editable settings, keyed by group => [key => label]. */
    public const GROUPS = [
        'general' => [
            'company_name' => 'Company Name',
            'tagline' => 'Tagline',
            'mission' => 'Mission',
            'vision' => 'Vision',
        ],
        'contact' => [
            'address' => 'Address',
            'phone' => 'Phone',
            'email' => 'Email',
        ],
        'social' => [
            'facebook' => 'Facebook',
            'telegram' => 'Telegram',
            'github' => 'GitHub',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube',
            'instagram' => 'Instagram',
        ],
        'footer' => [
            'footer_text' => 'Footer Text',
            'copyright' => 'Copyright',
        ],
        'seo' => [
            'seo_title' => 'SEO Title',
            'seo_description' => 'SEO Description',
            'seo_keywords' => 'SEO Keywords',
            'analytics_code' => 'Analytics Code (script snippet)',
        ],
        'theme' => [
            'primary_color' => 'Primary Color',
            'secondary_color' => 'Secondary Color',
            'accent_color' => 'Accent Color',
            'font_family' => 'Font Family',
            'default_theme' => 'Default Theme (light / dark / auto)',
            'animations_enabled' => 'Animations Enabled (1 / 0)',
        ],
    ];

    public function __construct(protected MediaService $media)
    {
    }

    public function edit()
    {
        return view('admin.settings.edit', [
            'groups' => self::GROUPS,
            'values' => Settings::all(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'string', 'max:5000'],
            'logo_file' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg', 'max:4096'],
            'favicon_file' => ['nullable', 'image', 'mimes:png,webp,svg,jpeg', 'max:1024'],
        ]);

        $allowed = collect(self::GROUPS)->flatMap(fn ($fields, $group) => collect($fields)->keys()->mapWithKeys(fn ($key) => [$key => $group]));

        foreach ($request->input('settings', []) as $key => $value) {
            if ($allowed->has($key)) {
                WebsiteSetting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $allowed[$key]]);
            }
        }

        foreach (['logo' => 'logo_file', 'favicon' => 'favicon_file'] as $key => $input) {
            if ($request->hasFile($input)) {
                $stored = $this->media->store($request->file($input), 'brand');
                WebsiteSetting::updateOrCreate(['key' => $key], ['value' => $stored->path, 'group' => 'general']);
            }
        }

        Settings::flush();

        return back()->with('success', 'Settings saved.');
    }
}
