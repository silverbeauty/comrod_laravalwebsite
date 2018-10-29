<div class="row form-group">
    {{--<div class="col-sm-7 margin-bottom-10">
        <p class="checkbox">
            <label>
                <input type="checkbox" name="hide_watched" {{ $hide_watched && $signed_in ? 'checked' : '' }}>
                {{ trans('home.dont-show-already-watched') }}
            </label>
        </p>
    </div>--}}
    <div class="col-xs-12">
        <div class="padding-right-10">
            <div class="form-group has-feedback">
                <input type="text" class="form-control input-sm" placeholder="{{ trans('app.search') }}" id="search-input">
                <span class="fa fa-search form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
    </div>
</div>
<h2 class="Content__Heading text-left">
    <span>

        <span class="dropdown no-padding">
            <a data-toggle="dropdown">
                <i class="fa fa-chevron-circle-down text-primary"></i>
            </a>
            {{ trans('home.show-from') }}:
            <a
                data-toggle="dropdown"
                class="text-default"
            >
                <b
                    id="show-from-filter-label"
                    data-key="{{ $show_from_filter_key }}"
                >{{ $filter_menu['filters'][$show_from_filter_key]['alt_label'] }}</b>
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
        </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="dropdown no-padding">
            <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down text-primary"></i></a> 
            {{ trans('home.sort-by') }}:
            <a
                data-toggle="dropdown"
                class="text-default"
            >
                <b
                    id="sorting-label"
                    data-key="{{ $sort_key }}"
                >{{ $filter_menu['sorting'][$sort_key]['label'] }}</b></a>
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
        </span>
    </span>                        
</h2>