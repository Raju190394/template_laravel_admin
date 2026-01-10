<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\SchoolSettingUpdateRequest;
use App\Models\SchoolSetting;
use App\Services\SchoolSettingService;
use Illuminate\Http\Request;

class SchoolSettingController extends Controller
{
    protected $schoolSettingService;

    public function __construct(SchoolSettingService $schoolSettingService)
    {
        $this->schoolSettingService = $schoolSettingService;
    }

    public function index()
    {
        $settings = SchoolSetting::first();
        return view('master.school-settings.index', compact('settings'));
    }

    public function store(SchoolSettingUpdateRequest $request)
    {
        $this->schoolSettingService->updateOrCreateSettings($request->validated());

        return redirect()->route('master.school-settings.index')
            ->with('success', 'School settings saved successfully.');
    }

    public function edit(SchoolSetting $school_setting)
    {
        return view('master.school-settings.edit', compact('school_setting'));
    }

    public function update(SchoolSettingUpdateRequest $request, SchoolSetting $school_setting)
    {
        $this->schoolSettingService->updateOrCreateSettings($request->validated());

        return redirect()->route('master.school-settings.index')
            ->with('success', 'School settings updated successfully.');
    }
}
