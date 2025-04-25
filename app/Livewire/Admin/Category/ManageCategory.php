<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageCategory extends Component
{
    public $id;
    public $name;
    public $old_name;

    public function render()
    {
        return view('livewire.admin.category.manage-category');
    }

    #[On('edit-category')]
    public function getCategoryId($id) {
        $category = Category::find($id);
        $this->id = $category->id;
        $this->name = $category->name;
        $this->old_name = $category->name;
    }

    public function update() {
        $this->validate([
            "name" => "required|unique:categories,name|min:3|max:100"
        ]);

        if ($this->name !== $this->old_name) {
            $category = Category::find($this->id);
            $category->name = $this->name;
            $category->update();
    
            $this->dispatch('refreshCategoryList');
            
            $this->dispatch(
                'alert', 
                icon: 'success',
                title: 'Success!',
                text: 'Category Name Updated Successfully!',
            );
        }
    }

    public function destroy() {
        Category::findOrFail($this->id)->deleteOrFail();

        $this->dispatch('refreshCategoryList');

        $this->dispatch(
            'alert', 
            icon: 'success',
            title: 'Success!',
            text: 'Category Deleted Successfully!',
        );
    }
}
