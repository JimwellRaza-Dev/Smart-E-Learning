<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modules;
use App\Models\RecentActivity;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function addModule(Request $request){
        $input = $request->validate([
            'subject_id' => 'required|uuid',
            'module_name' => 'required|string|max:255',
            'module_description' => 'nullable|string|max:1000'
        ]);

        $maxOrder = Modules::where('subject_id', $input['subject_id'])->max('order');
        $nextOrder = is_null($maxOrder) ? 1 : $maxOrder + 1;
        $module = Modules::create([
            'order' => $nextOrder,
            'subject_id' => $input['subject_id'],
            'module_name' => $input['module_name'],
            'description' => $input['module_description']
        ]);

        RecentActivity::create([
            'name' => auth()->user()->name,
            'action' => 'added_module',
            'subject' => $request->subject_name,
            'module' => $input['module_name']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'module added Successfully',
            'new_modules' => $module
        ]);

    }

    public function editModule(Request $request){
        $input = $request->validate([
            'module_id' => 'required',
            'new_module_name' => 'required|string|max:255',
            'new_description' => 'nullable|string|max:1000',
            'new_order' => 'nullable|integer|min:1'
        ]);
        $module = Modules::find($input['module_id']);

        if (!$module) {
            return response()->json([
                'success' => false,
                'message' => 'Module not found!'
            ], 404);
        }

        $module->update([
            'module_name' => $input['new_module_name'],
            'description' => $input['new_description']
        ]);

        if (isset($input['new_order']) && (int)$input['new_order'] > 0) {
            $targetOrder = (int)$input['new_order'];
            $subjectId = $module->subject_id;

            $otherModules = Modules::where('subject_id', $subjectId)
                ->where('id', '!=', $module->id)
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'asc')
                ->get();

            $reordered = [];
            $placed = false;
            $pos = 1;
            foreach ($otherModules as $other) {
                if ($pos === $targetOrder && !$placed) {
                    $reordered[] = $module;
                    $placed = true;
                    $pos++;
                }
                $reordered[] = $other;
                $pos++;
            }
            if (!$placed) {
                $reordered[] = $module;
            }

            foreach ($reordered as $idx => $m) {
                $m->update(['order' => $idx + 1]);
            }
        }

        RecentActivity::create([
            'name' => auth()->user()->name,
            'action' => 'edited_module',
            'subject' => $request->subject_name,
            'module' => $input['new_module_name']
        ]);

        $updatedModules = Modules::where('subject_id', $module->subject_id)
            ->orderBy('order', 'asc')
            ->get();

        return response()->json([
            'success'=> true,
            'message'=> 'Module updated successfully!',
            'modules' => $updatedModules
        ]);

    }

    public function reorderModule(Request $request)
    {
        $input = $request->validate([
            'module_id' => 'required',
            'direction' => 'required|in:up,down',
            'subject_name' => 'nullable|string'
        ]);

        $module = Modules::find($input['module_id']);
        if (!$module) {
            return response()->json([
                'success' => false,
                'message' => 'Module not found.'
            ], 404);
        }

        $subjectId = $module->subject_id;

        $modules = Modules::where('subject_id', $subjectId)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($modules as $index => $m) {
            $expectedOrder = $index + 1;
            if ($m->order !== $expectedOrder) {
                $m->update(['order' => $expectedOrder]);
                $m->order = $expectedOrder;
            }
        }

        $currentIndex = $modules->search(function ($item) use ($module) {
            return (string)$item->id === (string)$module->id;
        });

        if ($currentIndex === false) {
            return response()->json([
                'success' => false,
                'message' => 'Module not found in this subject.'
            ], 404);
        }

        $targetIndex = null;
        if ($input['direction'] === 'up' && $currentIndex > 0) {
            $targetIndex = $currentIndex - 1;
        } elseif ($input['direction'] === 'down' && $currentIndex < $modules->count() - 1) {
            $targetIndex = $currentIndex + 1;
        }

        if ($targetIndex !== null) {
            $currentMod = $modules[$currentIndex];
            $targetMod = $modules[$targetIndex];

            $orderCurrent = $currentMod->order;
            $orderTarget = $targetMod->order;

            $currentMod->update(['order' => $orderTarget]);
            $targetMod->update(['order' => $orderCurrent]);

            RecentActivity::create([
                'name' => auth()->user()->name,
                'action' => 'reordered_module',
                'subject' => $input['subject_name'] ?? '',
                'module' => $module->module_name
            ]);
        }

        $updatedModules = Modules::where('subject_id', $subjectId)
            ->orderBy('order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Module order updated successfully!',
            'modules' => $updatedModules
        ]);
    }

    public function deleteModule(Request $request)
    {
        $module = Modules::find($request->module_id);

        if (!$module) {
            return response()->json([
                'success' => false,
                'message' => 'module not found!'
            ], 444);
        }

        $moduleName = $module->module_name;
        $moduleId = $module->id;
        $subjectId = $module->subject_id;

        $module->delete();

        $remaining = Modules::where('subject_id', $subjectId)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($remaining as $idx => $m) {
            if ($m->order !== ($idx + 1)) {
                $m->update(['order' => $idx + 1]);
            }
        }

        RecentActivity::create([
            'name' => auth()->user()->name,
            'action' => 'deleted_module',
            'subject' => $request->subject_name,
            'module' => $moduleName
        ]);

        return response()->json([
            'success' => true,
            'message' => 'module deleted Successfully!',
            'deleted_module_id' => $moduleId
        ]);
    }
}
