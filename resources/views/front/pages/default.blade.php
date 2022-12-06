@extends('front.layouts.app')
@section('content')
  <section {{ ($pageData->slug == 'ethics') ? 'class=ethicspage': ''}}>
    <div class="container-fluid ">
      <div class="row">
        <div class="col-md-12 innerbanner" style="background-image:url({{ !empty($pageData->medias) ? $pageData->medias->getUrl() :  asset('images/no-image/default-page.png') }});">
        <div class="container"><h1 class="wow slideInLeft">{!! $pageData->title ? $pageData->title : '' !!}</h1></div>
        </div>
      </div>
    </div>

          <div class="static-content">
              <div class="{{ ($pageData->slug == 'ethics') ? 'container-fluid': 'container'}}">

                    <p>{!! $pageData->description  !!}</p>


              </div>
          </div>
      </div>
  </section>
@endsection