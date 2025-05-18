<?php

namespace App\Services\Config;

use App\Helpers\Helpers;
use App\Models\FeelingList;
use Illuminate\Support\Str;

class FeelingListService
{
    protected function checkTrashed($name)
    {
        return FeelingList::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create($request) : FeelingList
    {
        $trashedList = $this->checkTrashed($request->name);

        if($trashedList) {
            $trashedList->restore();
            return $trashedList;
        } else{
            $emoji = Helpers::getFileUrl($request->emoji, 'emojis/');
            return FeelingList::create([
                'name'      => $request->name,
                'is_active' => $request->has('is_active'),
                'emoji'     => $emoji
            ]);
        }
    }

    public function update(FeelingList $feelingList, $request): FeelingList
    {
        $emoji = Helpers::getFileUrl($request->emoji, 'emojis/', $feelingList->emoji);
        $feelingList->update([
            'name'      => $request->name,
            'is_active' => $request->has('is_active'),
            'emoji'     => $emoji
        ]);
        return $feelingList;
    }

    public function delete(FeelingList $feelingList): bool
    {
        return $feelingList->delete();
    }
}
