@extends('site.master')
@section('content')
<div class="about-section paddingTB60 gray-bg "style='margin-top: 50px;'>
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-6 trans">
                <div class="about-title clearfix">
                    <h1>عنا </h1>
                    <h3>{{$site_settings->about_title}}</h3>
                    <p class="about-paddingB">{{$site_settings->about_des}}</p>

                </div>
            </div>

        </div>
    </div>
</div>

@stop
