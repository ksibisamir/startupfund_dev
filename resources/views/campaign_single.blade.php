@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection
@section('body-class', 'campaign-single')
@section('meta-data')
    <meta name="description"
          content="{{$campaign->short_description ? $campaign->short_description : $campaign->description}}"/>

    <!-- Twitter Card data -->
    <meta name="twitter:card"
          content="{{$campaign->short_description ? $campaign->short_description : $campaign->description}}">
    {{--<meta name="twitter:site" content="@publisher_handle">--}}
    <meta name="twitter:title" content="@if( ! empty($title)) {{ $title }} @endif">
    <meta name="twitter:description"
          content="{{$campaign->short_description ? $campaign->short_description : $campaign->description}}">
    {{--<meta name="twitter:creator" content="@author_handle" />--}}
    <!-- Twitter Summary card images must be at least 120x120px -->
    <meta name="twitter:image" content="{{$campaign->feature_img_url(true)}}">

    <!-- Open Graph data -->
    <meta property="og:title" content="@if( ! empty($title)) {{ $title }} @endif"/>
    <meta property="og:url" content="{{route('campaign_single', [$campaign->id, $campaign->slug])}}"/>
    <meta property="og:image" content="{{$campaign->feature_img_url(true)}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:description"
          content="{{$campaign->short_description ? $campaign->short_description : $campaign->description}}"/>
@endsection

@section('content')

    <section class="campaign-details-wrap">
        @include('single_campaign_header')
        <div class="container">
            <!-- Nav tabs -->

            @php
                $updates_count = $campaign->updates->count();
                $faqs_count = $campaign->faqs->count();
            @endphp

            <div class="row">
                <div class="col-md-8">
                    @include('admin.flash_msg')
                </div>
            </div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="col-sm-2 col-md-offset-1 active">
                    <a href="#home" aria-controls="home" role="tab" data-toggle="tab">@lang('app.description')</a>
                </li>
                <li role="presentation" class="col-sm-2 col-md-offset-1">
                    <a href="#teams" aria-controls="teams" class="pointer" role="tab"
                       data-toggle="tab">@lang('app.teams')</a>
                </li>
                <li role="presentation" class="col-sm-2">
                    <a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">@lang('app.comments')</a>
                </li>
                <li role="presentation" class="col-sm-2">
                    <a href="#updates" aria-controls="updates" role="tab"
                       data-toggle="tab">@lang('app.updates')  @if($updates_count > 0) ({{$updates_count}}) @endif</a>
                </li>
                <li role="presentation" class="col-sm-2">
                    <a href="#faqs" aria-controls="faqs" role="tab"
                       data-toggle="tab">@lang('app.faqs')@if($faqs_count > 0) ({{$faqs_count}}) @endif</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="row">
                        <div class="col-md-4 left-colone">
                            @include('campaign_single_sidebar')
                        </div>
                        <div class="col-md-8 contents">
                            {!! safe_output($campaign->description) !!}
                            <div class="single-campaign-embeded">
                                @if( ! empty($campaign->video))
                                    <?php
                                    $video_url = $campaign->video;
                                    if (strpos($video_url, 'youtube') > 0) {
                                        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
                                        if (!empty($matches[1])) {
                                            echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe></div>';
                                        }

                                    } elseif (strpos($video_url, 'vimeo') > 0) {
                                        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $video_url, $regs)) {
                                            if (!empty($regs[3])) {
                                                echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/' . $regs[3] . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
                                            }
                                        }
                                    }
                                    ?>
                                @else
                                    <p class="campaign-feature-img">
                                        <img src="{{$campaign->feature_img_url(true)}}" class="img-responsive"/>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="teams">
                    <div class="row">
                        <div class="col-md-4 left-colone">
                            @include('campaign_single_sidebar')
                        </div>
                        <div class="grid-container">
                            @foreach($teams as $team)
                                <div class="team-item">
                                    <div class="name">{{$team->name}}</div>
                                    <div class="function">{{$team->fonction}}</div>
                                    <div class="social_network_links">
                                        @php
                                            $socialNetworks = json_decode($team->social_network_link);
                                            $socialIcons = ['linkedin','facebook','twitter']
                                        @endphp
                                        @foreach($socialIcons as $index=>$socialNetwork)

                                            @php
                                                if(array_key_exists($index,$socialNetworks) && !empty($socialNetworks[$index])){
                                                    $link = (empty($socialNetworks[$index])) ? '#' : $socialNetworks[$index];
                                                    $target = (empty($socialNetworks[$index])) ? '_self' : '_blank';
                                            @endphp
                                            <a href="{{$link}}" target="{{$target}}"
                                               class="btn-social btn-{{$socialIcons[$index]}}"><i
                                                        class="fa fa-{{$socialIcons[$index]}}"></i></a>
                                            @php
                                                }else{
                                            @endphp
                                            <i class="btn-social btn-{{$socialIcons[$index]}} fa fa-{{$socialIcons[$index]}}"></i>
                                            @php
                                                }
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="comments">
                    <div class="row">
                        <div class="col-md-4 left-colone">
                            @include('campaign_single_sidebar')
                        </div>
                        <div class="col-md-8 contents">
                            <div class="title">52 @lang('app.comments')</div>
                            {{Form::open([ 'route' => 'add_comment', 'class' => 'form-inline', 'id' => 'sendComment'])}}
                            <input type="hidden" name="campaign" value="{{$campaign->id}}">
                            <div class="row">
                                <div class="col-xs-3 col-sm-2" align="center"><span class="avatar-comment"><img
                                                src="{{ asset('assets/images/avatar.png') }}" alt="" width="60"
                                                height="60"></span></div>
                                <div class="col-xs-9 col-sm-8 edit">
                                    <textarea name="comment" class="form-control " id="comment"></textarea>
                                    {!! $errors->has('comment')? '<p class="has-error help-block">'.$errors->first('comment').'</p>':'' !!}
                                </div>
                            </div>
                            {{Form::close()}}

                            @if($campaign->comments->count() > 0)
                                @foreach($campaign->comments->sortBy('') as $comment)
                                    <div id="comment-{{ $comment->id }}" class="row">
                                        <div class="col-xs-3 col-sm-2" align="center"><span class="avatar-comment"><img
                                                        src="{{ asset('assets/images/avatar.png') }}" alt="" width="50"
                                                        height="50"></span></div>
                                        <div class="col-xs-9 col-sm-8 comment-content">
                                            <div class="sender">{{ $comment->user->name }}
                                                <br><span>{{ $comment->created_at->format('j F') }}</span></div>
                                            <p>
                                                {{ $comment->comment }}
                                            </p>
                                            @php
                                                if (Auth::user()){
                                                $userLike = $comment->liked->where ('user_id',Auth::user()->id)->count();
                                                } else {
                                                $userLike= 0;
                                                }
                                            @endphp
                                            <div class="likes @if($userLike > 0) liked   @endif"><i
                                                        class="fa fa-heart"></i> <span
                                                        class="nbre">{{ $comment->liked->count() }}</span></div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-data">
                                    <i class="fa fa-smile-o"></i>
                                    <h1>@lang('app.no_comment')</h1>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="updates">
                    <div class="row">
                        <div class="col-md-4 left-colone">
                            @include('campaign_single_sidebar')
                        </div>
                        <div class="col-md-8 contents">
                            @if($campaign->updates->count() > 0)
                                @foreach($campaign->updates as $update)
                                    <div class="post">
                                        <div class="post-header">
                                            <h2>{{$update->title}}</h2>
                                            <div class="info"> {{$update->created_at->format('j F Y')}} <i
                                                        class="fa fa-dot-circle-o"></i> Public <i
                                                        class="fa fa-circle "></i> Posteé par Jan M. le mer. 14 août
                                                2019
                                            </div>
                                        </div>
                                        <div class="post-content">
                                            {!! safe_output(nl2br($update->description)) !!}
                                        </div>
                                        <div class="post-footer">
                                            <i class="fa fa-comments"></i> <span>@lang('app.comment ')</span> <i
                                                    class="fa fa-heart"></i> <span>@lang('app.like') (3)</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-data">
                                    <i class="fa fa-bell-o"></i>
                                    <h1>@lang('app.no_update')</h1>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="faqs">
                    <div class="contents">
                        <h1 class="title">FAQ'S</h1>
                        <div class="panel-group" id="faqs-content">
                            @if($campaign->faqs->count() > 0)
                                @foreach($campaign->faqs as $faq)

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#faqs-content"
                                                   href="#collapse{{$faq->id}}">
                                                    {{$faq->title}} </a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$faq->id}}"
                                             class="panel-collapse collapse  @if ($loop->first) in @endif">
                                            <div class="panel-body">{!! safe_output(nl2br($faq->description)) !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-data">
                                    <i class="fa fa-bell-o"></i>
                                    <h1>@lang('app.no_faq')</h1>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tabs -->
        </div>
    </section>
@endsection

@section('page-js')
    @if($enable_discuss)
        <script id="dsq-count-scr" src="//{{get_option('disqus_shortname')}}.disqus.com/count.js" async></script>
    @endif

    <script src="{{asset('assets/plugins/SocialShare/SocialShare.min.js')}}"></script>
    <script>
        $('.share').ShareLink({
            title: '{{$campaign->title}}', // title for share message
            text: '{{$campaign->short_description ? $campaign->short_description : $campaign->description}}', // text for share message
            width: 640, // optional popup initial width
            height: 480 // optional popup initial height
        })
    </script>

    <script>
        $(function () {
            $(document).on('click', '.donate-amount-placeholder ul li', function (e) {
                $(this).closest('form').find($('[name="amount"]')).val($(this).data('value'));
            });

            $('#campaign_url_copy_btn').click(function () {
                copyToClipboard('#campaign_url_input');
            });

            $('#sendComment textarea').keypress(function (e) {
                if (e.which == 13) {
                    $('#comments form').submit();
                    return false;    //<---- Add this line
                }
            });
            $('#comments .comment-content .likes .fa').on("click", function () {
                var comment_id = $(this).closest(".row").attr("id").split("-")[1];
                const _this = $(this);
                const url = '{{ route('like_comment') }}' + '/' + comment_id
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (data) {
                        if (data.success) {
                            if (data.result == 1) {
                                _this.closest('.likes').addClass('liked')
                            } else {
                                _this.closest('.likes').removeClass('liked')
                            }
                            _this.closest('.likes').find('.nbre').html(data.nbre)
                        }
                    }
                });
            })
            $('#amount').on('input', function () {
                if($(this).val() < 100){
                    $(".subscription-amount-error").html("Le montant doit etre supérieur ou égale à 100 DT")
                }
                else if (!Number.isInteger($(this).val() / 100)) {
                    $(".subscription-amount-error").html("Votre montant doit être multiple de 100 DT")
                }else{
                    $(".subscription-amount-error").html("")
                }
            })
        });

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).val()).select();
            document.execCommand("copy");
            toastr.success('@lang('app.campaign_url_copied')', '@lang('app.success')', toastr_options);
            $temp.remove();
        }

    </script>

@endsection
