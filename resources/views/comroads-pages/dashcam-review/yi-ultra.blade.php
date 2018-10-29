@extends('layouts.master')

@section('title', trans('pages.dashcams_title'))
@section('description', substr(strip_tags_content(trans('pages.dashcams_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">                        
            <link href="../css/dashcams.css" rel="stylesheet">                
            <div class="dashcam-compare text-left">
            
            {!!trans('pages.yi-ultra')!!}

       <div class="content-title">לקנייה</div>
<div class="pricestable">
    <table class="prices">
        <tbody>
        <?php 
            $obj = json_decode(file_get_contents('./content/prices-heb.json'));
            foreach($obj->yi_ultra as $key => $value)
            {
                echo "<tr class='pricerow'>";
                echo '<td class="shoplogo"><a href="/go/' . $value->link . '" target="_blank"><img src="../images/' . $key . '-icon.png"/></a></td>';
                echo '<td class="pricetext"><a href="/go/' . $value->link . '" target="_blank"><button class="pricebutton">' . $value->price->price . '</button></a></td>';
                echo "</tr>";
            }   
         
        ?>
        </tbody>
    </table>
    
    </div>
            
            
            
    </div>
</div> 
            

</div>
    
@stop