<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditCourses extends Component
{
    use WithFileUploads;
    public $open = false;

    public $course, $image, $identificador;
    public $categories;

    protected $rules=[
        'course.name' => 'required',
        'course.category_id'=> 'required',
        'course.slug' => 'required',
        'course.description' => 'required'
    ];

    public function mount(Course $course){
        $this->course = $course;

        $this->identificador = rand();
    }

    public function save(){
        $this->validate();
        
        if ($this->image) {

            Storage::delete([$this->course->image]);

            $this->course->image = $this->image->store('storage/courses', 'public_uploads');
        }

        $this->course->save();
        //resetar
        $this->reset(['open', 'image']);

        $this->identificador = rand();
        //renderizar
        $this->emitTo('show-courses','renderizar');
        //emitir alert
        $this->emit('alert', 'El Curso se actualizo satisfactoriamente');

    }

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.edit-courses');
    }
}
