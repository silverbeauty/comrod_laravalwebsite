<script type="text/javascript">    
    _.templateSettings.variable = 'rc';

    function slugify(text)
    {
      return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
    }

    var template  = _.template(`<div class="appended">
        <div id="thumbnail-<%- rc.id %>" class="Thumbnail hoverable <%- js_vars.settings.watched.indexOf(rc.id) != -1 ? 'watched' : '' %>" data-marker-id="<%- rc.id %>">
        <a
            href="{{ url() }}/<%- rc.type + '/' + slugify(rc.title) + '-' + rc.id %>"
            class="pjax"
            data-pjax-container="#pjaxModalContentContainer"
            data-pjax-fragment="#content-fragment"
            data-toggle="modal"
            data-target="#contentModal"
        >
            <div class="Thumbnail__Header">
                <div>
                    <span><%- rc.title %></span>
                    <i class="flag-icon flag-icon-<%- rc.cc.toLowerCase() %>"></i>
                </div>
                <div class="backdrop"></div>
            </div>
            <img
                class="img-responsive lazy <% if (rc.refresh) { %> auto-refresh <% } %>"
                <% if (rc.refresh) { %>
                    data-refresh-seconds="<%- rc.refresh_seconds %>"                    
                <% } %>
                data-original="<%- rc.tu %>"
            >
        </a>
        <% if (rc.mv) { %>
        <div class="nav Thumbnail__Footer">
            <% if (js_vars.settings.watched.indexOf(rc.id) != -1) { %>
                <span class="watched-label"><%- js_vars.settings.watchedLabel %></span>
            <% } %>
            <ul class="nav navbar-nav">
                <li><i class="fa fa-eye"></i> <%- rc.mv %></li>
                <li><i class="fa fa-comments"></i> <%- rc.md %></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">                
                <li><i class="fa fa-thumbs-up"></i> <%- rc.hr %></li>                    
            </ul>
            <div class="backdrop"></div>
        </div>
        <% } %>        
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
                            <div id="thumbnail-<%- item.id %>" class="Thumbnail hoverable <%- js_vars.settings.watched.indexOf(item.id) != -1 ? 'watched' : '' %>" data-marker-id="<%- item.id %>">
                                <a
                                    href="{{ url() }}/<%- item.type + '/' + slugify(item.title) + '-' + item.id %>"
                                    class="pjax"
                                    data-pjax-container="#pjaxModalContentContainer"
                                    data-pjax-fragment="#content-fragment"
                                    data-toggle="modal"
                                    data-target="#contentModal"
                                >
                                    <div class="Thumbnail__Header">
                                        <div>
                                            <span><%- item.title %></span>
                                            <i class="flag-icon flag-icon-<%- item.cc.toLowerCase() %>"></i>
                                        </div>
                                        <div class="backdrop"></div>
                                    </div>
                                    <img
                                        class="img-responsive lazy <% if (item.refresh) { %> auto-refresh <% } %>"
                                        <% if (item.refresh) { %>
                                            data-refresh-seconds="<%- item.refresh_seconds %>"
                                        <% } %>
                                        data-original="<%- item.tu %>"
                                    >
                                </a>
                                <% if (item.mv) { %>
                                <div class="nav Thumbnail__Footer">
                                    <% if (js_vars.settings.watched.indexOf(item.id) != -1) { %>
                                        <span class="watched-label"><%- js_vars.settings.watchedLabel %></span>
                                    <% } %>
                                    <ul class="nav navbar-nav">
                                        <li><i class="fa fa-eye"></i> <%- item.mv %></li>
                                        <li><i class="fa fa-comments"></i> <%- item.md %></li>
                                    </ul>
                                    <ul class="nav navbar-nav navbar-right">                                        
                                        <li><i class="fa fa-thumbs-up"></i> <%- item.hr %></li>                                    
                                    </ul>
                                    <div class="backdrop"></div>
                                </div>
                                <% } %>                               
                            </div>                                            
                        </div>
                    </div>
                <% }) %>
            </div>
        <% }) %>
    </div>`);    
    var block_template_v2 = _.template(`<% var chunked = _.chain(rc.items).groupBy(function (element, index) {
            return Math.floor(index/2);
        }).toArray().value();%>        
        
        <% _.each(rc.items, function (item, key) { %>                    
            <div class="col-md-6 col-sm-6 col-xs-12 thumbnail-wrapper margin-bottom-10 hidden">
                <div id="content-thumbnail-<%- key %>" data-id="<%- item.id %>" class="content-thumbnail">
                    <div id="thumbnail-<%- item.id %>" class="Thumbnail hoverable <%- js_vars.settings.watched.indexOf(item.id) != -1 ? 'watched' : '' %>" data-marker-id="<%- item.id %>">
                        <a
                            href="{{ url() }}/<%- item.type + '/' + slugify(item.title) + '-' + item.id %>"
                            class="pjax"
                            data-pjax-container="#pjaxModalContentContainer"
                            data-pjax-fragment="#content-fragment"
                            data-toggle="modal"
                            data-target="#contentModal"
                        >
                            <div class="Thumbnail__Header">
                                <div>
                                    <span><%- item.title %></span>
                                    <i class="flag-icon flag-icon-<%- item.cc.toLowerCase() %>"></i>
                                </div>
                                <div class="backdrop"></div>
                            </div>
                            <img
                                class="img-responsive lazy <% if (item.refresh) { %> auto-refresh <% } %>"
                                <% if (item.refresh) { %>
                                    data-refresh-seconds="<%- item.refresh_seconds %>"
                                <% } %>
                                data-original="<%- item.tu %>"
                            >
                        </a>
                        <% if (item.mv) { %>
                            <div class="nav Thumbnail__Footer">
                                <% if (js_vars.settings.watched.indexOf(item.id) != -1) { %>
                                    <span class="watched-label"><%- js_vars.settings.watchedLabel %></span>
                                <% } %>
                                <ul class="nav navbar-nav">
                                    <li><i class="fa fa-eye"></i> <%- item.mv %></li>
                                    <li><i class="fa fa-comments"></i> <%- item.md %></li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">                                            
                                    <li><i class="fa fa-thumbs-up"></i> <%- item.hr %></li>                                    
                                </ul>
                                <div class="backdrop"></div>
                            </div>
                        <% } %>                              
                    </div>                                            
                </div>
            </div>
        <% }) %>`);

    var info_template = _.template(`<div class="appended">
        <div id="thumbnail-<%- rc.id %>" class="Thumbnail hoverable <%- js_vars.settings.watched.indexOf(rc.id) != -1 ? 'watched' : '' %>" data-marker-id="<%- rc.id %>">
        <a
            href="{{ url() }}/<%- rc.type + '/' + slugify(rc.title) + '-' + rc.id %>"
            class="pjax"
            data-pjax-container="#pjaxModalContentContainer"
            data-pjax-fragment="#content-fragment"
            data-toggle="modal"
            data-target="#contentModal"
        >
            <div class="Thumbnail__Header">
                <div>
                    <span><%- rc.title %></span>
                    <i class="flag-icon flag-icon-<%- rc.cc.toLowerCase() %>"></i>
                </div>
                <div class="backdrop"></div>
            </div>
            <img
                class="img-responsive <% if (rc.refresh) { %> auto-refresh <% } %>"
                <% if (rc.refresh) { %>
                    data-refresh-seconds="<%- rc.refresh_seconds %>"
                <% } %>
                src="<%- rc.tu %>"
            >
        </a>
        <% if (rc.mv) { %>
        <div class="nav Thumbnail__Footer">
            <% if (js_vars.settings.watched.indexOf(rc.id) != -1) { %>
                <span class="watched-label"><%- js_vars.settings.watchedLabel %></span>
            <% } %>
            <ul class="nav navbar-nav">
                <li><i class="fa fa-eye"></i> <%- rc.mv %></li>
                <li><i class="fa fa-comments"></i> <%- rc.md %></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">                
                <li><i class="fa fa-thumbs-up"></i> <%- rc.hr %></li>            
            </ul>
            <div class="backdrop"></div>
        </div>
        <% } %>       
    </div></div>`);
</script>
@include('modals.content')
@include('underscore.comment')
@include('modals.report_content')
