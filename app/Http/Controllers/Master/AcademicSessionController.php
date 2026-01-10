<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use Illuminate\Http\Request;

use App\Http\Requests\AcademicSessionStoreRequest;
use App\Services\AcademicSessionService;

class AcademicSessionController extends Controller
{
    protected $sessionService;

    public function __construct(AcademicSessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = $this->sessionService->getAllSessions();
        return view('master.academic-sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.academic-sessions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicSessionStoreRequest $request)
    {
        $this->sessionService->createSession($request->validated(), $request->has('is_current'));

        return redirect()->route('master.academic-sessions.index')
            ->with('success', 'Academic Session created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicSession $academicSession)
    {
        return view('master.academic-sessions.show', compact('academicSession'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicSession $academicSession)
    {
        return view('master.academic-sessions.edit', compact('academicSession'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicSessionStoreRequest $request, AcademicSession $academicSession)
    {
        $this->sessionService->updateSession($academicSession, $request->validated(), $request->has('is_current'));

        return redirect()->route('master.academic-sessions.index')
            ->with('success', 'Academic Session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicSession $academicSession)
    {
        try {
            $this->sessionService->deleteSession($academicSession);
            return redirect()->route('master.academic-sessions.index')
                ->with('success', 'Academic Session deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
