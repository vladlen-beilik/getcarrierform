@extends('inc.layout')
@section('content')
    <div class="page-form__inner">
        @include('inc.loadMobile')
        @include('inc.load', ['active' => 1])
        <div class="page-form__body">
            <form action="">
                <div class="page-form__padding" id="indexForm1">
                    <index-form1 data-title="Please indicate your vehicle year, make and model"></index-form1>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop