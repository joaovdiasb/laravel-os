<?php

namespace App\Filament\Resources\OrderCategoryResource\Pages;

use App\Filament\Resources\OrderCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOrderCategories extends ManageRecords
{
    protected static string $resource = OrderCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
