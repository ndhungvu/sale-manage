<div id="sidebar">
    @if($top_streams && count($top_streams) > 0)
    <div class="jsStreamHot">
        <h4 class="h4index">Lịch trực tiếp</h4>
        <div class="first-cld bot-30">
            <?php $inc = 0;?>
            @foreach($top_streams as $key => $stream)
                @if(time() <=  strtotime($stream->time_match) + 60*60*2 && (!empty($stream->link_match) || !empty($stream->link_youtube) || !empty($stream->link_other)))
                <div class="box-cld">
                    <a href="/bong-da-truc-tuyen/{!! $stream->slug !!}">
                        <div class="img-sb-left">
                            <img src="/{!! $stream->logo_team_1!!}" alt="{!! $stream->name_team_1 !!}" width="40" height="40">
                            <strong>{!! str_limit($stream->name_team_1, 7, '..') !!}</strong>
                        </div>           
                            <p class="txt-tg">
                                <strong>{!! date('H:i',strtotime($stream->time_match)) !!}</strong>
                                {!! date('d-m',strtotime($stream->time_match)) !!}
                            </p>
                        <div class="img-sb-right">
                            <img src="/{!! $stream->logo_team_2!!}" alt="{!! $stream->name_team_2 !!}" width="40" height="40">
                            <strong>{!! str_limit($stream->name_team_2, 7, '..') !!}</strong>
                        </div>
                    </a>
                </div>
                <?php $inc ++;?>
                @endif
            @endforeach
            @if($inc == 0)
            <script type="text/javascript">
                $(document).ready(function(){
                    $('.jsStreamHot').remove();
                });
            </script>
            @endif
        </div>
    </div>
    @endif
    <!--Top Videos-->
    @if($top_videos && count($top_videos) > 0)
    <h4 class="h4index">Video xem nhiều</h4>
    <div class="first-cld bot-30">
        <ul class="list-video vs-side">
            @foreach($top_videos as $key => $video)
            <li>
                <a href="/videos/{!! $video->slug !!}">
                    <div class="img-vd">
                        <img src="/{!! $video->image !!}" alt="{!! $video->title !!}" widht="208" height="114">
                        <div class="mask"></div>
                        <div class=" video-icon">
                            <i class="fa fa-play-circle-o"></i>
                        </div>
                    </div>
                    <p>{!! $video->title !!}</p>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!--Top Articles-->
    @if($top_articles && count($top_articles) > 0)
    <h4 class="h4index">Tin mới nhất</h4>
    <div class="first-cld bot-30">
        <ul class="news">
            @foreach($top_articles as $key => $article)
            <li>
                <a href="/tin-bong-da/{!! $article->slug !!}">
                    <img src="/{!! $article->image !!}" alt="{!! $article->title !!}" class="news-img" width="85" height="60">
                    <p>{!! $article->title !!}</p>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    @if($tags && count($tags) > 0)
    <div class="first-cld bot-30">
        <p class="textTag">Tags</p>
        <ul class="list-tags">
            @foreach($tags as $key => $tag)
            <li>
                <a href="">
                <i class="fa fa-tags"></i>
                    {!! $$tag->name !!}
                </a>
            </li>
            @endforeach
        </ul>
        <p class="view-more"><a href="">Xem thêm</a></p>
    </div>
    @endif
    <!--Fan page-->
    <div class="fb-page jsFbPage" data-href="https://www.facebook.com/tvonlinecomvn" data-width="230" data-hide-cover="false" data-show-facepile="true"></div>
</div>