@extends('inc.layout')
@section('content')
    <div class="container">
        <div class="page-form__inner">
            @include('inc.loadMobile')
            @include('inc.load', ['active' => 5])
            <div class="page-form__body">
                <div class="page-form__padding">
                    <div class="page-form__p-w">
                        <div class="page-form__end">
                            <div class="page-form__end-elips"></div>
                        </div>
                        <h3 class="page-form__title">Thanks you! Your quotes are on the way to your email!</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop