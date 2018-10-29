<div class="col-md-4 col-sm-4 col-xs-12 @if(Request::url() == url()) slider-each-cont @else video-page-single-video @endif">
    <div>
        <div class="Thumbnail">
            <a
                href="{{ $content->url }}"
                class="pjax"
                data-pjax-container="#pjaxModalContentContainer"
                data-pjax-fragment="#content-fragment"
                data-toggle="modal"
                data-target="#contentModal"
            >
                <div class="Thumbnail__Header">
                    <div>
                        <span>{{ $content->title }}</span>
                        <i class="flag-icon flag-icon-{{ strtolower($content->country_code) }}"></i>
                    </div>
                    <div class="backdrop"></div>
                </div>                                                    
                <img class="img-responsive lazy" data-original="{{ $content->thumbnail_url }}">
            </a>
            <div class="nav Thumbnail__Footer">
                <ul class="nav navbar-nav navbar-padding-li">
                    <li><i class="fa fa-eye"></i> {{ $content->formatted_total_views }}</li>
                    <li><i class="fa fa-comments"></i> {{ $content->total_comments }}</li>
                </ul>
                <ul class="nav navbar-nav navbar-right navbar-padding-li">
                    <li><i class="fa fa-thumbs-up"></i> {{ $content->total_rating }}</li>
                    @if ($user->own($content->user_id))
                        <li>
                            <a href="{{ $content->edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
                        </li>
                    @endif
                    {{-- <li><i class="fa fa-thumbs-down"></i> {{ $content->total_dislikes }}</li> --}}
                </ul>
                <div class="backdrop"></div>
            </div>
        </div>
    </div>
</div>