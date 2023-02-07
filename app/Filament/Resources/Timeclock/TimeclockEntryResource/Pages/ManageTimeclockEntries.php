<?php

namespace App\Filament\Resources\Timeclock\TimeclockEntryResource\Pages;

use App\Filament\Resources\Timeclock\TimeclockEntryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTimeclockEntries extends ManageRecords
{
    protected static string $resource = TimeclockEntryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
