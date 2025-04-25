<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryList extends Component
{
    #[On('refreshCategoryList')]
    public function render()
    {
        return view('livewire.admin.category.category-list', [
            "categories" => Category::all()
        ]);
    }
}
