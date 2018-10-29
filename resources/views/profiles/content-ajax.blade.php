
    <div class="modal-header no-border">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                
    </div>
    <div class="modal-body Video__Profile">
        <div class="row"> 
            <link href="/css/app.css" rel="stylesheet">
            @if (in_array(subdomain(), ['il', 'ar']))
                <link href="/css/app_ltr.css" rel="stylesheet">
            @endif
            <script src="{{ asset('js/app.js') }}" class="reloadable"></script>
            @include('underscore.comment')
            @include('modals.suggest_location')
            @include('modals.report_content')
            @include('modals.home_page_categories')

            <div class="col-md-12">
                <div class="Content__Profile__Player">                        
                    @if ($content->type == 'video')
                        <div class="embed-responsive embed-responsive-16by9 row">
                            @if ($content->embed_type == 'youtube')
                                <iframe                                    
                                    src="{{ $content->youtube_embed_url }}"
                                    frameborder="0"
                                    allowfullscreen
                                ></iframe>
                            @else
                                @if (empty($content->embed))
                                    
                                    
                                  							
            										
            									<div
                                                    class="flowplayer functional"
                                                    data-swf="{{ asset('flowplayer.swf') }}"
                                                    data-key="$108835620266723"
            								       >	
            										
                               
                                        
                                        <video autoplay poster="{{ $content->video_poster_url }}">
                                            <source type="video/mp4" src="{{ $content->video_default_url }}">                                
                                        </video>
                                   </div>
                               @else
                                    {!! $content->embed !!}
                               @endif
                           @endif
                       </div>
                    @else
                        <img src="{{ $content->photo_url }}" alt="{{ $content->title }}" class="img-responsive">
                    @endif                        
                </div>
                <div class="row Content__Profile">
                    <div class="col-md-9 col-sm-12 col-xs-12 Content">
                        <div>
                            <div class="Content__Profile__Heading">
                                <h1 class="title">{{ $content->title }}</h1>
                                <div class="text-right">
                                    <i class="flag-icon flag-icon-{{ strtolower($content->country_code) }}"></i>
                                    {{ $address }}<br/>
                                    {{ $content->offence_date_time }}
                                </div>
                            </div>                    
                            <div class="Content__Profile__Footer">
                                <div>
                                    <div class="date-added">{{ trans('video.added') }}: {{ $content->created_at }}</div>
                                    <div class="navbar">
                                        <ul class="nav navbar-nav settings-ul">
                                            <li>
                                                <a href="{{ $content->owner->url }}">
                                                    <img src="{{ $content->owner->small_avatar }}" class="img-circle">
                                                    <b>{{ $content->owner->username }}</b>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="collapse" data-target="#shareCollapse">
                                                    <i class="fa fa-share-alt"></i> {{ trans('video.share') }} {{ ucfirst($type) }}
                                                </a>                                        
                                            </li>
                                            <li>
                                                <a
                                                    data-toggle="modal"
                                                    data-target="#reportContentModal"
                                                    data-backdrop="static"
                                                >
                                                    <i class="fa fa-exclamation-triangle"></i> {{ trans('video.report-content') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>                            
                                </div>
                                <div class="text-right">
                                    {{ trans('video.views') }}: <b>{{ $content->formatted_total_views }}</b><br/>
                                    <a
                                        title="{{ trans('video.like') }}"
                                        class="btn-ajax @if(Auth::check() && $content->isVoted(Auth::user(), 'like')) selected @endif"
                                        data-url="{{ $content->like_url }}"
                                        data-ajax-data='{"id": {{ $content->id }}}'
                                        data-likes-counter="#contentLikesCounter"
                                        data-dislikes-counter="#contentDislikesCounter"
                                        data-loading-text="{!! button_loading() !!}"
                                        data-callback="likeDislike"
                                    ><i class="fa fa-thumbs-up"></i></a>
                                    <span id="contentLikesCounter">{{ $content->total_likes }}</span> &nbsp;&nbsp;
                                    <a
                                        title="{{ trans('video.dislike') }}"
                                        class="btn-ajax @if(Auth::check() && $content->isVoted(Auth::user(), 'dislike')) selected @endif"
                                        data-url="{{ $content->dislike_url }}"
                                        data-ajax-data='{"id": {{ $content->id }}}'
                                        data-likes-counter="#contentLikesCounter"
                                        data-dislikes-counter="#contentDislikesCounter"
                                        data-loading-text="{!! button_loading() !!}"
                                        data-callback="likeDislike"
                                    ><i class="fa fa-thumbs-down"></i></a> 
                                    <span id="contentDislikesCounter">{{ $content->total_dislikes }}</span>
                                </div>
                            </div>
                            <div class="collapse Share__Collapse" id="shareCollapse">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li
                                        role="presentation"
                                        class="active"
                                    >
                                        <a
                                            id="shareTabTrigger"
                                            role="tab"
                                            data-toggle="tab"
                                            data-target="#shareTab"
                                            aria-controls="shareTab"
                                            aria-expanded="false"
                                        >{{ trans('video.share') }}</a>
                                    </li>
                                    <li
                                        role="presentation"                                        
                                    >
                                        <a
                                            class="focus-trigger"
                                            role="tab"
                                            id="embedTabTrigger"
                                            data-target-focus="#contentEmbedCode"
                                            data-toggle="tab"
                                            data-target="#embedTab"
                                            aria-controls="embedTab"
                                            aria-expanded="true"
                                        >{{ trans('video.embed') }}</a>
                                    </li>                                    
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="shareTab" aria-labelledby="shareTabTrigger">
                                        <ul class="navbar-social">
                                            <li>
                                                <a
                                                    class="popup"
                                                    data-url="{{ $content->facebook_share_url }}"
                                                >
                                                    <i class="fa fa-facebook-square"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    class="popup"
                                                    data-url="{{ $content->twitter_share_url }}"
                                                >
                                                    <i class="fa fa-twitter-square"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    class="popup"
                                                    data-url="{{ $content->tumblr_share_url }}"
                                                >
                                                    <i class="fa fa-tumblr-square"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    class="popup"
                                                    data-url="{{ $content->google_plus_share_url }}"
                                                >
                                                    <i class="fa fa-google-plus-square"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="embedTab" aria-labelledby="embedTabTrigger">
                                        <textarea id="contentEmbedCode" class="form-control select-all" rows="3"><iframe src="{{ route('getEmbed', $content->id) }}" frameborder="0" scrolling="no" height="342" width="600"></iframe><br><strong>{{ $content->title }}</strong> - {{ trans('video.powered-by') }} <a href="{{ route('home') }}">{{ trans('app.domain_name') }}</a></textarea>
                                    </div>                                
                                </div>                                
                            </div>
                            @if (count($content->categories))
                                <div class="Content__Profile__Categories">
                                    {{ trans('video.category') }}: 
                                    @foreach ($content->categories->load('category') as $category)
                                        <?php $niche = $category->category; ?>
                                        @if ($niche)
                                            <a href="{{ route('home', ['cat' => $category->niche_id]) }}">{{ $niche->name }}</a>&nbsp;
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            @if ($content->description)
                                <div class="Content__Profile__Description">
                                    <h4 class="header-title">{{ trans('video.description') }}</h4>
                                    <p class="body">{!! linkify($content->description) !!}</p>
                                </div>
                            @endif
                        </div>

                        @if (!$content->disable_comments)
                            <div id="comments" class="Content__Profile__Comments">
                                @include('partials.comments')
                            </div>
                        @endif
                    </div>
                    @include('partials.side_bar')
                </div>
            </div>
            <style type="text/css">
                a.selected {
                    color: #19769a;
                }
            </style>
        </div>
    </div>   