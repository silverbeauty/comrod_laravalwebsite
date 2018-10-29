<div
    id="main-content-carousel"
    class="Main__Content__Carousel position-relative"
    style="max-height:810px;overflow-y:auto;overflow-x:hidden;">
    
    <input type="hidden" name="total_main_content_carousel_items" value="">    
    <div id="carousel-item-0" class="Listing gutter-5 sortable-content padding-10">
        <?php $key = 0; ?>        
        @foreach ($contents->chunk(2) as $chunkKey => $chunked)            
            <div class="row" id="row-{{ $chunkKey }}">
                @foreach ($chunked as $content)
                    @if ($content['@attributes']['available'])
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="content-thumbnail-{{ $key }}" data-id="{{ $content['@attributes']['id'] }}" class="content-thumbnail">
                                <div id="thumbnail-{{ $content['@attributes']['id'] }}" class="Thumbnail hoverable" data-marker-id="{{ $content['@attributes']['id'] }}">
                                    <a
                                        href="{{ route('liveFeed', ['id' => str_slug($content['location'] . '-' . $content['@attributes']['id'])]) }}"
                                        class="pjax"
                                        data-pjax-container="#pjaxModalContentContainer"
                                        data-pjax-fragment="#content-fragment"
                                        data-toggle="modal"
                                        data-target="#contentModal"
                                    >
                                        <div class="Thumbnail__Header">
                                            <div>
                                                <span>{{ $content['location'] }}</span>
                                                <i class="flag-icon flag-icon-gb"></i>
                                            </div>
                                            <div class="backdrop"></div>
                                        </div>
                                        <img class="img-responsive lazy" data-original="https://s3-eu-west-1.amazonaws.com/jamcams.tfl.gov.uk/{{ $content['file'] }}">
                                    </a>                                                                                    
                                </div>                                            
                            </div>
                        </div>
                    @endif
                    <?php $key++; ?>                                   
                @endforeach
            </div> 
        @endforeach           
    </div>
</div>