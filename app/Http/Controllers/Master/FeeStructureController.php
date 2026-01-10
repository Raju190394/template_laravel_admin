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
        $feeStructures = FeeStructure::with('class')->latest()->paginate(10);
        return view('master.fee-structures.index', compact('feeStructures'));
    }

    public function create()
    {
        $classes = Classes::active()->select('class_name')->distinct()->get();
        return view('master.fee-structures.create', compact('classes'));
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
        $classes = Classes::active()->select('class_name')->distinct()->get();
        $currentClassName = $feeStructure->class->class_name ?? '';
        return view('master.fee-structures.edit', compact('feeStructure', 'classes', 'currentClassName'));
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
