@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <experiment-form-component
                    :parent="{{ $parent }}">
                </experiment-form-component>
            </div>
        </div>
    </div>
@endsection
