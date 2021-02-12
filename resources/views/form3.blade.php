@extends('inc.layout')
@section('content')
    <div class="container">
        <div class="page-form__inner">
            @include('inc.loadMobile')
            @include('inc.load', ['active' => 3])
            <div class="page-form__body" id="indexForm3">
                <index-form3 data-title="How soon do you need to transport your car?"></index-form3>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop