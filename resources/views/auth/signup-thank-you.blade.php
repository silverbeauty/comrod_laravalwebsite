@extends('layouts.master')

@section('title', trans('app.thank-you-for-signing-up'))
@section('description', trans('app.thank-you-for-signing-up'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="Content__Heading"><span>{{ trans('app.thank-you-for-signing-up') }}</span></h2><br>
                {!! trans('app.thank-you-for-signing-up-text', ['url' => session('url.intended', auth()->user()->url)]) !!}                
            </div>
        </div>
    </div>

    <script>
        (function redirect(i) {
            setTimeout(function () {
                document.getElementById('counter').innerHTML = i;

                if (--i) {
                    return redirect(i);
                }

                window.location.href = "{{ session('url.intended', auth()->user()->url) }}";
            }, 1000)
        })(10);
    </script>
@stop