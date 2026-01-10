<?php

namespace App\Services;

use App\Models\TimeTable;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Staff;

class TimeTableService
{
    public function getTimeTablesByClass($class_id)
    {
        $class = Classes::find($class_id);
        if (!$class) return [];

        return TimeTable::where('class_id', $class->id)
            ->with(['course', 'staff'])
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');
    }

    public function createTimeTable(array $data)
    {
        // Validation: Check Overlap for Class
        $classOverlap = TimeTable::where('class_id', $data['class_id'])
            ->where('day', $data['day'])
            ->where(function($q) use ($data) {
                $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                  ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                  ->orWhere(function($sub) use ($data) {
                      $sub->where('start_time', '<=', $data['start_time'])
                          ->where('end_time', '>=', $data['end_time']);
                  });
            })
            ->exists();

        if ($classOverlap) {
            throw new \Exception('Time slot overlaps with an existing class schedule.');
        }

        // Validation: Check Overlap for Teacher (if assigned)
        if (!empty($data['staff_id'])) {
            $teacherOverlap = TimeTable::where('staff_id', $data['staff_id'])
                ->where('day', $data['day'])
                ->where(function($q) use ($data) {
                    $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                      ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                      ->orWhere(function($sub) use ($data) {
                          $sub->where('start_time', '<=', $data['start_time'])
                              ->where('end_time', '>=', $data['end_time']);
                      });
                })
                ->exists();

            if ($teacherOverlap) {
                throw new \Exception('Teacher is already booked for another class at this time.');
            }
        }

        return TimeTable::create($data);
    }

    public function deleteTimeTable($id)
    {
        $tt = TimeTable::findOrFail($id);
        $class_id = $tt->class_id;
        $tt->delete();
        return $class_id;
    }
}
