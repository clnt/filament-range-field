<?php

use Livewire\Livewire;
use Yepsua\Filament\Forms\Components\RangeSlider;
use Yepsua\Filament\Tests\Fixtures\RangeSliderForm;

afterEach(function () {
    RangeSliderForm::$configureField = null;
});

it('renders the range input', function () {
    RangeSliderForm::$configureField = fn (RangeSlider $field) => $field->min(10)->max(50)->step(5);

    Livewire::test(RangeSliderForm::class)
        ->assertSeeHtml('type="range"')
        ->assertSeeHtml('min="10"')
        ->assertSeeHtml('max="50"')
        ->assertSeeHtml('step="5"');
});

it('entangles the state with livewire', function (Closure $configure, string $expected) {
    RangeSliderForm::$configureField = $configure;

    Livewire::test(RangeSliderForm::class)
        ->assertSeeHtml(e($expected));
})->with([
    'deferred' => [fn (RangeSlider $field) => $field, "\$wire.\$entangle('data.range', false)"],
    'live' => [fn (RangeSlider $field) => $field->live(), "\$wire.\$entangle('data.range', true)"],
    'live on blur' => [fn (RangeSlider $field) => $field->live(onBlur: true), "\$wire.\$entangle('data.range', true)"],
    'live with debounce' => [fn (RangeSlider $field) => $field->live(debounce: 500), "\$wire.\$entangle('data.range', true)"],
]);

it('renders the step labels', function () {
    RangeSliderForm::$configureField = fn (RangeSlider $field) => $field->steps([25 => 'A', 50 => 'B']);

    Livewire::test(RangeSliderForm::class)
        ->assertSeeHtml('min="25"')
        ->assertSeeHtml('max="50"')
        ->assertSeeHtml('@click="state = 25"')
        ->assertSee('B');
});

it('hides the step labels when display steps is disabled', function () {
    RangeSliderForm::$configureField = fn (RangeSlider $field) => $field->steps(['A', 'B'])->displaySteps(false);

    Livewire::test(RangeSliderForm::class)
        ->assertDontSeeHtml('@click="state = 1"');
});
