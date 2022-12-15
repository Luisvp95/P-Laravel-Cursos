<?php

namespace App\Http\Livewire;
use App\Models\Course;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\Component;
use Auth;

class CreateCourse extends Component
{
    use WithFileUploads;

    public $open = false;
    public $search = '';

    public $user_id='';
    public $name, $category_id, $slug, $image, $description, $identificador;

    public $categories;

    protected $rules=[
        'name' => 'required',
        'category_id'=> 'required',
        'slug' => 'required',
        'image' => 'required|image|max:2048',
        'description' => 'required'
    ];

    
    public function mount(){
        $this->identificador = rand();
       
    }

    public function render()
    {
        $this->categories = Category::all();

        $courses = Category::select('name')
        ->where('like', '%'.$this->search.'%');
        return view('livewire.create-course', compact('courses'));
          
    }

    public function save(){

        $this->validate();

        $image = $this->image->store('storage/courses', 'public_uploads');
        $this->user_id = auth()->user()->id;
        Course::create([
            'user_id' => $this->user_id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'slug' => $this->slug,
            'image' => $image,
            'description' => $this->description,
        ]);
        

        $this->reset(['open', 'user_id','name', 'category_id', 'slug','image', 'description']);

        $this->identificador = rand();
        $this->emitTo('show-courses', 'renderizar', 'message');
        $this->emit('alert', 'El curso se creó satisfactoriamente');
        session()->flash('message', 'Curso creado exitosamente');
    }
}
