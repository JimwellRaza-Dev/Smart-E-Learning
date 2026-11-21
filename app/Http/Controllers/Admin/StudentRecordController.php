<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecentActivity;
use App\Models\StudentRecord;
use App\Models\User;
use Illuminate\Http\Request;

class StudentRecordController extends Controller
{
    /**
     * Store one or multiple student ID numbers.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course' => 'required|string|in:BSCS,BSINTE,BINDTECH,COMTECH',
            'year_level' => 'required|string|in:1st Year,2nd Year,3rd Year,4th Year',
        ], [
            'course.required' => 'Please select a course.',
            'course.in' => 'Selected course is invalid.',
            'year_level.required' => 'Please select a year level.',
            'year_level.in' => 'Selected year level is invalid.',
        ]);

        $course     = $validated['course'];
        $year_level = $validated['year_level'];
        $raw = $request->input('id_numbers', $request->input('id_number'));

        if (is_array($raw)) {
            $candidates = $raw;
        } elseif (is_string($raw)) {
            $candidates = preg_split('/[\r\n,;]+/', $raw);
        } else {
            $candidates = [];
        }

        $ids = [];
        foreach ($candidates as $candidate) {
            $clean = trim((string) $candidate);
            if ($clean !== '' && !in_array($clean, $ids, true)) {
                $ids[] = $clean;
            }
        }

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter at least one valid student ID number.',
                'errors'  => [
                    'id_numbers' => ['Please enter at least one student ID number.'],
                ],
            ], 422);
        }

        $tooLong = array_filter($ids, fn ($id) => strlen($id) > 50);
        if (!empty($tooLong)) {
            return response()->json([
                'success' => false,
                'message' => 'The following ID numbers exceed the 50-character limit: ' . implode(', ', array_slice($tooLong, 0, 3)),
            ], 422);
        }

        $existing = StudentRecord::whereIn('id_number', $ids)->pluck('id_number')->all();
        $newIds = array_values(array_diff($ids, $existing));

        if (empty($newIds)) {
            return response()->json([
                'success' => false,
                'message' => count($ids) === 1
                    ? "Student ID '{$ids[0]}' is already in the records."
                    : 'All ' . count($ids) . ' entered student IDs are already in the records.',
            ], 422);
        }

        $now = now();
        $recordsToInsert = array_map(fn ($id) => [
            'id_number'   => $id,
            'course'      => $course ?: null,
            'year_level'  => $year_level ?: null,
            'is_disabled' => false,
            'created_at'  => $now,
            'updated_at'  => $now,
        ], $newIds);

        StudentRecord::insert($recordsToInsert);

        $createdRecords = StudentRecord::whereIn('id_number', $newIds)
            ->with('user:id,id_number,name,email,disabled')
            ->orderBy('id', 'desc')
            ->get();

        $countNew = count($newIds);
        $countSkipped = count($existing);

        $msg = "{$countNew} " . ($countNew === 1 ? 'student ID' : 'student IDs') . ' added successfully.';
        if ($countSkipped > 0) {
            $msg .= " ({$countSkipped} skipped because already exists).";
        }

        $activity = RecentActivity::create([
            'name'   => auth()->user()->name,
            'action' => $countNew === 1 ? 'added_student_record' : 'added_student_records',
            'target' => $countNew === 1 ? $newIds[0] : "{$countNew} student IDs",
        ]);

        return response()->json([
            'success'       => true,
            'message'       => $msg,
            'records'       => $createdRecords,
            'record'        => $createdRecords->first(),
            'added_count'   => $countNew,
            'skipped_count' => $countSkipped,
            'skipped_ids'   => $existing,
            'activity'      => $activity,
        ]);
    }

    /**
     * Toggle the disabled status of a student record.
     */
    public function toggleDisable(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:student_records,id',
        ]);

        $record = StudentRecord::findOrFail($data['id']);
        $record->is_disabled = ! (bool) $record->is_disabled;
        $record->save();

        // If a user account exists with this ID number, sync their disabled state
        $user = User::where('id_number', $record->id_number)->first();
        if ($user) {
            $user->disabled = $record->is_disabled;
            $user->save();
        }

        $statusText = $record->is_disabled ? 'disabled' : 'enabled';

        $activity = RecentActivity::create([
            'name'   => auth()->user()->name,
            'action' => $record->is_disabled ? 'disabled_student_record' : 'enabled_student_record',
            'target' => $record->id_number,
        ]);

        return response()->json([
            'success'     => true,
            'is_disabled' => $record->is_disabled,
            'message'     => "Student ID {$record->id_number} has been {$statusText}.",
            'record'      => $record->load('user:id,id_number,name,email,disabled'),
            'activity'    => $activity,
        ]);
    }

    /**
     * Delete a student record by ID.
     * Any user registered with that ID is also removed from users.
     */
    public function destroy(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:student_records,id',
        ]);

        $record = StudentRecord::findOrFail($data['id']);
        $idNumber = $record->id_number;

        // Remove the registered user account associated with this ID if one exists
        $user = User::where('id_number', $idNumber)->first();
        if ($user) {
            $user->delete();
        }

        $record->delete();

        $activity = RecentActivity::create([
            'name'   => auth()->user()->name,
            'action' => 'deleted_student_record',
            'target' => $idNumber,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => "Student ID {$idNumber} and its associated user account have been removed successfully.",
            'activity' => $activity,
        ]);
    }
}
