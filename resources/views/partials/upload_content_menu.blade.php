<nav class="nav Switch pull-right">
    <ul class="nav navbar-nav pull-right upload-ul">
        <li>
            <label class="radio-inline">
                <input
                    type="radio"
                    name="content_type"
                    value="photo"
                    class="icheck redirect"
                    data-href="{{ route('upload::getPhoto') }}"
                    data-pjax="#uploadContentForm"
                    {{ $route_name == 'upload::getPhoto' ? 'checked="checked"' : '' }}
                >
                {{ trans('video.photo') }}
            </label>
        </li>
        <li>
            <label class="radio-inline">
                <input
                    type="radio"
                    name="content_type"
                    value="video"
                    class="icheck redirect"
                    data-href="{{ route('upload::getVideo') }}"  
                    data-pjax="#uploadContentForm"               
                    {{ $route_name == 'upload::getVideo' ? 'checked="checked"' : '' }}
                >
                {{ trans('video.video') }}
            </label>
        </li>
    </ul>
</nav>