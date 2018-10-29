@extends('layouts.master')

@section('title', trans('pages.dashcams_title'))
@section('description', substr(strip_tags_content(trans('pages.dashcams_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">                        
            <link href="../css/dashcams.css" rel="stylesheet"> 
            <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="../../css/slick.css">
            <link rel="stylesheet" type="text/css" href="../../css/slick-theme.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
            <link rel="stylesheet" href="../../css/style.css">               
            <div class="dashcam-compare text-left">
            
            {!!trans('pages.yi-dashcam')!!}

				<hr>
				<h5>BUY NOW</h5>
				<div class="row">
					<div class="col-md-12 tac">
                    <?php 
                        $obj = json_decode(file_get_contents('./content/prices-heb.json'));
                        foreach($obj->xiaomi_yi as $key => $value)
                        {
                            echo '<a href="http://comroads.com/go/' . $value->link . '" target="_blank"><div class="buy-now-item"><img src="../../images/' . $key . '-icon.png"/>';
                            echo '<p>' . $value->price->price . '</p></div></a>';
                        }   
                    ?>
                    </div>
				</div>
			</div>
		</div>
	</main>
    <!-- Main part end -->
    </div>
            
            
            
    </div>
</div> 
            

</div>
    
@stop