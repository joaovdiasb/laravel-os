<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\Orders;
use App\Filament\Widgets\OrdersBySituation;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeading(): string
    {
        $auth = auth()->user();

        return $auth->client_id ? "Dashboard {$auth->client->name}" : 'Dashboard';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Orders::class,
            OrdersBySituation::class
        ];
    }
}
