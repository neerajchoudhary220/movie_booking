<?php

namespace App\View\Components\Action;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchBar extends Component
{
    /**
     * Create a new component instance.
     */
    public ?string $route;
    public string $placeholder;
    public bool $showClear;
    public function __construct(
        string $route = null,
        string $placeholder = 'Search...',
        bool $showClear = true
    ) {
        $this->route = $route;
        $this->placeholder = $placeholder;
        $this->showClear = $showClear;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.action.search-bar');
    }
}
