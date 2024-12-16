<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminLaylout extends Component
{
    public $title;
    public $breadcrumbs;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $breadcrumbs)
    {
        $this->title = $title ?? 'Admin Dashboard';
        $this->breadcrumbs = $breadcrumbs ?? 'Admin Dashboard';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-layout', [
            'title' => $this->title,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}
