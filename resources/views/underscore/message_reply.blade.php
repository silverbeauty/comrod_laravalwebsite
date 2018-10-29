<script type="text/template" id="messageReplyTemplate">
    <li class="list-group-item">
        <div class="media">
            <div class="media-left">
                <a href="<%- rc.owner_url %>">
                    <img class="media-object" src="<%- rc.owner_avatar %>" alt="<%- rc.owner_username %>" width="50" height="50">
                </a>
            </div>
            <div class="media-body">
                <h5 class="media-heading"><a href="<%- rc.owner_url %>"><b><%- rc.owner_username %></b></a></h5>
                <p class="no-margin">
                    <%= rc.body %><br/>
                    <span class="text-muted fs12"><i><%- rc.created_at %></i></span>
                </p>
            </div>
        </div>
    </li>
</script>