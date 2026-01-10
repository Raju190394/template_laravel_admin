<?php

namespace App\Services;

use App\Models\SchoolSetting;
use Illuminate\Support\Facades\Storage;

class SchoolSettingService
{
    public function updateOrCreateSettings(array $data)
    {
        $settings = SchoolSetting::first();

        if (request()->hasFile('logo')) {
            if ($settings && $settings->logo) {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = request()->file('logo')->store('logos', 'public');
        }

        if ($settings) {
            $settings->update($data);
            return $settings;
        }

        return SchoolSetting::create($data);
    }
}
