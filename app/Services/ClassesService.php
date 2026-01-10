<?php

namespace App\Services;

use App\Models\Classes;

class ClassesService
{
    public function createClass(array $data)
    {
        return Classes::create($data);
    }

    public function updateClass(Classes $class, array $data)
    {
        return $class->update($data);
    }

    public function deleteClass(Classes $class)
    {
        return $class->delete();
    }
}
