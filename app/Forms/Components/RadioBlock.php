<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Radio;
use Illuminate\Contracts\Support\Arrayable;
use Closure;

class RadioBlock extends Radio
{
    protected string $view = 'forms.components.radio-block';

    protected array | Arrayable | Closure $colors = [];

    public function colors(array | Arrayable | Closure $colors): static
    {
        $this->colors = $colors;

        return $this;
    }

    public function hasColor($value): bool
    {
        return array_key_exists($value, $this->getColors());
    }

    public function getColor($value): ?string
    {
        return $this->getColors()[$value] ?? null;
    }

    public function getColors(): array
    {
        $colors = $this->evaluate($this->colors);

        if ($colors instanceof Arrayable) {
            $colors = $colors->toArray();
        }

        return $colors;
    }
}
