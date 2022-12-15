<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class ShowCourses extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $course, $identificador;

    public $name, $category_id, $slug, $image, $description;
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';

    public $categories;

    public $readyToLoad = false;

    public $cant = '10';

    public $open_edit=false;
    public $open_delete=false;

    protected $listeners = ['renderizar'=>'render'];
    protected $rules=[
        'course.name' => 'required',
        'course.category_id'=> 'required',
        'course.slug' => 'required',
        'course.description' => 'required'
    ];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'search' => ['except' => ''],
        'direction' => ['except' => 'desc']
    ];

    

    public function mount(Course $course){
        
        $this->identificador = rand();
        
        $this->course = $course;
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $this->categories = Category::all();
        if($this->readyToLoad){
        $courses = Course::where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('slug', 'like', '%'.$this->search.'%')
                        ->orWhere('image', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orwhere('category_id','name', 'like', '%'.$this->search.'%')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->cant);    
                        
                    }else{
                        $courses =[];
                    }
                        
        return view('livewire.show-courses', compact('courses'));
        
    }

    public function loadCourses(){
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

    public function edit(Course $course){

        $this->course = $course;
        $this->open_edit = true;
    }

    public function confirmDelete ( $id)
    {
        //$article->delete();
        $this->open_delete = $id;
    }

    public function delete (Course $course)
    {
        Storage::delete([$this->course->image]);
        $course->delete();
        $this->open_delete = false;
        session()->flash('message', 'Curso eliminado exitosamente');
    }


    public function update(){
        
        if(isset($this->course->id)){
            $this->validate();
        if ($this->image) {

            Storage::delete([$this->course->image]);

            $this->course->image = $this->image->store('storage/courses', 'public_uploads');
        }
        $this->user_id = auth()->user()->id;

        $this->course->save();
        
        //resetar
        $this->reset(['open_edit', 'image']);

        $this->identificador = rand();

        
        //emitir alert
        //$this->emit('alert', 'El curso se actualizo satisfactoriamente');

        session()->flash('message', 'Curso actualizado exitosamente');

    }else{
        $image = $this->image->store('storage/courses', 'public_uploads');
        $this->user_id = auth()->user()->id;
        Course::create([
            'user_id' => $this->user_id,
            'name' => $this->course['name'],
            'category_id' => $this->course['category_id'],
            'slug' => $this->course['slug'],
            'image' => $image,
            'description' => $this->course['description'],
        ]);
        

        $this->reset(['open_edit','image']);

        $this->identificador = rand();
        //$this->emitTo('show-courses', 'renderizar');
        //$this->emit('alert', 'El curso se creó satisfactoriamente');
        session()->flash('message', 'Curso creado exitosamente');
    }
    
    }

}
