<?php

namespace Yepsua\Filament\Tests\Fixtures;

use Closure;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Livewire\Component;
use Yepsua\Filament\Forms\Components\RangeSlider;

class RangeSliderForm extends Component implements HasForms
{
    use InteractsWithForms;

    public static ?Closure $configureField = null;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        $field = RangeSlider::make('range');

        if (static::$configureField) {
            $field = (static::$configureField)($field);
        }

        return $schema
            ->components([$field])
            ->statePath('data');
    }

    public function render(): string
    {
        return '<div>{{ $this->form }}</div>';
    }
}
