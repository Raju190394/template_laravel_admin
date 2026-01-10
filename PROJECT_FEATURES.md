# Project Documentation & Features Guide

This document serves as a comprehensive guide to the existing modules and features of the School ERP / Admin Panel application. It is designed to be a living document; **please update this file whenever a new feature is added.**

## Application Overview
**Stack:** Laravel 10+, MySQL, Blade Templates, Bootstrap 5 (Dashmin Theme).

---

## 1. Authentication & Users
**Purpose:** Manages system access and user accounts.
- **Key Features:**
  - Login / Registration (Standard Laravel Auth).
  - Role-based interaction (Admin, Staff).
  - Profile Management (Update name, email, password).
  - User Management (CRUD operations for system users).
- **Technical Details:**
  - **Model:** `User`
  - **Controllers:** `ProfileController`, `UserController`
  - **Database:** `users` table (`role` column defines permissions).

## 2. Master Configurations
**Purpose:** Central configuration for the school's academic data.
- **Key Features:**
  - **School Settings:** Manage institution name, address, logo, etc.
  - **Classes:** Define academic classes (e.g., Grade 1, Grade 2).
  - **Courses:** Manage available courses or subjects.
  - **Fee Structures:** Define fee heads and amounts (e.g., Tuition Fee, Sports Fee).
- **Technical Details:**
  - **Models:** `SchoolSetting`, `Classes`, `Course`, `FeeStructure`
  - **Controllers:**
    - `App\Http\Controllers\Master\SchoolSettingController`
    - `App\Http\Controllers\Master\ClassesController`
    - `App\Http\Controllers\Master\CourseController`
    - `App\Http\Controllers\Master\FeeStructureController`

## 3. Student Management
**Purpose:** Handles student records.
- **Key Features:**
  - Add, Edit, View, and Delete Students.
  - Assign students to classes.
  - Upload student photos.
- **Technical Details:**
  - **Model:** `Student`
  - **Controller:** `StudentController`
  - **Database:** `students` table.

## 4. Staff Management
**Purpose:** Manages staff members.
- **Key Features:**
  - Record staff details (Designation, Contact).
  - Link Staff profiles to User accounts for system login.
- **Technical Details:**
  - **Model:** `Staff`
  - **Controller:** `StaffController`
  - **Database:** `staff` table.

## 5. Attendance System
**Purpose:** Tracks daily attendance for both Staff and Students.
- **Key Features:**
  - **Staff Attendance:** Mark Present/Absent/Late/Half Day (Manual or Face Auth).
  - **Student Attendance:**
    - **Class-wise Daily Recording:** Bulk mark attendance for a selected class and date.
    - **Status Options:** Present, Absent, Late, Half Day, Holiday.
    - **Reporting:** Generate monthly grid reports with percentage calculations.
    - **Locking:** Prevent edits after submission.
    - **PDF/Print:** Exportable monthly reports.
- **Technical Details:**
  - **Models:**
    - `Attendance` (Staff)
    - `StudentAttendance` (Student)
  - **Controllers:**
    - `AttendanceController` (Staff)
    - `StudentAttendanceController` (Student)
  - **Database:** `attendances`, `student_attendances` tables.

## 6. Fees Module
**Purpose:** Handles financial transactions.
- **Key Features:**
  - **Collect Fees:** Record payments against students.
  - **Fee Receipts:** Generate and download PDF receipts.
  - **History:** View past payment records.
- **Technical Details:**
  - **Model:** `FeePayment`
  - **Controller:** `App\Http\Controllers\Fees\FeePaymentController`
  - **Database:** `fee_payments` table.

## 7. Internal Mailbox (Messaging)
**Purpose:** Internal communication system for Admins and Staff.
- **Key Features:**
  - **Inbox/Sent/Archive:** Full email-like folder structure.
  - **Compose:** Send messages with **Attachments** (Images, PDFs).
  - **Bulk Actions:** Mass delete or archive messages.
  - **Read Status:** Tracks valid read/unread states.
- **Technical Details:**
  - **Models:** `InternalMessage`, `MessageAttachment`
  - **Controller:** `MailboxController`
  - **Service:** `MailboxService` (Business logic layer).
  - **Database:** `internal_messages`, `message_attachments`.

## 8. Academic Session & Promotion
**Purpose:** Manage school years and student progression.
- **Key Features:**
  - **Academic Sessions:** Define school years (e.g., 2024-2025). Set "Current Session".
  - **Student Promotion:** Bulk move students from one class to another for a new session.
  - **History:** Tracks student class history across sessions.
- **Technical Details:**
  - **Models:** `AcademicSession`, `StudentSession`
  - **Controllers:**
    - `App\Http\Controllers\Master\AcademicSessionController`
    - `App\Http\Controllers\Master\StudentPromotionController`
  - **Database:** `academic_sessions`, `student_sessions`.

## 9. Examination & Results
**Purpose:** Manage exams, schedules, and student marks.
- **Key Features:**
  - **Exam Management:** Create/Edit exams (e.g., Mid-Term, Final).
  - **Scheduling:** Set dates/times for each subject in a class.
  - **Marks Entry:** Teacher interface to input marks subject-wise.
  - **Result Processing:** Generate tabulation sheets (Report Cards) with grades.
- **Technical Details:**
  - **Models:** `Exam`, `ExamSchedule`, `ExamMark`
  - **Controllers:** `ExamController`, `ExamScheduleController`, `ExamMarkController`, `ReportCardController`
  - **Database:** `exams`, `exam_schedules`, `exam_marks`.

## 10. Library Management
**Purpose:** Manage school library resources and book circulation.
- **Key Features:**
  - **Book Inventory:** Add/Edit books with details like ISBN, Author, Category, and Rack Number.
  - **Book Circulation:** Issue books to students with due dates.
  - **Return Processing:** Mark books as Returned or Lost.
  - **Fine Management:** Record fines for overdue or lost books.
  - **Availability Tracking:** Automatically updates available quantities on issue/return.
- **Technical Details:**
  - **Models:** `Book`, `BookIssue`
  - **Controller:** `LibraryController`
  - **Database:** `books`, `book_issues`.

---


## 🚀 How to Add a New Feature (Step-by-Step)

Follow this checklist when adding a new module to ensuring consistency.

### Step 1: Database Layer
1. Create Migration: `php artisan make:migration create_feature_table`
2. Define Schema: Add columns in the migration file.
3. migrate: `php artisan migrate`
4. Create Model: `php artisan make:model FeatureName`
   - Add `$fillable` properties.
   - Define relationships (e.g., `belongsTo`, `hasMany`).

### Step 2: Controller & Logic
1. Create Controller: `php artisan make:controller FeatureNameController --resource`
2. Define Routes: Add resource routes in `routes/web.php`.
   ```php
   Route::resource('feature-name', FeatureNameController::class);
   ```
3. Implement Methods: Fill `index`, `create`, `store`, `edit`, `update`, `destroy`.

### Step 3: Views (UI)
1. Create Folder: `resources/views/feature-name/`
2. Create Blade Files:
   - `index.blade.php` (List view)
   - `create.blade.php` (Form)
   - `edit.blade.php` (Form)
   - `show.blade.php` (Detail view)
3. Extend Layout: Always use `@extends('layouts.admin')`.

### Step 4: Sidebar Navigation
1. Edit `resources/views/layouts/sidebar.blade.php` (or `admin.blade.php` if embedded).
2. Add a new link to your index route.
   ```html
   <a href="{{ route('feature-name.index') }}" class="nav-item nav-link">
       <i class="fa fa-icon me-2"></i>Feature Name
   </a>
   ```

### Step 5: Test
1. Run `php artisan serve`.
2. check the flow: Create -> View -> Edit -> Delete.

---
*Last Updated: 2026-01-10*
