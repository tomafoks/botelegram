@extends('backend/layout/layout')


@section('content')
    @if (Session::has('status'))
        <div class="alert alert-info">
            <span>{{ Session::get('status') }}</span>
        </div>

    @endif
    <div>
        <div class="card-body">
            <form action="{{ route('admin.setting.store') }}" method="post">
                @csrf
                <h3>
                    <p>URL callback для telegram bot</p>
                </h3>
                <div class="input-group input-group-lg mb-3">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                            aria-expanded="false">
                            Действие
                        </button>
                        <ul class="dropdown-menu" style="">
                            <li class="dropdown-item">
                                <a href="#" onclick="document.getElementById('url_callback_bot').
                                                    value='{{ url('') }}'">Вставить url</a>
                            </li>
                            <li class="dropdown-item">
                                <a href="#" onclick="event.preventDefault();
                                                    document.getElementById('setWebHook').submit();">Отправить url</a>
                            </li>
                            <li class="dropdown-item">
                                <a href="#" onclick="event.preventDefault();
                                                    document.getElementById('getWebHookInfo').submit();">Получить
                                    информацию</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /btn-group -->
                    <input type="url" class="form-control" id="url_callback_bot" name="url_callback_bot"
                        value="{{ $setting->get('url_callback_bot') ?? '' }}">
                </div>
                <button class="btn btn-primary" type="submit">Сохранить</button>
            </form>

            <form action="{{ route('admin.setting.setWebHook') }}" method="post" id="setWebHook" style="display: none">
                @csrf
                <input type="hidden" name="url" value="{{ $setting->get('url_callback_bot') ?? '' }}">
            </form>

            <form action="{{ route('admin.setting.getWebHookInfo') }}" method="post" id="getWebHookInfo"
                style="display: none">
                @csrf
            </form>
        </div>

    </div>

@endsection
