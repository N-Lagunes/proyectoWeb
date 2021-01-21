@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">¿Quienes somos?</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    Somos una página dónde podras encontrar los tutoriales más 
                    actuales por miembros de una asombrosa comunidad con gente 
                    como TU, que tienen la meta de no parar de aprender!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection