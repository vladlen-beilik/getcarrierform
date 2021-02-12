@extends('inc.layout')
@section('content')
    <div class="container">
        <div class="page-form__inner">
            @include('inc.loadMobile')
            @include('inc.load', ['active' => 2])
            <div class="page-form__body" id="indexForm2">
                <index-form2 data-title="Please indicate your vehicle year, make and model"></index-form2>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop