<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Course;
use Livewire\WithPagination;

class ShowPost extends Component
{

    use WithPagination;
    public $post, $identificador;

    public $name, $course_id, $free;
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';

    public $courses;

    public $readyToLoad = false;

    public $cant = '10';

    public $open_edit=false;
    public $open_delete=false;

    protected $listeners = ['renderizar'=>'render'];
    protected $rules=[
        'post.name' => 'required',
        'post.course_id'=> 'required',
        'post.free' => 'required'
    ];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'search' => ['except' => ''],
        'direction' => ['except' => 'desc']
    ];

    

    public function mount(Post $post){
        
        $this->identificador = rand();
        
        $this->post = $post;
    }

    public function updatingSearch(){
        $this->resetPage();
    }


    public function render()
    {
        $this->courses = Course::all();
        if($this->readyToLoad){
        $posts = Post::where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('free', 'like', '%'.$this->search.'%')
                        ->orwhere('course_id', 'like', '%'.$this->search.'%')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->cant);    
                        
                    }else{
                        $posts =[];
                    }

        return view('livewire.show-post', compact('posts'));
    }

    public function loadPosts(){
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

    public function edit(Post $post){

        $this->post = $post;
        $this->open_edit = true;
    }

    public function confirmDelete ( $id)
    {
        //$article->delete();
        $this->open_delete = $id;
    }

    public function delete (Post $post)
    {
        $post->delete();
        $this->open_delete = false;
        session()->flash('message', 'Post eliminado exitosamente');
    }


    public function update(){
        
        if(isset($this->post->id)){
            $this->validate();
        $this->post->save();
        //resetar
        $this->reset(['open_edit']);

        $this->identificador = rand();

        
        //emitir alert
        //$this->emit('alert', 'El post se actualizo satisfactoriamente');

        session()->flash('message', 'Post actualizado exitosamente');

    }else{
        Post::create([
            'course_id' => $this->post['course_id'],
            'name' => $this->post['name'],
            'free' => $this->post['free'],
        ]);
        

        $this->reset(['open_edit']);

        $this->identificador = rand();
        //$this->emitTo('show-courses', 'renderizar');
        //$this->emit('alert', 'El curso se creó satisfactoriamente');
        session()->flash('message', 'Post creado exitosamente');
    }
    
    }
}
