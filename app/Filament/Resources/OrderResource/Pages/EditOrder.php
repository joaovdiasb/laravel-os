<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Forms\Components\RadioBlock;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use App\Models\{Order, OrderCategory, OrderFlowType, OrderSituation, User};
use Filament\Forms\Components\{Actions\Action, Card, FileUpload, Grid, Placeholder, RichEditor, Select, TextInput};
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;
    protected static string $view = 'filament.pages.edit-order';
    protected static ?string $breadcrumb = 'Visualização do Chamado';
    public static ?string $title = 'Visualização do Chamado';
    public ?string $message = null;
    public ?int $order_flow_type_id = null;
    public ?array $attachments = [];

    protected function authorizeAccess(): void
    {
        abort_unless(static::getResource()::canShow($this->getRecord()), 403);
    }

    public function mount($record): void
    {
        $this->record = tap($this->resolveRecord($record))->load(['registered', 'assigned', 'orderFlows.user', 'orderSituation']);
        $this->authorizeAccess();
        $this->orderForm->fill($this->record->toArray());
    }

    protected function getOrderFlowFormSchema(): array
    {
        return [
            Card::make()
                ->schema([
                             RadioBlock::make('order_flow_type_id')
                                       ->label('Adicionar')
                                       ->options(OrderFlowType::query()
                                                              ->when(!auth()->user()
                                                                            ->hasPermission('order_select_special_flow_type'), static function($q) {
                                                                  $q->where('needs_permission', '=', 0);
                                                              })
                                                              ->get()
                                                              ->pluck('title', 'id'))
                                       ->colors(OrderFlowType::all()->pluck('color', 'id'))
                                       ->columns(4)
                                       ->reactive()
                                       ->required(),
                             RichEditor::make('message')
                                       ->label('Mensagem')
                                       ->toolbarButtons([
                                                            'attachFiles',
                                                            'blockquote',
                                                            'bold',
                                                            'bulletList',
                                                            'h2',
                                                            'h3',
                                                            'italic',
                                                            'link',
                                                            'orderedList',
                                                            'redo',
                                                            'strike',
                                                            'undo',
                                                        ])
                                       ->fileAttachmentsDirectory('attachments')
                                       ->fileAttachmentsVisibility('public')
                                       ->maxLength(5120)
                                       ->required(fn(callable $get) => (int) $get('order_flow_type_id') !== 3)
                                       ->hidden(fn(callable $get) => !$get('order_flow_type_id') || (int) $get('order_flow_type_id') === 3)
                                       ->dehydrated(fn(callable $get) => (int) $get('order_flow_type_id') !== 3),
                             FileUpload::make('attachments')
                                       ->label('Documentos')
                                       ->multiple()
                                       ->required(fn(callable $get) => (int) $get('order_flow_type_id') === 3)
                                       ->hidden(fn(callable $get) => (int) $get('order_flow_type_id') !== 3)
                                       ->dehydrated(fn(callable $get) => (int) $get('order_flow_type_id') === 3),
                         ]),
        ];
    }

    protected function getOrderFormSchema(): array
    {
        return [
            Grid::make(['lg' => 3])
                ->schema([
                             Card::make()
                                 ->schema([
                                              Select::make('order_category_id')
                                                    ->label('Categoria')
                                                    ->options(OrderCategory::all()
                                                                           ->pluck('title', 'id'))
                                                    ->searchable()
                                                    ->required(),
                                              TextInput::make('subject')
                                                       ->label('Assunto')
                                                       ->maxLength(258)
                                                       ->required(),
                                              Select::make('order_situation_id')
                                                    ->label('Situação')
                                                    ->options(OrderSituation::all()
                                                                            ->pluck('title', 'id'))
                                                    ->searchable()
                                                    ->required(),
                                          ])
                                 ->columnSpan(['lg' => 2]),
                             Card::make()
                                 ->schema([
                                              Placeholder::make('created')
                                                         ->label('Cadastrado por')
                                                         ->content(fn(Order $record) => $record->registered->name),
                                              Placeholder::make('created_at')
                                                         ->label(fn(Order $record) => 'Cadastrado em')
                                                         ->content(fn(Order $record) => $record->created_at->format('d/m/Y H:i:s')),
                                              Select::make('assigned_id')
                                                    ->label('Atribuído para')
                                                    ->searchable()
                                                    ->options(Cache::remember('users:can-be-assigned', now()->addHour(), static fn() => User::query()
                                                                                                                                            ->whereRelation('role', 'can_be_assigned', '=', 1)
                                                                                                                                            ->get()
                                                                                                                                            ->pluck('name', 'id')))
                                                    ->hintAction(
                                                        Action::make('Se atribuir')
                                                              ->icon('heroicon-o-user-add')
                                                              ->action(function(\Filament\Forms\ComponentContainer $form) {
                                                                  $form->model->update(['assigned_id' => auth()->id()]);

                                                                  Notification::make()
                                                                              ->success()
                                                                              ->title('Você foi atribuído a este chamado.')
                                                                              ->send();

                                                                  $this->redirectRoute('filament.resources.orders.edit', $this->record);
                                                              })
                                                              ->disabled(function() {
                                                                  $auth = auth()->user();

                                                                  return $auth->cannot('update', $this->record) || !$auth->role->can_be_assigned;
                                                              })
                                                              ->tooltip('Se atribuir')

                                                    ),
                                          ])
                                 ->columnSpan(['lg' => 1]),
                         ]),
        ];
    }

    protected function getForms(): array
    {
        return [
            'orderForm'     => $this->makeForm()
                                    ->statePath('data')
                                    ->schema($this->getOrderFormSchema())
                                    ->model($this->record)
                                    ->disabled(auth()->user()->cannot('update', $this->record)),
            'orderFlowForm' => $this->makeForm()
                                    ->schema(auth()->user()->cannot('updateFlow', $this->record)
                                                 ? []
                                                 : $this->getOrderFlowFormSchema()),
        ];
    }

    public function updateOrder(): void
    {
        abort_if(auth()->user()->cannot('update', $this->record), 403);

        $this->record->update($this->orderForm->getState());
        $this->getSavedNotification()?->send();
        $this->redirectRoute('filament.resources.orders.edit', $this->record);
    }

    public function createOrderFlow(): void
    {
        abort_if(auth()->user()->cannot('updateFlow', $this->record), 403);

        $orderFlow = $this->record->orderFlows()->create(
            $this->orderFlowForm->getState() +
            ['user_id' => auth()->id()]
        );

        $data = ['order_flow_id' => $orderFlow->id];

        if ($this->orderFlowForm->getState()['order_flow_type_id'] === 4) {
            $data['order_situation_id'] = 5;
        }

        $this->record->update($data);
        $this->getSavedNotification()?->send();
        $this->redirectRoute('filament.resources.orders.edit', $this->record);
    }

    /**
     * @throws \Exception
     */
    protected function getOrderFormActions(): array
    {
        if (auth()->user()->cannot('update', $this->record)) {
            return [];
        }

        return [
            Actions\EditAction::make()
                              ->button()
                              ->extraAttributes(['type' => 'submit']),
        ];
    }

    /**
     * @throws \Exception
     */
    protected function getOrderFlowFormActions(): array
    {
        if (auth()->user()->cannot('updateFlow', $this->record)) {
            return [];
        }

        return [
            Actions\EditAction::make()
                              ->label('Enviar')
                              ->button()
                              ->extraAttributes(['type' => 'submit']),
        ];
    }
}
