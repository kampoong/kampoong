<div>
    @if (Setting::get('kampoong_logo_path'))
        <div class="mb-3">
            <a href="{{ url('/') }}">
                <img src="{{ Storage::url(Setting::get('kampoong_logo_path'))}}" style="width: 150px">
            </a>
        </div>
    @endif
    <div>
        <span class="fs-2">Assalamu'alaikum</span><br>
        <a class="fs-1 fw-bold lh-sm text-dark" href="{{ url('/') }}">{{ Setting::get('kampoong_name', config('kampoong.name')) }}</a>
    </div>
    @if (Setting::get('kampoong_address'))
    <div class="mt-3 pe-5 fs-5 text-black-50">{!! nl2br(htmlentities(Setting::get('kampoong_address'))) !!}<br>{{Setting::get('kampoong_city_name')}}</div>
    @endif
</div>
