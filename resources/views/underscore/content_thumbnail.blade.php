<script type="text/template" id="contentThumbnailTemplate">
    <div class="appended">
        <a href="<%- rc.url %>" id="thumbnail-<%- rc.id %>" class="Thumbnail hoverable" data-marker-id="<%- rc.id %>">
            <div class="Thumbnail__Header">
                <div>
                    <span><%- rc.title %></span>
                    <i class="flag-icon flag-icon-<%- rc.country_code.toLowerCase() %>"></i>
                </div>
                <div class="backdrop"></div>
            </div>
            <img class="img-responsive lazy" data-original="<%- rc.thumbnail_url %>">
            <div class="nav Thumbnail__Footer">
                <ul class="nav navbar-nav">
                    <li><i class="fa fa-eye"></i> <%- rc.total_views %></li>
                    <li><i class="fa fa-comments"></i> <%- rc.total_comments %></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><i class="fa fa-thumbs-up"></i> <%- rc.total_rating %></li>
                    {{-- <li><i class="fa fa-thumbs-down"></i> <%- rc.total_dislikes %></li> --}}
                </ul>
                <div class="backdrop"></div>
            </div>
        </a>
    </div>   
</script>