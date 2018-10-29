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

    var template  = _.template(
        `<div class="appended">
            <div id="thumbnail-<%- rc.id %>" class="Thumbnail hoverable <%- js_vars.settings.watched.indexOf(rc.id) != -1 ? 'watched' : '' %>" data-marker-id="<%- rc.id %>">
                <a
                    href="{{ url() }}/<%- rc.type + '/' + slugify(rc.title) + '-' + rc.id %>"
                    class="pjax inline-block gutter-5"
                    data-pjax-container="#pjaxModalContentContainer"
                    data-pjax-fragment="#content-fragment"
                    data-toggle="modal"
                    data-target="#contentModal"
                >
                    <div class="position-relative" style="min-height:200px;">
                        <div class="Thumbnail__Header">
                            <div>
                                <i class="flag-icon flag-icon-<%- rc.cc.toLowerCase() %>"></i>
                            </div>                            
                        </div>
                        <img
                            class="img-responsive lazy main <% if (rc.refresh) { %> auto-refresh <% } %>"
                            <% if (rc.refresh) { %>
                                data-refresh-seconds="<%- rc.refresh_seconds %>"                    
                            <% } %>
                            data-original="<%- rc.tu %>"
                        >
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
                    </div>
                    <div class="row footer panel-body">
                        <div class="col-xs-8">
                            <h3 class="text-primary text-left h5 no-margin margin-bottom-10"><b class="ellipsis"><%- rc.title %></b></h3>
                            <table>
                                <tr>
                                    <td class="padding-right-5"><i class="fa fa-tag text-muted fa-lg fa-rotate-90"></i></td>
                                    <% _.each(rc.cat, function (item, key) { %>
                                        <td class="padding-right-5"><img src="/images/categories/icon_<%- item %>.png" class="category-icon"></td>
                                    <% }) %>
                                </tr>
                            </table>
                        </div>
                        <% if (rc.dur) { %>
                            <div class="col-xs-4 text-right">
                                <span class="text-muted">{{ trans('app.duration') }}: <%- rc.dur %></span>
                            </div>
                        <% } %>
                    </div>
                </a>                                                
            </div>
        </div>`
    );        
    var block_template_v2 = _.template(`
    <% _.each(rc.items, function (item, key) { %>
    <% if ($('#content-thumbnail-' + item.id).length == 0) { %>
        <div id="content-thumbnail-<%- item.id %>" data-id="<%- item.id %>" class="content-thumbnail">
            <div id="thumbnail-<%- item.id %>" class="Thumbnail hoverable <%- js_vars.settings.watched.indexOf(item.id) != -1 ? 'watched' : '' %>" data-marker-id="<%- item.id %>">
                <a
                    href="{{ url() }}/<%- item.type + '/' + slugify(item.title) + '-' + item.id %>"
                    class="pjax inline-block gutter-5"
                    data-pjax-container="#pjaxModalContentContainer"
                    data-pjax-fragment="#content-fragment"
                    data-toggle="modal"
                    data-target="#contentModal"
                >
                    <div class="position-relative" style="min-height:200px;">
                        <div class="Thumbnail__Header">
                            <div>
                                <i class="flag-icon flag-icon-<%- item.cc.toLowerCase() %>"></i>
                            </div>                            
                        </div>
                        <img
                            class="img-responsive lazy main <% if (item.refresh) { %> auto-refresh <% } %>"
                            <% if (item.refresh) { %>
                                data-refresh-seconds="<%- item.refresh_seconds %>"                    
                            <% } %>
                            data-original="<%- item.tu %>"
                        >
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
                    <div class="row footer panel-body">
                        <div class="col-xs-8">
                            <h3 class="text-primary text-left h5 no-margin margin-bottom-10"><b class="ellipsis"><%- item.title %></b></h3>
                            <table>
                                <tr>
                                    <td class="padding-right-5"><i class="fa fa-tag text-muted fa-lg fa-rotate-90"></i></td>
                                    <% _.each(item.cat, function (item, key) { %>
                                        <td class="padding-right-5"><img src="/images/categories/icon_<%- item %>.png" class="category-icon"></td>
                                    <% }) %>
                                </tr>
                            </table>
                        </div>
                        <% if (item.dur) { %>
                            <div class="col-xs-4 text-right">
                                <span class="text-muted">{{ trans('app.duration') }}: <%- item.dur %></span>
                            </div>
                        <% } %>
                    </div>
                </a>                                                
            </div>                                            
        </div>
        <% } %>                     
    <% }) %>`);
    
</script>
@include('modals.content')
@include('underscore.comment')
@include('modals.report_content')
