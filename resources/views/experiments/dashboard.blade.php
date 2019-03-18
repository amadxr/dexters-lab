@extends('dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <experiments-dashboard
                    :value="{{ json_encode($info) }}">
                </experiments-dashboard>
            </div>
        </div>
    </div>
@endsection
