<?php

namespace App\View\Components;

use App\Models\Budget;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchTour extends Component
{

    public $budgets;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
       // Lấy danh sách ngân sách từ cơ sở dữ liệu
       $this->budgets = Budget::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search-tour');
    }
}
