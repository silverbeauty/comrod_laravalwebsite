<div class="col-md-6 Content">
    @if (is_rtl())
        @include('partials.content-heading-right')
    @else
        <div class="row">
            <div class="col-sm-7">
                <p class="checkbox">
                    <label>
                        <input type="checkbox" name="hide_watched" {{ $hide_watched && $signed_in ? 'checked' : '' }}>
                        {{ trans('home.dont-show-already-watched') }}
                    </label>
                </p>
            </div>
            <div class="col-sm-5">
                <div class="form-group has-feedback">
                                    <input type="text" class="form-control" placeholder="Address">
                                    <span class="fa fa-search form-control-feedback" aria-hidden="true"></span>
                                </div>
            </div>
        </div>
        <h2 class="Content__Heading">
            <span>
                <span class="dropdown no-padding">
                    {{ trans('home.sort-by') }}: 
                    <a
                        data-toggle="dropdown"
                        class="text-default"
                    >
                        <b
                            id="sorting-label"
                            data-key="{{ $sort_key }}"
                        >{{ $filter_menu['sorting'][$sort_key]['label'] }}</b></a> 
                        <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down text-primary"></i></a>
                    <ul class="dropdown-menu pull-right">
                        @foreach ($filter_menu['sorting'] as $key => $sort)                                        
                            <li class="{{ $key == $sort_key ? 'hidden' : '' }}">
                                <a
                                    class="content-sorting"
                                    data-sorting-type="{{ $sort['alt_key'] }}"
                                    data-target-label="#sorting-label"
                                    data-label="{{ $sort['label'] }}"
                                    data-key="{{ $key }}"
                                >{{ $sort['label'] }}</a>
                            </li>
                        @endforeach                             
                    </ul>
                </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="dropdown no-padding">
                    {{ trans('home.show-from') }}: 
                    <a
                        data-toggle="dropdown"
                        class="text-default"
                    >
                        <b
                            id="show-from-filter-label"
                            data-key="{{ $show_from_filter_key }}"
                        >{{ $filter_menu['filters'][$show_from_filter_key]['alt_label'] }}</b></a> 
                        <a data-toggle="dropdown">
                            <i class="fa fa-chevron-circle-down text-primary"></i>
                        </a>
                    <ul class="dropdown-menu pull-right">
                        @foreach ($filter_menu['filters'] as $key => $filter)                                        
                            <li class="{{ $key == $show_from_filter_key ? 'hidden' : '' }}">
                                <a
                                    href="{{ $filter['url'] }}"
                                    class="show-from-filter"
                                    data-target-label="#show-from-filter-label"
                                    data-label="{{ $filter['alt_label'] }}"
                                    data-filter-type="{{ $key }}"
                                    data-key="{{ $key }}"
                                >{{ $filter['label'] }}</a>
                            </li>                                        
                        @endforeach                             
                    </ul>
                </span>
            </span>                        
        </h2>
    @endif
    @include('partials.carousel', ['contents' => $main_contents])
</div>