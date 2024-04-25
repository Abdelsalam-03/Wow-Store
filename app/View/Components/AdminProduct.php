<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminProduct extends Component
{
    public $product;
    public $settings;
    
    /**
     * Create a new component instance.
     */

    public function __construct($product, $settings)
    {
        $this->product = $product;
        $this->settings = $settings;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-product');
    }
}
