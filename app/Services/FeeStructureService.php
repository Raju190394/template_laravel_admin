<?php

namespace App\Services;

use App\Models\FeeStructure;

class FeeStructureService
{
    public function getFeeStructures($paginate = 10)
    {
        return \App\Models\FeeStructure::with('class')->latest()->paginate($paginate);
    }

    public function getFormData()
    {
        return [
            'classes' => \App\Models\Classes::active()->select('class_name')->distinct()->get(),
        ];
    }

    public function createFeeStructure(array $data)
    {
        return FeeStructure::create($data);
    }

    public function updateFeeStructure(FeeStructure $feeStructure, array $data)
    {
        return $feeStructure->update($data);
    }

    public function deleteFeeStructure(FeeStructure $feeStructure)
    {
        return $feeStructure->delete();
    }
}
