@extends('layouts.master')

@section('title', trans('pages.dashcams_title'))
@section('description', substr(strip_tags_content(trans('pages.dashcams_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">                        
            <link href="../css/dashcams.css" rel="stylesheet">                
            <div class="dashcam-compare text-left">
            
            {!!trans('pages.viofo-wr1')!!}

            <hr>
            <h5>BUY NOW</h5>
            <div class="row">
                <div class="col-md-12 tac">
                <?php 
                    $obj = json_decode(file_get_contents('./content/prices-heb.json'));
                    foreach($obj->viofo_wr1 as $key => $value)
                    {
                        echo '<a href="/go/' . $value->link . '" target="_blank"><div class="buy-now-item"><img src="../../images/' . $key . '-icon.png"/>';
                        echo '<p>' . $value->price->price . '</p></div></a>';
                        echo "</tr>";
                    }   
                ?>
                </div>
            </div>
</div> 
            

</div>
    
@stop