<?php

namespace App\Services\Admin;

use App\Helpers\Helpers;
use App\Models\HabitList;
use Illuminate\Support\Str;

class HabitListService
{
    protected function checkTrashed($name)
    {
        return HabitList::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create($request) : HabitList
    {
        $trashedList = $this->checkTrashed($request->name);

        if($trashedList) {
            $trashedList->restore();
            return $trashedList;
        }
        else{
            $icon = Helpers::getFileUrl($request->icon, 'icons/');
            return HabitList::create([
                'name'      => $request->name,
                'is_active' => $request->has('is_active'),
                'icon'      => $icon
            ]);
        }
    }

    public function update(HabitList $habitList, $request): HabitList
    {
        $icon = Helpers::getFileUrl($request->icon, 'emojis/', $habitList->icon);
        $habitList->update([
            'name'      => $request->name,
            'is_active' => $request->has('is_active'),
            'icon'      => $icon
        ]);
        return $habitList;
    }

    public function delete(HabitList $habitList): bool
    {
        return $habitList->delete();
    }
}
