<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Post;
use App\Category;
use App\Tag;

class PageController extends Controller
{   /*    
     Acción <-middleware <-respuesta  <-BD
    MVC -> request ->middleware -> controller ->BD 

        Obtengo de los posts de Post y de ordenan de manera descendente por su ID
        se paginan en 3 y regresan a la vista /views/web/posts.
        ocupando el método compact('variable') 
     */
    public function blog(){
        $posts = Post::orderBy('id','DESC')->where('status','PUBLISHED')->paginate(3);
        return view('web.posts',compact('posts'));
        //vistas(/resources/view/...web/posts)
        //controlador.método
    }
    
    /* 
        Obteemos la categoria con el paramétro slug donde la categoria...
        con le método pluck().....y ....->first()
        devolvemos los posts ocupando la relación que existe con category_id
        se ordenan por un ID de manera descendente y donde el status sea Publicadado
        paginamos en 3 y retornamos a la vista /views/web/posts.
        ocupando el método compact('variable')
    */
    public function category($slug){
        $category = Category::where('slug', $slug)->pluck('id')->first();

        $posts = Post::where('category_id', $category)
            ->orderBy('id', 'DESC')->where('status', 'PUBLISHED')->paginate(3);

        return view('web.posts', compact('posts'));
    }

    /*
        la función tag que recibe el parámetro slug 
        almacenamos en la variable posts los Post donde tengan los mismos tags
        query use slug = busqueda que ocupa el parámetro slug
        en resumén nos devuleve la vista con los post que posean los mismos tags
    */
    public function tag($slug){ 
        $posts = Post::whereHas('tags', function($query) use ($slug) {
            $query->where('slug', $slug);
        })
        ->orderBy('id', 'DESC')->where('status', 'PUBLISHED')->paginate(3);

        return view('web.posts', compact('posts'));
    }
    /*
        la función posts que recibe el parametro slug
        en la variable post búscamos dónde el slug sea el primero con el método first()
        regresa a la vista de los post
    */
    public function post($slug){
       $post = Post::where('slug',$slug)->first();
       
       return view('web.post',compact('post'));
    }
    /*
        una vista que nos regresa quienes somos nosotros! :D
    */
    public function us(){
        return view('web.us');
    }
}
