<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Post;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
        Constructor que nos permite ocupar el middleware 
        (capturador de mitad de camino)
    */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /*
        La función index nos lleva a obtenr los posts ordenados de manera 
        descendente gracias al id, sí y sólo sí el user ID esta autorizado, 
        lo cual nos permite paginar y mantener la seguridad entre los autores
        compact() toma un número variable de parámetros. Cada parámetro puede ser una 
        cadena que contiene el nombre de la variable, o un array de nombres de variables. El array puede contener otros arrays de nombres de variables dentro de él; compact() los trata recursivamente.
    */
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')
            ->where('user_id', auth()->user()->id)
            ->paginate();
        //view().../resources/views/admin/posts/index
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
        En la función "crear" nos permite gracias a las categorias ordenadas
        de manera ascendente y los tags ordenamos de manera ascendente 
        acceder a la vista create
    */
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
        $tags       = Tag::orderBy('name', 'ASC')->get();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
        En la función de almacenamiento ocupamos un método creado con 
        PostStoreRequest creado gracias a make:request 'name'
        entonces conseguimo ocupamos el método crear en dónde requermimos todo
        ¿qué es todo? = protected $fillable =[
        'user_id','category_id','name','slug','excerpt','body','status','file'];
        
        Tenemos un método para la imagen donde espécificamos sí exíste una imagen
        entonces ocupando Storage los guaramos en public/image/item
        luego lo llenamos y guardamos, recordando que el método asset()
        $url = asset('img/photo.jpg'); // http://example.com/assets/img/photo.jpg

        en la parte del tag ocupamos em método attach() donde une el tag al post
    */
    public function store(PostStoreRequest $request)
    {
        $post = Post::create($request->all());
        /*all()...request[ele1 ele2 ele3 category_id tag_id,file....] */
        //IMAGE
        if($request->file('file')){
            $path = Storage::disk('public')->put('image',  $request->file('file'));
            $post->fill(['file' => asset($path)])->save();
        }
        //dd($request->all());
         //TAGS
         $post->tags()->attach($request->get('tags'));

        return redirect()->route('posts.edit', $post->id)->with('info', 'Categoría creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /* 
        la función "mostrar" búsca el post y lo pone en la vista post    
    */
    public function show($id)
    {
        $post = Post::find($id);

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /* */
    public function edit($id)
    {
        $post       = Post::find($id);
        $this -> authorize('pass', $post);

        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
        $tags       = Tag::orderBy('name', 'ASC')->get();
        
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
        
    */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::find($id);
        $this -> authorize('pass', $post);
        $post->fill($request->all())->save();

        //IMAGE Storage::disk('public')....Public/image/file
        if($request->file('file')){
            $path = Storage::disk('public')->put('image',  $request->file('file'));
            $post->fill(['file' => asset($path)])->save();
        }

         //TAGS
         $post->tags()->sync($request->get('tags'));

        return redirect()->route('posts.edit', $post->id)->with('info', 'Categoría actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $this -> authorize('pass', $post);
        $post->delete();
        return back()->with('info', 'Eliminado correctamente');
    }
}
