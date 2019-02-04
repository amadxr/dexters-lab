@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <experiment-form-component :detail="{{ json_encode($experiment) }}"></experiment-form-component>
            </div>
        </div>
    </div>
@endsection
