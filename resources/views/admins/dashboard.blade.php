@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-lg-12">
	  	<div class="col-lg-9">
	  		<section class="panel">
	            <header class="panel-heading">
	                KẾT QUẢ BÁN HÀNG HÔM NAY
	            </header>
	            <div class="panel-body">
	            	<div class="row state-overview">
	                  	<div class="col-lg-4">
	                      <section class="panel">
	                          <div class="symbol terques">
	                              <i class="fa fa-dollar"></i>
	                          </div>
	                          <div class="value">
	                              <h1>50.000.00</h1>
	                              <p>Doanh số</p>
	                          </div>
	                      </section>
	                  	</div>
	                  	<div class="col-lg-4">
	                      <section class="panel">
	                          <div class="symbol red">
	                              <i class="fa fa-file-o"></i>
	                          </div>
	                          <div class="value">
	                              <h1>99</h1>
	                              <p>Hóa đơn</p>
	                          </div>
	                      </section>
	                  	</div>
	                  	<div class="col-lg-4">
	                      <section class="panel">
	                          <div class="symbol yellow">
	                              <i class="fa fa-reply-all"></i>
	                          </div>
	                          <div class="value">
	                              <h1>100</h1>
	                              <p>Trả hàng</p>
	                          </div>
	                      </section>
	                  </div>
	              </div>
	            </div>
	        </section>

	        <section class="panel">
             	<header class="panel-heading">
                  	DOANH SỐ 
              	</header>
                <div class="panel-body" >
                    <div id="hero-bar" class="graph" style="position: relative;">
                    	<svg class="jsBranch" height="600" version="1.1" width="900" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;">
	                    	<text x="42" y="530" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
	                    	</text>	                    	
	                    	<text x="42" y="480" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">500</tspan>
	                    	</text>	                    	
	                    	<text x="42" y="430" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1 Tỷ</tspan>
	                    	</text>	                    	
	                    	<text x="42" y="330" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2 Tỷ</tspan>
	                    	</text>
	                    	
	                    	<text x="42" y="230" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">3 Tỷ</tspan>
	                    	</text>
	                    	
	                    	<text x="42" y="130" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4 Tỷ</tspan>
	                    	</text>
	                    	
	                    	<text x="42" y="30" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5 Tỷ</tspan>
	                    	</text>
	                    	<!--Month-->
	                    	
	                    	<text x="83" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1</tspan>
	                    	</text>
	                    	<text x="150" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2</tspan>
	                    	</text>
	                    	<text x="215" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">3</tspan>
	                    	</text>
	                    	<text x="280" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4</tspan>
	                    	</text>
	                    	<text x="350" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5</tspan>
	                    	</text>
	                    	<text x="415" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">6</tspan>
	                    	</text>
	                    	<text x="480" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">7</tspan>
	                    	</text>
	                    	<text x="545" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">8</tspan>
	                    	</text>
	                    	<text x="610" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">9</tspan>
	                    	</text>
	                    	<text x="680" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10</tspan>
	                    	</text>
	                    	<text x="740" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">11</tspan>
	                    	</text>
	                    	<text x="810" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">12</tspan>
	                    	</text>
	                    	<!--End month-->
	                    	<!--Chart-->
	                    	<rect x="63" y="480" width="49" height="50" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="129" y="460" width="49" height="70" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="195" y="430" width="49" height="100" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="261" y="500" width="49" height="30" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="327" y="330" width="49" height="200" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="393" y="0" width="49" height="530" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="459" y="430" width="49" height="100" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>	                    	
	                    	<rect x="525" y="400" width="49" height="130" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="591" y="330" width="49" height="200" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="657" y="130" width="49" height="400" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="723" y="30" width="49" height="500" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="789" y="430" width="49" height="100" r="0" rx="0" ry="0" fill="#6883a3" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<!--End chart-->
                    	</svg>
                    	<svg class="jsBranch_1 disabled" height="600" version="1.1" width="900" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;">
	                    	<text x="42" y="530" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
	                    	</text>	                    	
	                    	<text x="42" y="480" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">500</tspan>
	                    	</text>	                    	
	                    	<text x="42" y="430" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1 Tỷ</tspan>
	                    	</text>	                    	
	                    	<text x="42" y="330" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2 Tỷ</tspan>
	                    	</text>
	                    	
	                    	<text x="42" y="230" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">3 Tỷ</tspan>
	                    	</text>
	                    	
	                    	<text x="42" y="130" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4 Tỷ</tspan>
	                    	</text>
	                    	
	                    	<text x="42" y="30" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5 Tỷ</tspan>
	                    	</text>
	                    	<!--Month-->
	                    	
	                    	<text x="83" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1</tspan>
	                    	</text>
	                    	<text x="150" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2</tspan>
	                    	</text>
	                    	<text x="215" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">3</tspan>
	                    	</text>
	                    	<text x="280" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4</tspan>
	                    	</text>
	                    	<text x="350" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5</tspan>
	                    	</text>
	                    	<text x="415" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">6</tspan>
	                    	</text>
	                    	<text x="480" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">7</tspan>
	                    	</text>
	                    	<text x="545" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">8</tspan>
	                    	</text>
	                    	<text x="610" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">9</tspan>
	                    	</text>
	                    	<text x="680" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10</tspan>
	                    	</text>
	                    	<text x="740" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">11</tspan>
	                    	</text>
	                    	<text x="810" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">12</tspan>
	                    	</text>
	                    	<!--End month-->
	                    	<!--Chart-->
	                    	<rect x="63" y="510" width="49" height="20" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="129" y="520" width="49" height="10" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="195" y="520" width="49" height="10" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="261" y="500" width="49" height="30" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="327" y="330" width="49" height="200" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="393" y="300" width="49" height="230" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="459" y="440" width="49" height="90" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>	                    	
	                    	<rect x="525" y="430" width="49" height="100" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="591" y="430" width="49" height="100" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="657" y="330" width="49" height="200" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="723" y="230" width="49" height="300" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="789" y="480" width="49" height="50" r="0" rx="0" ry="0" fill="#1caadc" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<!--End chart-->
                    	</svg>
                    	<svg class="jsBranch_2 disabled" height="600" version="1.1" width="900" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;">
	                    	<text x="42" y="530" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
	                    	</text>	                    	
	                    	<text x="42" y="480" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">500</tspan>
	                    	</text>	                    	
	                    	<text x="42" y="430" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1 Tỷ</tspan>
	                    	</text>	                    	
	                    	<text x="42" y="330" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2 Tỷ</tspan>
	                    	</text>
	                    	
	                    	<text x="42" y="230" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">3 Tỷ</tspan>
	                    	</text>
	                    	
	                    	<text x="42" y="130" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4 Tỷ</tspan>
	                    	</text>
	                    	
	                    	<text x="42" y="30" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5 Tỷ</tspan>
	                    	</text>
	                    	<!--Month-->
	                    	
	                    	<text x="83" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1</tspan>
	                    	</text>
	                    	<text x="150" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2</tspan>
	                    	</text>
	                    	<text x="215" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">3</tspan>
	                    	</text>
	                    	<text x="280" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4</tspan>
	                    	</text>
	                    	<text x="350" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5</tspan>
	                    	</text>
	                    	<text x="415" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">6</tspan>
	                    	</text>
	                    	<text x="480" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">7</tspan>
	                    	</text>
	                    	<text x="545" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">8</tspan>
	                    	</text>
	                    	<text x="610" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">9</tspan>
	                    	</text>
	                    	<text x="680" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10</tspan>
	                    	</text>
	                    	<text x="740" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">11</tspan>
	                    	</text>
	                    	<text x="810" y="550">
	                    		<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">12</tspan>
	                    	</text>
	                    	<!--End month-->
	                    	<!--Chart-->
	                    	<rect x="63" y="500" width="49" height="30" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="129" y="470" width="49" height="60" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="195" y="440" width="49" height="90" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="261" y="500" width="49" height="30" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="327" y="330" width="49" height="200" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="393" y="300" width="49" height="230" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="459" y="520" width="49" height="10" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>	                    	
	                    	<rect x="525" y="500" width="49" height="30" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="591" y="430" width="49" height="100" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="657" y="330" width="49" height="200" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="723" y="330" width="49" height="200" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<rect x="789" y="480" width="49" height="50" r="0" rx="0" ry="0" fill="#61a642" stroke="#000" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
	                    	<!--End chart-->
                    	</svg>
                    	<div class="center">
			               	<a href="javascript:;" class="jsYearBranch">Công ty</a>
			               	<a href="javascript:;" class="jsYearBranch_1">Chi nhánh 1</a>
			               	<a href="javascript:;" class="jsYearBranch_2">Chi nhánh 2</a>
		               	</div>
                	</div>                	
               	</div>
            </section>
	  	</div>
	  	<div class="col-lg-3">
	  		<section class="panel">
	          	<header class="panel-heading">                  
	              CÁC HOẠT ĐỘNG GẦN ĐÂY
	          	</header>
	          	<div class="panel-body">
	              <div class="timeline-messages">
	                  <!-- Comment -->
	                  <div class="msg-time-chat">
	                      <a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar.jpg" alt=""></a>
	                      <div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Vu Nguyen</a> Vừa bán đơn hàng với giá trị 107,339,000</p>
	                          	</div>
	                      </div>
	                  </div>
	                  <!-- /comment -->

	                  <!-- Comment -->
	                  <div class="msg-time-chat">
	                      <a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar2.jpg" alt=""></a>
	                      <div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Hoang Phi</a> Vừa bán đơn hàng với giá trị 7,339,000</p>
	                          	</div>
	                      </div>
	                  </div>
	                  <!-- /comment -->

	                  <!-- Comment -->
	                  <div class="msg-time-chat">
	                      <a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar2.jpg" alt=""></a>
	                      <div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Hoang Phi</a> Vừa bán đơn hàng với giá trị 17,339,000</p>
	                          	</div>
	                      </div>
	                  </div>
	                  <!-- /comment -->

	                  <!-- Comment -->
	                  <div class="msg-time-chat">
	                      <a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar.jpg" alt=""></a>
	                      <div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Vu Nguyen</a> Vừa bán đơn hàng với giá trị 27,339,000</p>
	                          	</div>
	                      </div>
	                  </div>
	                  <!-- /comment -->
	                  	<!-- Comment -->
	                  	<div class="msg-time-chat">
	                      	<a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar.jpg" alt=""></a>
	                      	<div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Vu Nguyen</a> Vừa bán đơn hàng với giá trị 37,339,000</p>
	                          	</div>
	                      	</div>
	                  	</div>
	                  	<!-- /comment -->
	                  	<!-- Comment -->
	                  	<div class="msg-time-chat">
	                      	<a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar.jpg" alt=""></a>
	                      	<div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Vu Nguyen</a> Vừa bán đơn hàng với giá trị 37,339,000</p>
	                          	</div>
	                      	</div>
	                  	</div>
	                  	<!-- /comment -->
	                  	<!-- Comment -->
	                  	<div class="msg-time-chat">
	                      	<a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar.jpg" alt=""></a>
	                      	<div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Vu Nguyen</a> Vừa bán đơn hàng với giá trị 37,339,000</p>
	                          	</div>
	                      	</div>
	                  	</div>
	                  	<!-- /comment -->
	                  	<!-- Comment -->
	                  	<div class="msg-time-chat">
	                      	<a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar.jpg" alt=""></a>
	                      	<div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Vu Nguyen</a> Vừa bán đơn hàng với giá trị 37,339,000</p>
	                          	</div>
	                      	</div>
	                  	</div>
	                  	<!-- /comment -->
	                  	<!-- Comment -->
	                  	<div class="msg-time-chat">
	                      	<a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar.jpg" alt=""></a>
	                      	<div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Vu Nguyen</a> Vừa bán đơn hàng với giá trị 37,339,000</p>
	                          	</div>
	                      	</div>
	                  	</div>
	                  	<!-- /comment -->
	                  	<!-- Comment -->
	                  	<div class="msg-time-chat">
	                      	<a href="#" class="message-img"><img class="avatar" src="/assets/admin/img/chat-avatar.jpg" alt=""></a>
	                      	<div class="message-body msg-in">
	                          	<span class="arrow"></span>
	                          	<div class="text">
	                          		<p>15-06-2016 15:30</p>
	                             	<p class="attribution"><a href="#">Vu Nguyen</a> Vừa bán đơn hàng với giá trị 37,339,000</p>
	                          	</div>
	                      	</div>
	                  	</div>
	                  	<!-- /comment -->
	              	</div>
	          	</div>
	        </section>
	  	</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.jsYearBranch').on('click', function(){
			$('.jsBranch').show();
			$('.jsBranch_1').hide();
			$('.jsBranch_2').hide();
		})
		$('.jsYearBranch_1').on('click', function(){
			$('.jsBranch_1').show();
			$('.jsBranch').hide();
			$('.jsBranch_2').hide();
		})
		$('.jsYearBranch_2').on('click', function(){
			$('.jsBranch_2').show();
			$('.jsBranch').hide();
			$('.jsBranch_1').hide();
		})
	})
</script>
@stop