<footer>
    <div class="container text-center">
        <ul class="nav">
            <li><a href="{{ route('about-us') }}">{{ trans('footer.about-us') }}</a></li>
            <li><a href="{{ route('contact-us') }}">{{ trans('footer.contact-us') }}</a></li>
            <li><a href="{{ route('terms-and-conditions') }}">{{ trans('footer.terms-and-conditions') }}</a></li>
            <li><a href="{{ route('uploading-rules') }}">{{ trans('footer.uploading-rules') }}</a></li>
        </ul><br/>
        <ul class="nav with-padding-li">
            <li>&copy; {{ date('Y') }}</li>
            <li>Comroads.com</li>
            <li>{{ trans('footer.all-right-reserved') }}</li>            
        </ul>
    </div>
</footer>