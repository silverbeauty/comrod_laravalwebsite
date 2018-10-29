@extends('layouts.master')

@section('title', trans('pages.dashcams_title'))
@section('description', substr(strip_tags_content(trans('pages.dashcams_body')), 0, 150) . '...')

<meta property="og:title" content="סקירות מצלמות רכב - קומרודס"/>
<meta property="og:image" content="http://comroads.com/images/dashcams/yi_ultra_dashboard.jpg"/>
<meta property="og:description" content="סקירות מצלמות רכב כולל סרטונים מקוריים שלא עברו עיבוד. המצלמות הנבדקות אף תומכות באפליקציה של קומרודס"/>


@section('content')
    {!!trans('pages.dashcams_body')!!}    
@stop