<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderSituation;
use Filament\Widgets\DoughnutChartWidget;
use App\Utils\Trend\{Trend, TrendValue};
use Illuminate\Support\{Carbon, Collection};
use Illuminate\Support\Facades\Cache;

class OrdersBySituation extends DoughnutChartWidget
{
    protected static ?string $heading = 'Chamados por situação';
    protected static ?string $pollingInterval = '3600s';

    protected function getData(): array
    {
        $auth     = auth()->user();
        $clientId = $auth->client_id ?? '*';

        return Cache::remember("client:{$clientId}:chart:orders-by-situation", now()->addHour(), static function() use ($auth) {
            $orders = Order::query()
                           ->select('order_situation_id', \DB::raw('count(*) as total'))
                           ->join('users', 'users.id', '=', 'orders.registered_id')
                           ->leftJoin('clients', 'users.client_id', '=', 'clients.id')
                           ->when($auth->client_id, fn($q) => $q->where('clients.id', '=', $auth->client_id))
                           ->orderBy('order_situation_id')
                           ->groupBy('order_situation_id')
                           ->get();

            return [
                'datasets' => [
                    [
                        'data'            => $orders->pluck('total'),
                        'backgroundColor' => [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(255, 159, 64, 0.5)',
                            'rgba(255, 205, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(201, 203, 207, 0.5)',
                        ],
                        'borderColor'     => [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)',
                        ],
                        'borderWidth'     => '1',
                    ],
                ],
                'labels'   => OrderSituation::query()
                                            ->whereIn('id', $orders->pluck('order_situation_id'))
                                            ->orderBy('id')
                                            ->get()
                                            ->pluck('title'),
            ];
        });
    }
}
