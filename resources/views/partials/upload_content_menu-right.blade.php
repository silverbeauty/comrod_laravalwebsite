<nav class="nav Switch pull-right">
    <ul class="nav navbar-nav pull-right upload-ul">
        <li>
            <label class="radio-inline">
                {{ trans('video.photo') }} 
                <input
                    type="radio"
                    name="content_type"
                    value="photo"
                    class="icheck redirect"
                    data-href="{{ route('upload::getPhoto') }}"
                    data-pjax="#uploadContentForm"
                    {{ $route_name == 'upload::getPhoto' ? 'checked="checked"' : '' }}
                >
            </label>
        </li>
        <li>
            <label class="radio-inline">
                {{ trans('video.video') }} 
                <input
                    type="radio"
                    name="content_type"
                    value="video"
                    class="icheck redirect"
                    data-href="{{ route('upload::getVideo') }}"  
                    data-pjax="#uploadContentForm"               
                    {{ $route_name == 'upload::getVideo' ? 'checked="checked"' : '' }}
                >
            </label>
        </li>
    </ul>
</nav>