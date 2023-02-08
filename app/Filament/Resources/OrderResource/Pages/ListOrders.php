<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    public function getTableQuery(): Builder
    {
        $auth    = auth()->user();
        $userIds = [];

        if ($auth->client_id) {
            $userIds = $auth->hasPermission('order_index_from_clients')
                ? User::query()
                      ->where('client_id', '=', $auth->client_id)
                      ->get()
                      ->pluck('id')
                : [$auth->id];
        }

        return parent::getTableQuery()
                     ->when($userIds, static fn($q) => $q->whereIn('registered_id', $userIds));
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
