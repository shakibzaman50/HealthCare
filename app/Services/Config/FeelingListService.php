<?php

namespace App\Services\Config;

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

    public function create(array $data) : FeelingList
    {
        $trashedList = $this->checkTrashed($data['name']);

        if($trashedList) {
            $trashedList->restore();
            return $trashedList;
        } else{
            return FeelingList::create($data);
        }
    }

    public function update(FeelingList $feelingList, array $data): FeelingList
    {
        $feelingList->update($data);
        return $feelingList;
    }

    public function delete(FeelingList $feelingList): bool
    {
        return $feelingList->delete();
    }
}
