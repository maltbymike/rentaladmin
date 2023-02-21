<?php

namespace App\Http\Livewire\Products\AlternateRates;

use App\Models\Product\ProductAlternateRateProduct;
use Livewire\Component;
use App\Models\Product\Product;
use App\Models\Product\ProductAlternateRate;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product\ProductAlternateRateType;

class CreateAlternateRateForm extends Component
{

    public $product;

    public Collection $rateTypes;

    protected array $rules = [
        'state.type' => 'required|integer',
        'state.name' => 'required|string',
        'state.identifier' => 'string',
        'state.rates.*' => 'decimal:0,2',
    ];

    protected array $messages = [
        'state.rates.*.decimal' => ':attribute must be only numbers with no more than 2 decimal places',
    ];

    protected array $validationAttributes = [
        'state.type' => 'Rate Type',
        'state.name' => 'Alternate Product Name',
        'state.identifier' => 'Product URL Identifier',
        'state.rates.two_hour' => '2 Hour Rate',
        'state.rates.four_hour' => '4 Hour Rate',
        'state.rates.daily' => 'Daily Rate',
        'state.rates.weekly' => 'Weekly Rate',
        'state.rates.four_week' => '4 Week Rate',
    ];

    public array $state = [];

    protected $listeners = [
        'showProduct',
    ];

    public function mount()
    {
        $this->rateTypes = ProductAlternateRateType::all();
    }

    public function newRate()
    {
        $validatedData = $this->validate();

        $newAlternateProduct = new ProductAlternateRateProduct;
        $newAlternateProduct->name = $validatedData['state']['name'] ?? null;
        $newAlternateProduct->product_identifier = $validatedData['state']['identifier'] ?? null;
        $newAlternateProduct->rateType()->associate($validatedData['state']['type']);
        
        $newAlternateProduct->save();

        $newAlternateProduct->products()->attach($this->product->id);

        $newRate = new ProductAlternateRate;
        $newRate->two_hour_rate = $validatedData['state']['rates']['two_hour'] ?? null;
        $newRate->four_hour_rate = $validatedData['state']['rates']['four_hour'] ?? null;
        $newRate->daily_rate = $validatedData['state']['rates']['daily'] ?? null;
        $newRate->weekly_rate = $validatedData['state']['rates']['weekly'] ?? null;
        $newRate->four_week_rate = $validatedData['state']['rates']['four_week'] ?? null;

        $newRate->alternateProduct()->associate($newAlternateProduct);
        
        $newRate->save();

    }

    public function showProduct(int $productId = 0)
    {
        $this->product = Product::find($productId);

        $this->state['name'] = $this->product->name;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.products.alternate-rates.create-alternate-rate-form');
    }

}
