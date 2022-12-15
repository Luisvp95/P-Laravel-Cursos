<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class ShowCategory extends Component
{
    use WithPagination;

    public $category, $identificador;

    public $name;

    public $user_id='';

    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';

    public $readyToLoad = false;

    public $cant = '10';

    public $open_edit=false;
    public $open_delete=false;

    protected $listeners = ['renderizar'=>'render'];
    protected $rules=[
        'category.name' => 'required'
    ];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'search' => ['except' => ''],
        'direction' => ['except' => 'desc']
    ];

    

    public function mount(Category $category){
        
        $this->identificador = rand();
        
        $this->category = $category;
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        if($this->readyToLoad){
            $categories = Category::where('name', 'like', '%'.$this->search.'%')
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->cant);    
                            
                        }else{
                            $categories =[];
                        }
        return view('livewire.show-category', compact('categories'));
    }

    public function loadCategories(){
        $this->readyToLoad = true;

    }

    public function order($sort){

        if($this->sort == $sort){
            
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            }
            else{
                $this->direction = 'desc';
            }
        }
        else{
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function edit(Category $category){

        $this->category = $category;
        $this->open_edit = true;
    }

    public function confirmDelete ( $id)
    {
        //$article->delete();
        $this->open_delete = $id;
    }

    public function delete (Category $category)
    {
        $category->delete();
        $this->open_delete = false;
        session()->flash('message', 'Categoria eliminado exitosamente');
    }


    public function update(){
        
        if(isset($this->category->id)){
            $this->validate();
            $this->user_id = auth()->user()->id;
        $this->category->save();
        //resetar
        $this->reset(['open_edit']);

        $this->identificador = rand();

        
        //emitir alert
        //$this->emit('alert', 'El post se actualizo satisfactoriamente');

        session()->flash('message', 'Categoria actualizado exitosamente');

    }else{
        $this->user_id = auth()->user()->id;
        Category::create([
            'user_id' => $this->user_id,
            'name' => $this->category['name']
        ]);
        

        $this->reset(['open_edit']);

        $this->identificador = rand();
        //$this->emitTo('show-courses', 'renderizar');
        //$this->emit('alert', 'El curso se creó satisfactoriamente');
        session()->flash('message', 'Categoria creado exitosamente');
    }
    
    }
}

