<div id="banner">
    <div id="slider" class="sl-slider-wrapper">
        <div class="sl-slider">
            @if($banners && count($banners) > 0)
                @foreach($banners as $key => $banner)
                <div class="sl-slide bg-1" data-orientation="horizontal" data-slice-rotation="-15" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                    <a href="" alt="{!! $banner->title!!}"><img src="{!! $banner->image !!}"></a>
                </div>
                @endforeach
            @endif           
            <nav id="nav-arrows" class="nav-arrows"> <span class="nav-arrow-prev">Previous</span> <span class="nav-arrow-next">Next</span> </nav>
            <nav id="nav-dots" class="nav-dots"> <span class="nav-dot-current"></span> <span></span> <span></span> <span></span> </nav>  
        </div>
    </div>
</div>