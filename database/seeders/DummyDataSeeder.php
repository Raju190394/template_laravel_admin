<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolSetting;
use App\Models\Classes;
use App\Models\FeeStructure;
use App\Models\Student;
use App\Models\FeePayment;
use App\Models\Staff;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for clean sweep
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FeePayment::truncate();
        FeeStructure::truncate();
        Student::truncate();
        Classes::truncate();
        Staff::truncate();
        Attendance::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. School Settings
        SchoolSetting::updateOrCreate(['id' => 1], [
            'school_name' => 'Vrikshansh International School',
            'email' => 'info@vrikshansh.com',
            'phone' => '+91 9876543210',
            'address' => '123, Tech Park Area, Phase 2',
            'city' => 'Mumbai',
            'website' => 'www.vrikshansh.com',
        ]);

        // 2. Create Classes
        $class1A = Classes::create(['class_name' => '1st', 'section' => 'A', 'capacity' => 40, 'is_active' => true]);
        $class1B = Classes::create(['class_name' => '1st', 'section' => 'B', 'capacity' => 35, 'is_active' => true]);
        $class2A = Classes::create(['class_name' => '2nd', 'section' => 'A', 'capacity' => 40, 'is_active' => true]);

        // 3. Create Fee Structures
        $fee1 = FeeStructure::create([
            'class_id' => $class1A->id,
            'fee_head' => 'Tuition Fee',
            'amount' => 5000.00,
            'fee_type' => 'Monthly',
            'frequency' => 'Monthly',
            'is_mandatory' => true,
            'description' => 'Standard monthly tuition fee',
        ]);

        // 4. Create Students
        $student1 = Student::create([
            'name' => 'Rahul Sharma',
            'email' => 'rahul@example.com',
            'phone' => '9988776655',
            'dob' => '2018-05-15',
            'class_id' => $class1A->id,
        ]);

        $student2 = Student::create([
            'name' => 'Priya Verma',
            'email' => 'priya@example.com',
            'phone' => '9944332211',
            'dob' => '2018-08-20',
            'class_id' => $class1B->id,
        ]);

        // 5. Create Staff Members
        Staff::create([
            'name' => 'Dr. Akhilesh Kumar',
            'email' => 'akhilesh@vrikshansh.com',
            'phone' => '9812345678',
            'designation' => 'Principal',
            'salary' => 75000.00,
            'joining_date' => '2023-01-01',
        ]);

        Staff::create([
            'name' => 'Mrs. Sunita Devi',
            'email' => 'sunita@vrikshansh.com',
            'phone' => '9898989898',
            'designation' => 'Senior Teacher',
            'salary' => 45000.00,
            'joining_date' => '2023-06-15',
        ]);

        // 6. Fee Payment
        FeePayment::create([
            'student_id' => $student1->id,
            'fee_structure_id' => $fee1->id,
            'amount_paid' => 5000.00,
            'payment_date' => Carbon::now(),
            'for_month' => 'January',
            'for_year' => 2026,
            'receipt_no' => 'RCPT-' . strtoupper(Str::random(8)),
            'payment_method' => 'Cash',
            'remarks' => 'Monthly fee paid on time',
        ]);
    }
}
