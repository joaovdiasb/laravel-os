<x-mail::message>
# Olá, {{ $user->name }}

Foi adicionado um acompanhamento ao seu chamado de <strong>nº {{ $orderFlow->order->id }}</strong>,
que atualmente se encontra "{{ $orderFlow->order->orderSituation->title }}".

## Acompanhamento
Feito por {{ $orderFlow->user->name }} às {{ $orderFlow->created_at->format('d/m/Y H:i:s') }}.
<x-mail::panel>
**Mensagem**
{!! $orderFlow->message !!}
</x-mail::panel>

<x-mail::button :url="$orderLink">
Acessar OS
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
