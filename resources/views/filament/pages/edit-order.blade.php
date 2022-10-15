<x-filament::page
    :widget-data="['record' => $record]"
    :class="\Illuminate\Support\Arr::toCssClasses([
        'filament-resources-edit-record-page',
        'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'filament-resources-record-' .  $record->getKey(),
    ])"
>
    <x-filament::form wire:submit.prevent="updateOrder">
        {{ $this->orderForm }}
        <x-filament::form.actions
            :actions="$this->getOrderFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament::form>
    <x-filament::form wire:submit.prevent="createOrderFlow">
        {{ $this->orderFlowForm }}
        <x-filament::form.actions
            :actions="$this->getOrderFlowFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament::form>
    <section class="text-black-100">
        <div class="container px-4 pt-4 mx-auto">
            <div class="grid gap-4 mx-4 sm:grid-cols-12">
                <div class="relative col-span-12 px-4 space-y-6 sm:col-span-9">
                    <div class="col-span-12 space-y-12 relative px-4 sm:col-span-8 sm:space-y-8 sm:before:absolute sm:before:top-2 sm:before:bottom-0 sm:before:w-0.5 sm:before:-left-3 before:bg-primary-700">
                        @forelse($record->orderFlows as $orderFlow)
                            <div class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:bg-primary-500">
                                <h3 class="text-xl font-semibold tracking-wide">{{ $orderFlow->user->name }}</h3>
                                <time class="text-xs tracking-wide uppercase text-black-400">{{ $orderFlow->created_at->format('d/m/Y H:i:s') }} - {{ $orderFlow->created_at->diffForHumans() }}</time>
                                <div x-data="richEditorFormComponent({
                                        state: $wire.entangle('data.description').defer,
                                     })"
                                     x-on:trix-change="state = $event.target.value" x-on:trix-attachment-add="
                                        if (! $event.attachment.file) return

                                        let attachment = $event.attachment

                                        $wire.upload(`componentFileAttachments.data.description`, attachment.file, () => {
                                            $wire.getComponentFileAttachmentUrl('data.description').then((url) => {
                                                attachment.setAttributes({
                                                    url: url,
                                                    href: url,
                                                })
                                            })
                                        })
                                     "
                                     x-on:trix-file-accept="
                                        if (true) return

                                        $event.preventDefault()
                                     "
                                     class="filament-forms-rich-editor-component mt-2 space-y-2">
                                    <span class="text-sm absolute right-2 pt-3">{{ $orderFlow->orderFlowType->title }}</span>
                                    <div @class([
                                                    'prose block w-full max-w-none rounded-lg border border-gray-300 p-3 opacity-70 shadow-sm',
                                                    "bg-{$orderFlow->orderFlowType->color}-100" => $orderFlow->orderFlowType->color,
                                                    'bg-white' => !$orderFlow->orderFlowType->color
                                                ])>
                                        {!! $orderFlow->message !!}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <storng>Sem movimentação.</storng>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-filament::page>
