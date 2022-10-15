<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $userId  = auth()->id();
        $created = static::getModel()::create($data + [
                                                  'registered_id'      => $userId,
                                                  'order_situation_id' => 1, // [1] => Cadastrado
                                              ]);
        $orderFlow = $created->orderFlows()->create([
                                           'message'            => $data['message'],
                                           'order_flow_type_id' => 1, // [1] => Acompanhamento
                                           'user_id'            => $userId,
                                       ]);

        $created->update(['order_flow_id' => $orderFlow->id]);

        return $created;
    }
}
