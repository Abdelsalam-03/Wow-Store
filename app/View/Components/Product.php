<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Product extends Component
{
    /**
     * Create a new component instance.
     */

    public $product;
    public $settings;
    public $guest;

    public function __construct($product, $settings, $guest = false)
    {
        $this->product = $product;
        $this->settings = $settings;
        $this->guest = $guest;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product');
    }
}
