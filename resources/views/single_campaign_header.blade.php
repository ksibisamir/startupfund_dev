<div class="single-campaign-header" style="background-image: url('{{$campaign->feature_img_url(true)}}')">
    {{--<img src="{{$campaign->feature_img_url(true)}}" class="img-responsive"/>--}}
    <div class="header-content">
        <div class="container">
            <h1 class="single-campaign-title">{{$campaign->title}}</h1>
            <h4 class="single-campaign-short-description">
                {{$campaign->short_description}}
            </h4>
        </div>
    </div>
</div>