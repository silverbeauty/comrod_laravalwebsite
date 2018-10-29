<div class="modal fade rtl" id="homePageCategoriesModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('video.select_categories') }}</h4>        
            </div>            
            <div class="modal-body">                    
                <div class="row">
                    @if ($content_type == 'video' || $content_type == 'any')
                        <div class="col-md-3">
                            <h5 class="sub-heading no-margin-top"><b>{{ trans('video.category') }}:</b></h4>
                            @foreach (categories(['type' => 1]) as $key => $category)                
                                <div class="checkbox">
                                    <label
                                        class="category-filter {{ in_array($category->id, $category_filters) ? 'active' : '' }}"
                                        data-category-id={{ $category->id }}
                                    >
                                        <img
                                            src="{{ $category->icon_url }}"
                                        >                                                                       
                                        {{ $category->name }}
                                        <input
                                            type="checkbox"
                                            name="categories[]"
                                            value="{{ $category->id }}"
                                            class="hidden"
                                            {{ in_array($category->id, $category_filters) ? 'checked' : '' }}
                                        >
                                    </label>
                                </div>                
                            @endforeach
                        </div>
                        <div class="col-md-5">
                            <h5 class="sub-heading no-margin-top"><b>{{ trans('video.dangerous-behavior') }}:</b></h5>
                            <?php
                                $dangerous = categories(['type' => 2]);
                            ?>
                            @foreach ($dangerous as $key => $category)
                                <div class="checkbox">
                                    <label
                                        class="category-filter {{ in_array($category->id, $category_filters) ? 'active' : '' }}"
                                        data-category-id={{ $category->id }}
                                    >
                                        <img src="{{ $category->icon_url }}">                                    
                                        {{ $category->name }}
                                        <input
                                            type="checkbox"
                                            name="categories[]"
                                            value="{{ $category->id }}"
                                            class="hidden"
                                            {{ in_array($category->id, $category_filters) ? 'checked' : '' }}
                                        >
                                    </label>
                                </div>                            
                            @endforeach
                        </div>
                        <div class="col-md-4">
                            <h5 class="sub-heading no-margin-top"><b>{{ trans('video.traffic-violations') }}:</b></h5>
                            <?php
                                $traffic_violations = categories(['type' => 3]);
                            ?>
                            @foreach ($traffic_violations as $key => $category)
                                <div class="checkbox">
                                    <label
                                        class="category-filter {{ in_array($category->id, $category_filters) ? 'active' : '' }}"
                                        data-category-id={{ $category->id }}
                                    >
                                        <img src="{{ $category->icon_url }}">                                    
                                        {{ $category->name }}
                                        <input
                                            type="checkbox"
                                            name="categories[]"
                                            value="{{ $category->id }}"
                                            class="hidden"
                                            {{ in_array($category->id, $category_filters) ? 'checked' : '' }}
                                        >
                                    </label>
                                </div>                            
                            @endforeach
                        </div>
                    @else
                        <div class="col-md-12">
                            <h5 class="sub-heading no-margin-top"><b>{{ trans('video.category') }}:</b></h4>
                            @foreach (categories(['type' => 4]) as $key => $category)                
                                <div class="checkbox">
                                    <label
                                        class="category-filter {{ in_array($category->id, $category_filters) ? 'active' : '' }}"
                                        data-category-id={{ $category->id }}
                                    >
                                        <img
                                            src="{{ $category->icon_url }}"
                                        >                                                                       
                                        {{ $category->name }}
                                        <input
                                            type="checkbox"
                                            name="categories[]"
                                            value="{{ $category->id }}"
                                            class="hidden"
                                            {{ in_array($category->id, $category_filters) ? 'checked' : '' }}
                                        >
                                    </label>
                                </div>                
                            @endforeach
                        </div>
                    @endif
                </div>                   
            </div>
            <div class="modal-footer">
                <a
                    class="btn btn-danger show-all-categories-on-map"
                >{{ trans('video.clear_selections') }}</a>
                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                    data-loading-text="Cancel"
                >{{ trans('app.close') }}</button>                
            </div>                       
        </div>
    </div>
</div>