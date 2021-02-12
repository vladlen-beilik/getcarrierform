@extends('inc.layout')
@section('content')
    <div class="page-form__inner">
        @include('inc.loadMobile')
        @include('inc.load', ['active' => 4])
        <div class="page-form__body" id="indexForm4">
            <index-form4 data-title="Where should we send your quotes?"></index-form4>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop