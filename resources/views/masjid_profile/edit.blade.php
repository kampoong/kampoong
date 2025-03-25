@extends('layouts.settings')

@section('title', __('kampoong_profile.edit'))

@section('content_settings')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="page-header"><h1 class="page-title">@yield('title')</h1></div>
        <div class="row">
            <div class="col-md-6">
                {{ Form::open(['route' => 'kampoong_profile.update', 'method' => 'patch']) }}
                    <div class="card">
                        <div class="card-body">
                            {!! FormField::text('kampoong_name', ['required' => true, 'value' => old('kampoong_name', Setting::get('kampoong_name', config('kampoong.name'))), 'label' => __('kampoong_profile.name')]) !!}
                            {!! FormField::textarea('kampoong_address', ['required' => true, 'value' => old('kampoong_address', Setting::get('kampoong_address')), 'label' => __('kampoong_profile.address')]) !!}
                            {!! FormField::text('kampoong_city_name', [
                                'required' => true,
                                'value' => old('kampoong_city_name', Setting::get('kampoong_city_name')),
                                'label' => __('kampoong_profile.city_name'),
                                'info' => ['text' => __('kampoong_profile.city_name_help')],
                            ]) !!}
                            {!! FormField::text('kampoong_google_maps_link', ['value' => old('kampoong_google_maps_link', Setting::get('kampoong_google_maps_link')), 'label' => __('kampoong_profile.google_maps_link')]) !!}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">{{ __('app.social_media') }}</div>
                        <div class="card-body">
                            {!! FormField::text('kampoong_whatsapp_number', ['value' => old('kampoong_whatsapp_number', Setting::get('kampoong_whatsapp_number')), 'label' => 'Whatsapp', 'addon' => ['before' => 'https://wa.me/']]) !!}
                            {!! FormField::text('kampoong_instagram_username', ['value' => old('kampoong_instagram_username', Setting::get('kampoong_instagram_username')), 'label' => 'Instagram', 'addon' => ['before' => 'https://instagram.com/']]) !!}
                            {!! FormField::text('kampoong_youtube_username', ['value' => old('kampoong_youtube_username', Setting::get('kampoong_youtube_username')), 'label' => 'Youtube', 'addon' => ['before' => 'https://youtube.com/']]) !!}
                            {!! FormField::text('kampoong_facebook_username', ['value' => old('kampoong_facebook_username', Setting::get('kampoong_facebook_username')), 'label' => 'Facebook', 'addon' => ['before' => 'https://facebook.com/']]) !!}
                            {!! FormField::text('kampoong_telegram_username', ['value' => old('kampoong_telegram_username', Setting::get('kampoong_telegram_username')), 'label' => 'Telegram', 'addon' => ['before' => 'https://t.me/']]) !!}
                        </div>
                        <div class="card-footer">
                            {{ Form::submit(__('kampoong_profile.update'), ['class' => 'btn btn-success']) }}
                            {{ link_to_route('kampoong_profile.show', __('app.cancel'), [], ['class' => 'btn btn-link']) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <label>{{ __('kampoong_profile.kampoong_logo') }}</label>
                        <div class="form-group" id="kampoong-logo">
                            @if (Setting::get('kampoong_logo_path'))
                                <img id="kampoong_logo_image_show" class="img-fluid" src="{{ Storage::url(Setting::get('kampoong_logo_path'))}}" alt="{{ Setting::get('kampoong_name') ?? 'Kampoong'}}">
                            @endif
                        </div>
                        @php
                            $labelText = __('kampoong_profile.upload_logo');
                            if (Setting::get('kampoong_logo_path')) {
                                $labelText = __('kampoong_profile.change_logo');
                            }
                        @endphp
                        <label for="kampoong_logo_image" class="btn btn-secondary">{{ $labelText }}</label>
                        {!! FormField::file('kampoong_logo_image', [
                            'label' => false,
                            'id' => 'kampoong_logo_image',
                            'class' => 'd-none',
                            'info' => ['text' => __('kampoong_profile.logo_rule')]
                        ]) !!}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <label>{{ __('kampoong_profile.kampoong_photo') }}</label>
                        <div class="form-group" id="kampoong-photo">
                            @if (Setting::get('kampoong_photo_path'))
                                <img id="kampoong_photo_image_show" class="img-fluid" src="{{ Storage::url(Setting::get('kampoong_photo_path'))}}" alt="{{ Setting::get('kampoong_name') ?? 'Kampoong'}}">
                            @endif
                        </div>
                        @php
                            $labelText = __('kampoong_profile.upload_photo');
                            if (Setting::get('kampoong_photo_path')) {
                                $labelText = __('kampoong_profile.change_photo');
                            }
                        @endphp
                        <label for="kampoong_photo_image" class="btn btn-secondary">{{ $labelText }}</label>
                        {!! FormField::file('kampoong_photo_image', [
                            'label' => false,
                            'id' => 'kampoong_photo_image',
                            'class' => 'd-none',
                            'info' => ['text' => __('kampoong_profile.photo_rule')]
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-kampoong-logo" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalKampoongLogo" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalKampoongLogo">{{ __('kampoong_profile.kampoong_logo') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container">
              <div class="row justify-content-center text-center">
                  <div class="col-md-8 justify-content-center text-center">
                      <img id="logo-image" src="" alt="{{ Setting::get('kampoong_name', config('kampoong.name')) }}">
                  </div>
                  <div class="col-md-4 justify-content-center text-center">
                      <div class="preview"></div>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.cancel')}}</button>
            <button type="button" class="btn btn-primary" id="crop_logo">{{__('app.crop_and_save')}}</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="modal-kampoong-photo" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalKampoongLogo" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalKampoongLogo">{{ __('kampoong_profile.kampoong_photo') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container">
              <div class="row justify-content-center text-center">
                  <div class="col-md-8 justify-content-center text-center">
                      <img id="photo-image" src="" alt="{{ Setting::get('kampoong_name', config('kampoong.name')) }}">
                  </div>
                  <div class="col-md-4 justify-content-center text-center">
                      <div class="preview"></div>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('app.cancel')}}</button>
            <button type="button" class="btn btn-primary" id="crop_photo">{{__('app.crop_and_save')}}</button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('styles')
    {{ Html::style(url('https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.css')) }}
@endsection

@push('scripts')
    {{ Html::script(url('https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js')) }}
    {{ Html::script(url('js/plugins/noty.js')) }}
    <script>
        var $modalLogo = $('#modal-kampoong-logo');
        var imageLogo = document.getElementById('logo-image');
        var cropper;

        $(document).on("change", "#kampoong_logo_image", function(e){
            var files = e.target.files;
            var done = function (url) {
                imageLogo.src = url;
                $modalLogo.modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $modalLogo.on('shown.bs.modal', function () {
            cropper = new Cropper(imageLogo, {
                aspectRatio: 1,
                viewMode: 2,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        $("#crop_logo").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 200,
                height: 200,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('api.kampoong_profile.upload_logo')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            'image': base64data
                        },
                        success: function(data){
                            var status = 'error';
                            if (data.image) {
                                if ($('#kampoong_logo_image_show').length) {
                                    $('#kampoong_logo_image_show').attr('src', data.image);
                                } else {
                                    $('#kampoong-logo').append(`<img id="kampoong_logo_image_show" class="img-fluid mt-2" src="${data.image}">`);
                                }
                                status = 'success';
                            }

                            noty({
                                type: status,
                                layout: 'bottomRight',
                                text: data.message,
                                timeout: 3000
                            });

                            $modalLogo.modal('hide');
                        },
                        error : function(data){
                            var status = 'error';
                            var errorMessage = data.responseJSON.message;
                            noty({
                                type: status,
                                layout: 'bottomRight',
                                text: errorMessage,
                                timeout: false
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        var $modalPhoto = $('#modal-kampoong-photo');
        var imagePhoto = document.getElementById('photo-image');
        var cropper;

        $(document).on("change", "#kampoong_photo_image", function(e){
            var files = e.target.files;
            var done = function (url) {
                imagePhoto.src = url;
                $modalPhoto.modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $modalPhoto.on('shown.bs.modal', function () {
            cropper = new Cropper(imagePhoto, {
                aspectRatio: 16 / 9,
                viewMode: 2,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        $("#crop_photo").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 960,
                height: 640,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('api.kampoong_profile.upload_photo')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            'image': base64data
                        },
                        success: function(data){
                            var status = 'error';
                            if (data.image) {
                                if ($('#kampoong_photo_image_show').length) {
                                    $('#kampoong_photo_image_show').attr('src', data.image);
                                } else {
                                    $('#kampoong-photo').append(`<img id="kampoong_photo_image_show" class="img-fluid mt-2" src="${data.image}">`);
                                }
                                status = 'success';
                            }

                            noty({
                                type: status,
                                layout: 'bottomRight',
                                text: data.message,
                                timeout: 3000
                            });

                            $modalPhoto.modal('hide');
                        },
                        error : function(data){
                            var status = 'error';
                            var errorMessage = data.responseJSON.message;
                            noty({
                                type: status,
                                layout: 'bottomRight',
                                text: errorMessage,
                                timeout: false
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
