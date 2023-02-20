<?php

namespace App\Http\Livewire\Products\AlternateRates;

use Livewire\Component;
use App\Models\Product\ProductAlternateRateType;

class CreateRateTypeForm extends Component
{

    public bool $showForm = false;
    public array $state = [];

    public array $rules = [
        'state.open' => 'boolean',
        'state.name' => 'required|string|max:50|unique:App\Models\Product\ProductAlternateRateType,name',
        'state.urlStart' => 'url',
        'state.urlEnd' => 'string',
    ];

    public function newRateType()
    {
        $validatedData = $this->validate();

        $rateType = ProductAlternateRateType::firstOrNew([
            'name' => $validatedData['state']['name'],
        ]);

        $rateType->url_start = $validatedData['state']['urlStart'] ?? null;
        $rateType->url_end = $validatedData['state']['urlEnd'] ?? null;

        $rateType->save();

        session()->flash('success', 'New Rate Type Added');

        $this->reset();

        $this->showForm = false;

    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.products.alternate-rates.create-rate-type-form');
    }
}
