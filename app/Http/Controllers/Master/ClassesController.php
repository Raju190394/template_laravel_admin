<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ClassStoreRequest;
use App\Http\Requests\Master\ClassUpdateRequest;
use App\Models\Classes;
use App\Services\ClassesService;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    protected $classesService;

    public function __construct(ClassesService $classesService)
    {
        $this->classesService = $classesService;
    }

    public function index()
    {
        $classes = $this->classesService->getClasses();
        return view('master.classes.index', compact('classes'));
    }

    public function store(ClassStoreRequest $request)
    {
        $this->classesService->createClass($request->validated());

        return redirect()->route('master.classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function show(Classes $class)
    {
        $class->load('feeStructures');
        return view('master.classes.show', compact('class'));
    }

    public function edit(Classes $class)
    {
        return view('master.classes.edit', compact('class'));
    }

    public function update(ClassUpdateRequest $request, Classes $class)
    {
        $this->classesService->updateClass($class, $request->validated());

        return redirect()->route('master.classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(Classes $class)
    {
        $this->classesService->deleteClass($class);

        return redirect()->route('master.classes.index')
            ->with('success', 'Class deleted successfully.');
    }
}
