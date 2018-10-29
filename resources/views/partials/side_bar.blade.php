<div class="col-md-4 col-sm-12 col-xs-12 Sidebar">
    @if (!$request->ajax())
    {{--<div class="Sidebar__Search">        
        <form action="">
            <div class="input-group">
                <input type="text" name="q" value="" class="form-control input-sm" placeholder="{{ trans('search.enter_city') }}">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
    </div>--}}
    @endif  
    <div class="Sidebar__Ad overflow-hidden">
        <?php $sidebar_ad = ad(3); ?>
        @if ($sidebar_ad)
            {!! $sidebar_ad->code !!}
        @else
            {{ trans('home.advertise-here') }}
        @endif
    </div>
    {{--<div>
        <div class="Sidebar__Heading">Videos by country</div>
        <div class="Sidebar__Countries">
            @foreach (countries_with_videos() as $key => $country)
                <a
                    href="{{ route('home', ['geo' => strtolower($country->code)]) }}"
                    class="country-map-trigger {{ $key > 9 ? 'hidden-element hidden' : '' }}"
                    data-country-name="{{ $country->name }}"
                    data-country-code="{{ $country->code }}"
                >
                    <i class="flag-icon flag-icon-{{ strtolower($country->code) }}"></i>
                    {{ $country->name }}
                </a>
            @endforeach
        </div>
        <div class="text-right">
            <a class="show" data-parent=".Sidebar__Countries"><i class="fa fa-chevron-circle-down fa-lg"></i></a>            
        </div>
    </div>
    <div>
        <div class="Sidebar__Heading">Categories</div>
        <div class="Sidebar__Categories">
            @foreach (categories_with_videos(1, 'categories_with_videos_category') as $key => $category)
                <a
                    {{ $route_name != 'home' ? "href=".route('home', ['cat' => $category->id]) : '' }}
                    class="category-filter"
                    data-category-id={{ $category->id }}                  
                >
                    <img src="{{ $category->icon_url }}">
                    <span>{{ $category->name }}</span>
                    {{-- <span>{{ $category->total_content }}</span> --
                    @if ($route_name == 'home')
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, $category_filters) ? 'checked' : '' }}
                        >
                    @endif
                </a>
            @endforeach            
        </div>        
    </div>
    <div>
        <div class="Sidebar__Heading">Dangerous behavior</div>
        <div class="Sidebar__Categories">
            @foreach (categories_with_videos(2, 'categories_with_videos_dangerous') as $key => $category)
                <a
                    {{ $route_name != 'home' ? "href=".route('home', ['cat' => $category->id]) : '' }}
                    class="category-filter"
                    data-category-id={{ $category->id }}                  
                >
                    <img src="{{ $category->icon_url }}">
                    <span>{{ $category->name }}</span>
                    {{-- <span>{{ $category->total_content }}</span> --
                    @if ($route_name == 'home')
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, $category_filters) ? 'checked' : '' }}
                        >
                    @endif
                </a>
            @endforeach            
        </div>        
    </div>
    <div>
        <div class="Sidebar__Heading">Traffic violation</div>
        <div class="Sidebar__Categories">
            @foreach (categories_with_videos(3, 'categories_with_videos_violation') as $key => $category)
                <a
                    {{ $route_name != 'home' ? "href=".route('home', ['cat' => $category->id]) : '' }}
                    class="category-filter"
                    data-category-id={{ $category->id }}                  
                >
                    <img src="{{ $category->icon_url }}">
                    <span>{{ $category->name }}</span>
                    {{-- <span>{{ $category->total_content }}</span> --
                    @if ($route_name == 'home')
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, $category_filters) ? 'checked' : '' }}
                        >
                    @endif
                </a>
            @endforeach            
        </div>        
    </div>--}}
</div>