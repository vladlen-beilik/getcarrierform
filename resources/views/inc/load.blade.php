<div class="page-form__load" id="load">
    <div class="page-form__padding">
        <div class="page-form__load-box">
            <div class="page-form__logo">
{{--                <a class="" href="{{ url('') }}">--}}
                    <div class="page-form__logo-img" style="background-image:url({{ url('icons/logo.png') }})"></div>
{{--                </a>--}}
            </div>
            <div class="page-form__load-list">
                <div class="page-form__load-title">Your Quote Details:</div>
                @foreach(['Pickup/Delivery zip or City', 'Vehicle year, make and model', 'Open or Enclosed Trailer', 'Dates', 'Your Free Quotes'] as $text)
                    <div class="page-form__load-item{!! isset($active) && $loop->index < $active ? ' active' : null !!}">
                        <div class="page-form__load-elips{!! isset($active) && $loop->index < $active ? ' active' : null !!}"></div>
                        <div class="page-form__load-item-text">{!! $text !!}</div>
                    </div>
                @endforeach
            </div>
            <div class="page-form__load-imgs">
                <img src="{{ url('img/load-img.png') }}" alt="" class="page-form__load-img">
            </div>
            <div class="page-form__load-links">
                <div class="page-form__load-link">
                    <img src="{{ url('img/load-img-1.png') }}" alt="" class="page-form__load-link-img">
                </div>
                <div class="page-form__load-link">
                    <img src="{{ url('img/load-img-2.png') }}" alt="" class="page-form__load-link-img">
                </div>
                <div class="page-form__load-link">
                    <img src="{{ url('img/load-img-3.png') }}" alt="" class="page-form__load-link-img">
                </div>
            </div>
        </div>
    </div>
    <div class="page-form__footer-inner load">
        <div class="page-form__footer-list">
            <a href="#" class="page-form__footer-link">Privacy Policy</a>
            <a href="#" class="page-form__footer-link">Terms and Conditions</a>
            <a href="#" class="page-form__footer-link">Do Not Sell My Info</a>
            <a href="#" class="page-form__footer-link">Join Our Network</a>
        </div>
    </div>
</div>