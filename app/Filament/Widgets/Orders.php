<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Utils\Trend\{Trend, TrendValue};
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\{Carbon, Collection};
use Illuminate\Support\Facades\Cache;

class Orders extends BarChartWidget
{
    protected static ?string $heading = 'Chamados ao longo do ano';
    protected static ?string $pollingInterval = '3600s';

    private function getTrend(): Collection
    {
        $auth = auth()->user();

        return Trend::query(
            Order::query()
                 ->join('users', 'users.id', '=', 'orders.registered_id')
                 ->leftJoin('clients', 'users.client_id', '=', 'clients.id')
                 ->when($auth->client_id, fn($q) => $q->where('clients.id', '=', $auth->client_id))
        )
                    ->between(
                        start: now()->startOfYear(),
                        end:   now()->endOfYear(),
                    )
                    ->perMonth()
                    ->count();
    }

    protected function getData(): array
    {
        $clientId = $auth->client_id ?? '*';

        return Cache::remember("client:{$clientId}:chart:orders", now()->addHour(), function() {
            $orders = $this->getTrend();

            return [
                'datasets' => [
                    [
                        'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                        'borderColor'     => 'rgb(255, 99, 132)',
                        'borderWidth'     => '1',
                        'label'           => 'Chamados',
                        'data'            => $orders->map(fn(TrendValue $value) => $value->aggregate),
                    ],
                ],
                'labels'   => $orders->map(fn(TrendValue $value) => Carbon::parse($value->date)
                                                                          ->format('m/Y')),
            ];
        });
    }
}
