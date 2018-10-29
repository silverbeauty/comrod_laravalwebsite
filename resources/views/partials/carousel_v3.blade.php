<div
    id="main-content-carousel"
    class="Main__Content__Carousel position-relative"    
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
    <div id="carousel-item-0" class="Listing gutter-5 sortable-content">                
        @foreach ($contents['items'] as $key => $content)       
            <div id="content-thumbnail-{{ $key }}" data-id="{{ $content['id'] }}" class="content-thumbnail">
                <div id="thumbnail-{{ $content['id'] }}" class="Thumbnail hoverable {{ in_array($content['id'], is_array($watched) ? $watched : $watched->toArray()) ? 'watched' : '' }}" data-marker-id="{{ $content['id'] }}">
                    <a
                        href="{{ url() . '/' . $content['type'] . '/' . str_slug($content['title']) . '-' . $content['id'] }}"
                        class="pjax inline-block gutter-5"
                        data-pjax-container="#pjaxModalContentContainer"
                        data-pjax-fragment="#content-fragment"
                        data-toggle="modal"
                        data-target="#contentModal"
                    >
                        <div class="position-relative" style="min-height:200px;">                                    
                            <div class="Thumbnail__Header">
                                <div>
                                    <i class="flag-icon flag-icon-{{ strtolower($content['cc']) }}"></i>
                                </div>                                
                            </div>
                            <img class="img-responsive lazy main" data-original="{{ $content['tu'] }}">                                    
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
                        <div class="row footer panel-body">
                            <div class="col-xs-8">
                                <h3 class="text-left text-primary h5 no-margin margin-bottom-10"><b class="ellipsis">{{ $content['title'] }}</b></h3>
                                <table>
                                    <tr>
                                        <td class="padding-right-5"><i class="fa fa-tag text-muted fa-lg fa-rotate-90"></i></td>
                                        @foreach ($content['cat'] as $category)
                                            <td class="padding-right-5">
                                                <img src="/images/categories/icon_{{ $category }}.png" class="category-icon">
                                            </td>
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                            @if ($content['dur'])
                                <div class="col-xs-4 text-right">
                                    <span class="text-muted">{{ trans('app.duration') }}: {{ $content['dur'] }}</span>
                                </div>
                            @endif
                        </div>
                    </a>                                                
                </div>                                            
            </div>                     
        @endforeach        
    </div>
    <div class="text-center{{ $contents['total'] > 0 ? ' hidden' : '' }}" id="noResultMessage">{{ trans('app.no_marker_message') }}</div>
    <div class="text-center{{ $contents['total'] <= $limit ? ' hidden' : ''}}" id="viewMoreWrapper">
        <br>
        <a class="btn btn-primary" id="viewMore" data-loading-text="{!! button_loading(trans('home.loading') . '...') !!}">
            <i class="fa fa-chevron-circle-down"></i> {{ trans('app.view-more') }}
        </a>
    </div>
</div>