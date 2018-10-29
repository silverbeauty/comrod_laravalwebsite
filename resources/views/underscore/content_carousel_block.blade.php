<script type="text/template" id="contentCarouselBlockTemplate">
    <% var chunked = _.chain(rc.items).groupBy(function (element, index) {
            return Math.floor(index/3);
        }).toArray().value();    
    %>
    <div id="carousel-item-<%- rc.id %>" class="Listing gutter-5 sortable-content" style="display:none">
        <% _.each(chunked, function (items, key) { %>
            <div class="row">
                <% _.each(items, function (item, key) { %>
                    <div class="col-md-4">
                        <div id="content-thumbnail-<%- key %>" data-id="<%- item.id %>" class="content-thumbnail">
                            <div class="appended">
                                <a href="<%- item.url %>" id="thumbnail-<%- item.id %>" class="Thumbnail hoverable" data-marker-id="<%- item.id %>">
                                    <div class="Thumbnail__Header">
                                        <div>
                                            <span><%- item.title %></span>
                                            <i class="flag-icon flag-icon-<%- item.country_code.toLowerCase() %>"></i>
                                        </div>
                                        <div class="backdrop"></div>
                                    </div>
                                    <img class="img-responsive lazy-sporty" data-original="<%- item.thumbnail_url %>">
                                    <div class="nav Thumbnail__Footer">
                                        <ul class="nav navbar-nav">
                                            <li><i class="fa fa-eye"></i> <%- item.total_views %></li>
                                            <li><i class="fa fa-comments"></i> <%- item.total_comments %></li>
                                        </ul>
                                        <ul class="nav navbar-nav navbar-right">
                                            <li><i class="fa fa-thumbs-up"></i> <%- item.total_rating %></li>
                                            {{-- <li><i class="fa fa-thumbs-down"></i> <%- item.total_dislikes %></li> --}}
                                        </ul>
                                        <div class="backdrop"></div>
                                    </div>
                                </a>
                            </div>                                            
                        </div>
                    </div>
                <% }) %>
            </div>
        <% }) %>
    </div>
</script>