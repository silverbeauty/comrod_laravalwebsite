<div class="modal fade" id="editContentExactLocationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pinpoint Location on Map</h4>        
            </div>            
            <div class="modal-body no-padding">
                <input id="pac-input" class="form-control" type="text" placeholder="Search Google Maps">
                <div id="map" style="height: 400px;"></div>
            </div>
            <div class="modal-footer clearfix">
                <span class="pull-left btn btn-link text-default">Drag marker to change location.</span>
                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"                    
                >Cancel</button>
                <button
                    type="button"
                    class="btn btn-primary"
                    data-dismiss="modal"                       
                >Save</button>
            </div>                       
        </div>
    </div>
</div>