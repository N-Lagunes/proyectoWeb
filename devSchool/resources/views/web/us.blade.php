@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h2 class="display-3">¿Quienes somos?</h2>
                </div>

                <div class="panel-body">
                    <div class="">
                        <img src="https://www.ikerg1972.com/wp-content/uploads/2019/05/LARAVEL.png" 
                        alt="" class="img-responsive" style ="border-radius:15px;">
                        <div class="" style="margin: 2% 2%;">
                            <ul class="list-group">
                                <li class="list-item" type="circle">
                                    <p class="fw-bold">Bold text.</p>

                                    <p class="fst-italic">Conoce nuestros objetivos. . .</p> 
                                    <p class="text-justify">El objetivo principal de nuestra página web es desarrollar un LMS 
                                        (Learning Management System) que ayude a los estudiantes, desarrolladores
                                        e ingenieros relacionados con el software.</p>
                                </li>
                                <li class="list-item" type="circle">
                                    <p>¿Como se piensa lograr esto?. . .</p>
                                    <p class="text-justify">Recuperando los mejores tutoriales en formato de video, de libre uso y 
                                    distribución, para juntarlos en un solo recurso (la página web).
                                    Generando códigos útiles y claros de mini proyectos, haciendo el mejor uso
                                    posible de la documentación y la autodocumentación, para que puedan descargar 
                                    de la plataforma.</p>
                                </li>
                            </ul> 
                            
                            
                            
                            
                            

                            
                        </div>
                    </div>    
                    
                </div>
                {{--  --}}
            </div>
        </div>
    </div>
</div>
@endsection