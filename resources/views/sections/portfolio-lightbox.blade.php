
<span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">
      
  @if(isset($portfolioImages) && count($portfolioImages) > 0) 
  @php
  $totalCount = sizeof($portfolioImages->images());
  @endphp
    @foreach( $portfolioImages->images() as $key => $image)
       <div class="mySlides" @if($key == 0) style="display:block" @endif>
        <div class="numbertext">{{ ++$key.'/'.$totalCount }}</div>
        <img src="{{ asset(config('image.portfolio_image_url').'thumbnails/small/'. $image) }}" style="width:100%;height:400px" >
      </div>
    @endforeach
      <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
      <a class="next" onclick="plusSlides(1)">&#10095;</a>

      <div class="caption-container">
        <p id="caption">{{$portfolioImages->title}}</p>
      </div>

      @foreach( $portfolioImages->images() as $key => $image)
      <div class="column">
        <img class="demo cursor" src="{{ asset(config('image.portfolio_image_url').'thumbnails/small/'. $image) }}" style="width:100%" onclick="currentSlide({{++$key}})" >
      </div>     
      @endforeach
    @endif
  </div>
