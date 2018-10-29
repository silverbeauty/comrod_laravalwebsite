<div
    id="main-content-carousel"
    class="Main__Content__Carousel position-relative"
    style="max-height:790px;overflow-y:auto;overflow-x:hidden;"
>
    <div class="loader-backdrop">
        <div class="backdrop"></div>
        <div class="indicator">
            <span><i class="fa fa-spinner fa-pulse"></i> {{ trans('home.loading') }}...</span>                                
        </div>
    </div>
    <input type="hidden" name="total_main_content_carousel_items" value="">
    {{--<a
        id="slide-left-control"
        class="left carousel-control hidden"
        role="button"
        data-slide="left"
        data-current-item-id="0"
        style="display:none;"
    >
        <span class="fa fa-chevron-circle-left fa-2x" aria-hidden="true"></span>
        <span class="sr-only">{{ trans('home.previous') }}</span>
    </a>
    <a
        id="slide-right-control"
        class="right carousel-control hidden"
        role="button"
        data-slide="right"
        data-current-item-id="0"                            
        style="display:none;"                            
    >
        <span class="fa fa-chevron-circle-right fa-2x" aria-hidden="true"></span>
        <span class="sr-only">{{ trans('home.next') }}</span>
    </a> --}}
    <div class="padding-10 text-center{{ $contents['total'] > 0 ? ' hidden' : '' }}" id="noResultMessage">{{ trans('app.no_marker_message') }}</div>
    <div id="carousel-item-0" class="Listing gutter-5 sortable-content padding-10">
        <?php $key = 0; ?>
        <div class="row">
            @foreach ($contents['items'] as $key => $content)
                <div class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10 thumbnail-wrapper" id="col-{{ $key }}">
                    <div id="content-thumbnail-{{ $key }}" data-id="{{ $content['id'] }}" class="content-thumbnail">
                        <div id="thumbnail-{{ $content['id'] }}" class="Thumbnail hoverable {{ in_array($content['id'], is_array($watched) ? $watched : $watched->toArray()) ? 'watched' : '' }}" data-marker-id="{{ $content['id'] }}">
                            <a
                                href="{{ url() . '/' . $content['type'] . '/' . str_slug($content['title']) . '-' . $content['id'] }}"
                                class="pjax"
                                data-pjax-container="#pjaxModalContentContainer"
                                data-pjax-fragment="#content-fragment"
                                data-toggle="modal"
                                data-target="#contentModal"
                            >
                                <div class="Thumbnail__Header">
                                    <div>
                                        <span>{{ $content['title'] }}</span>
                                        <i class="flag-icon flag-icon-{{ strtolower($content['cc']) }}"></i>
                                    </div>
                                    <div class="backdrop"></div>
                                </div>
                                <img class="img-responsive lazy" data-original="{{ $content['tu'] }}">
                            </a>
                            <div class="nav Thumbnail__Footer">
                                @if (in_array($content['id'], is_array($watched) ? $watched : $watched->toArray()))
                                    <span class="watched-label">{{ trans('app.watched') }}</span>
                                @endif
                                <ul class="nav navbar-nav">
                                    <li><i class="fa fa-eye"></i> {{ $content['mv'] }}</li>
                                    <li><i class="fa fa-comments"></i> {{ $content['md'] }}</li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">                                        
                                    <li><i class="fa fa-thumbs-up"></i> {{ $content['hr'] }}</li>
                                    {{-- <li><i class="fa fa-thumbs-down"></i> {{ $content->total_dislikes }}</li> --}}
                                </ul>
                                <div class="backdrop"></div>
                            </div>                                                
                        </div>                                            
                    </div>
                </div>
                <?php $key++; ?>                                   
            @endforeach
        </div>                  
    </div>    
</div>