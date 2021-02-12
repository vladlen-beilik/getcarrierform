@extends('inc.layout')
@section('content')
    <div class="container">
        <div class="page-form__inner">
            @include('inc.loadMobile')
            @include('inc.load')
            <div class="page-form__body">
                <form action="">
                    <div class="page-form__padding">
                        <div class="page-form__p-w">
                            <h3 class="page-form__title">Get Free Auto Transport Quotes Now!</h3>
                            <div class="page-form__text">Online quotes from top-rated companies. Pre-screened drivers, insurance included, no payment upfront</div>
                            <div class="page-form__form-wrapper">
                                <div class="page-form__form page-form__form-1" id="indexForm">
                                    <index-form></index-form>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop