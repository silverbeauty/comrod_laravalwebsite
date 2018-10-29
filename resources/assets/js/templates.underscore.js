_.templateSettings.variable = 'rc';

var template  = _.template(`<div class="appended">
    <div id="thumbnail-<%- rc.id %>" class="Thumbnail hoverable" data-marker-id="<%- rc.id %>">
    <a href="<%- rc.url %>" class="pjax" data-pjax-container=".Video__Profile">
        <div class="Thumbnail__Header">
            <div>
                <span><%- rc.title %></span>
                <i class="flag-icon flag-icon-<%- rc.country_code.toLowerCase() %>"></i>
            </div>
            <div class="backdrop"></div>
        </div>
        <img class="img-responsive lazy" data-original="<%- rc.thumbnail_url %>">
    </a>
    <div class="nav Thumbnail__Footer">
        <ul class="nav navbar-nav">
            <li><i class="fa fa-eye"></i> <%- rc.total_views %></li>
            <li><i class="fa fa-comments"></i> <%- rc.total_comments %></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><i class="fa fa-thumbs-up"></i> <%- rc.total_rating %></li>                    
        </ul>
        <div class="backdrop"></div>
    </div>        
</div></div>`);
var block_template = _.template(`<% var chunked = _.chain(rc.items).groupBy(function (element, index) {
        return Math.floor(index/3);
    }).toArray().value();%>
<div id="carousel-item-<%- rc.id %>" class="Listing gutter-5 sortable-content" style="display:none">
    <% _.each(chunked, function (items, key) { %>
        <div class="row">
            <% _.each(items, function (item, key) { %>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div id="content-thumbnail-<%- key %>" data-id="<%- item.id %>" class="content-thumbnail">
                        <div id="thumbnail-<%- item.id %>" class="Thumbnail hoverable" data-marker-id="<%- item.id %>">
                            <a href="<%- item.url %>" class="pjax" data-pjax-container=".Video__Profile">
                                <div class="Thumbnail__Header">
                                    <div>
                                        <span><%- item.title %></span>
                                        <i class="flag-icon flag-icon-<%- item.country_code.toLowerCase() %>"></i>
                                    </div>
                                    <div class="backdrop"></div>
                                </div>
                                <img class="img-responsive lazy-sporty" data-original="<%- item.thumbnail_url %>">
                            </a>
                            <div class="nav Thumbnail__Footer">
                                <ul class="nav navbar-nav">
                                    <li><i class="fa fa-eye"></i> <%- item.total_views %></li>
                                    <li><i class="fa fa-comments"></i> <%- item.total_comments %></li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <li><i class="fa fa-thumbs-up"></i> <%- item.total_rating %></li>                                    
                                </ul>
                                <div class="backdrop"></div>
                            </div>                                
                        </div>                                            
                    </div>
                </div>
            <% }) %>
        </div>
    <% }) %>
</div>`);
var info_template = _.template(`<div class="appended">
    <div id="thumbnail-<%- rc.id %>" class="Thumbnail hoverable" data-marker-id="<%- rc.id %>">
    <a href="<%- rc.url %>" class="pjax" data-pjax-container=".Video__Profile">
        <div class="Thumbnail__Header">
            <div>
                <span><%- rc.title %></span>
                <i class="flag-icon flag-icon-<%- rc.country_code.toLowerCase() %>"></i>
            </div>
            <div class="backdrop"></div>
        </div>
        <img class="img-responsive lazy" src="<%- rc.thumbnail_url %>">
    </a>
    <div class="nav Thumbnail__Footer">
        <ul class="nav navbar-nav">
            <li><i class="fa fa-eye"></i> <%- rc.total_views %></li>
            <li><i class="fa fa-comments"></i> <%- rc.total_comments %></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><i class="fa fa-thumbs-up"></i> <%- rc.total_rating %></li>            
        </ul>
        <div class="backdrop"></div>
    </div>        
</div></div>`);