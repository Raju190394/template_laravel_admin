<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\FeeStructureStoreRequest;
use App\Http\Requests\Master\FeeStructureUpdateRequest;
use App\Models\FeeStructure;
use App\Models\Classes;
use App\Services\FeeStructureService;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    protected $feeStructureService;

    public function __construct(FeeStructureService $feeStructureService)
    {
        $this->feeStructureService = $feeStructureService;
    }

    public function index()
    {
        $feeStructures = $this->feeStructureService->getFeeStructures();
        return view('master.fee-structures.index', compact('feeStructures'));
    }

    public function create()
    {
        $formData = $this->feeStructureService->getFormData();
        return view('master.fee-structures.create', $formData);
    }

    public function store(FeeStructureStoreRequest $request)
    {
        $class = Classes::where('class_name', $request->class_name_select)->first();
        
        if (!$class) {
            return back()->withErrors(['class_name_select' => 'Invalid class selected.']);
        }

        $data = $request->validated();
        unset($data['class_name_select']);
        $data['class_id'] = $class->id;

        $this->feeStructureService->createFeeStructure($data);

        return redirect()->route('master.fee-structures.index')
            ->with('success', 'Fee structure created successfully.');
    }

    public function edit(FeeStructure $feeStructure)
    {
        $formData = $this->feeStructureService->getFormData();
        $currentClassName = $feeStructure->class->class_name ?? '';
        return view('master.fee-structures.edit', array_merge(compact('feeStructure', 'currentClassName'), $formData));
    }

    public function update(FeeStructureUpdateRequest $request, FeeStructure $feeStructure)
    {
        $class = Classes::where('class_name', $request->class_name_select)->first();
        
        if (!$class) {
            return back()->withErrors(['class_name_select' => 'Invalid class selected.']);
        }

        $data = $request->validated();
        unset($data['class_name_select']);
        $data['class_id'] = $class->id;

        $this->feeStructureService->updateFeeStructure($feeStructure, $data);

        return redirect()->route('master.fee-structures.index')
            ->with('success', 'Fee structure updated successfully.');
    }

    public function destroy(FeeStructure $feeStructure)
    {
        $this->feeStructureService->deleteFeeStructure($feeStructure);

        return redirect()->route('master.fee-structures.index')
            ->with('success', 'Fee structure deleted successfully.');
    }
}
