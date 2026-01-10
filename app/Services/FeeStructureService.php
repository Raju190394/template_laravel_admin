<?php

namespace App\Services;

use App\Models\FeeStructure;

class FeeStructureService
{
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
