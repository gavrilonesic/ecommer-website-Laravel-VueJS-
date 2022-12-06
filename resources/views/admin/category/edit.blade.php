@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('EditCategory') !!}
        </div>
        {!! Form::model($category, ['name' => 'edit-category-form', 'method' => 'PUT', 'id' => 'edit-category-form', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-12">
                                  <div class="form-group">
                                     <label for="email">{{__('messages.email')}}</label>
                                     {!! Form::text('email', null, ['id' => 'email', 'placeholder' => __('messages.enter_email'), 'class' => "form-control "]) !!}
                                  </div>
                               </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12 col-lg-12">
                                  <div class="form-group">
                                      <label for="short_description">
                                          {{__('messages.short_description')}}
                                      </label>
                                      {!! Form::textarea('short_description', null, ['id' => 'short_description','class'=>'form-control']) !!}
                                  </div>
                              </div>
                          </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="description">{{__('messages.description')}}</label>
                                        {!! Form::textarea('description', null, ['id' => 'description']) !!}
                                    </div>
                                </div>
                            </div>

                            </div>
                </div> </div>
                <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <h4 class="card-title">{{__('messages.images')}}</h4>
                  </div>
                  @csrf
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group">
                           <div class="input-file input-file-image">
                              <label>{{__('messages.image')}}</label>
                              <img class="img-upload-preview" width="150" src="{{$category->getMedia('category')->first() ? $category->getMedia('category')->first()->getUrl('thumb') : asset('images/150x150.png')}}" alt="preview">
                                {!! Form::file('image', ['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}

                                @if($category->getMedia('category')->first())
                                <i class="icon-close remove-image"  data-toggle="tooltip" data-placement="top" title="Remove Image" data-type="category"></i>
                                @endif

                                <label for="image" class="label-input-file">
                                    <span class="btn-label">
                                        <i class="icon-plus"  data-toggle="tooltip" data-placement="top" title="{{__('messages.add_image')}}"></i>
                                    </span>
                                </label>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="input-file input-file-image">
                              <label>{{__('messages.logo')}}</label>
                              <img class="img-upload-preview" width="150" src="{{$category->getMedia('logo')->first() ? $category->getMedia('logo')->first()->getUrl('thumb') : asset('images/150x150.png')}}" alt="preview">
                              {!! Form::file('logo', ['id' => 'logo', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}

                              @if($category->getMedia('logo')->first())
                                <i class="icon-close remove-image"  data-toggle="tooltip" data-placement="top" title="Remove Image" data-type="logo"></i>
                              @endif
                              <label for="logo" class="label-input-file">
                                 <span class="btn-label">
                                 <i class="icon-plus"  data-toggle="tooltip" data-placement="top" title="{{__('messages.add_logo')}}"></i>
                                 </span>
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

                 <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header">
                         <h4 class="card-title">{{__('messages.parent_category')}}
                         </h4>
                      </div>
                      <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <button class="btn-link ml-auto" data-toggle="modal" type="button" id="expand-all">
                                            <i class="icon-plus"></i> {{__('messages.expand_all')}}
                                        </button>
                                        <button class="btn-link ml-auto" data-toggle="modal" type="button" id="collapse-all">
                                            <i class="icon-minus"></i> {{__('messages.collapse_all')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group">
                                        <ul class="form-check checkboxdesign" id="{{$category->level}}">
                                            <li>
                                                <div class="custom-control custom-radio" id="{{$category->level}}">
                                                  @if($category->parent_id == 0)
                                                    {{ Form::radio('parent_id', '0', true, array('class'=>'custom-control-input category_type', "id" => "custom-0", "checked" => "checked")) }}
                                                  @else
                                                    {{ Form::radio('parent_id', '0', true, array('class'=>'custom-control-input category_type', "id" => "custom-0")) }}
                                                    @endif
                                                    <label class="custom-control-label" for="custom-0">Parent</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                  @if($category->parent_id != 0)
                                                    {{ Form::radio('custom_child', 'null', false, array('class'=>'custom-control-input category_type', "id" => "custom_child", "checked" => "checked")) }}
                                                  @else
                                                  {{ Form::radio('custom_child', 'null', false, array('class'=>'custom-control-input category_type', "id" => "custom_child")) }}
                                                  @endif
                                                    <label class="custom-control-label" for="custom_child">Child</label>
                                                    {{ Form::hidden("parent_cat", '0') }}
                                                 </div>
                                            </li>
                                            <div class="col-sm-12 hideifparent">
                                            <div class="row">
                                            @include('admin.category.manage_child',['childs' => $categories, 'parent' => 0])</div>
                                        </ul>
                                    </div>

                                </div>
                                </div>
                            </div>
                         </div>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> {{__('messages.configuration_area')}}</h4>
                            </div>
                           <div class="card-body">

                        <div class="row">
                          <div class="col-md-6 col-lg-6">
                              <div class="form-group">
                                  <label for="template_layout">{{__('messages.template_layout')}}</label>
                                  <div class="select2-input">
                                      {!! Form::select('template_layout', config('constants.TEMPLATE_LAYOUT'), null, ['id' => 'template_layout', 'class' => 'form-control']) !!}
                                  </div>
                              </div>
                          </div>
                          {{-- <div class="col-md-6 col-lg-6">
                              <div class="form-group">
                                  <label for="name">{{__('messages.sort_order')}}</label>
                                      {!! Form::text('sort_order', null, ['id' => 'name', 'placeholder' => __('messages.enter_sort_order'), 'class' => 'form-control']) !!}
                              </div>
                          </div> --}}
                      </div>
                      </div></div>
                        </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.search_engine_optimization')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="page_title">{{__('messages.page_title')}}</label>
                                        {!! Form::text('page_title', null, ['id' => 'page_title', 'placeholder' => __('messages.enter_page_title'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="meta_tag_keywords">{{__('messages.meta_keywords')}}</label>
                                        {!! Form::text('meta_tag_keywords', null, ['id' => 'meta_tag_keywords', 'placeholder' => __('messages.enter_meta_keywords'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="meta_tag_description">{{__('messages.meta_description')}}</label>
                                        {!! Form::text('meta_tag_description', null, ['id' => 'meta_tag_description', 'placeholder' => __('messages.enter_meta_description'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="slug">{{__('messages.url')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('slug', null, ['id' => 'slug', 'placeholder' => __('messages.url'), 'class' => "form-control" . ($errors->has('slug') ? 'is-invalid' : '')]) !!}
                                        @include('admin.error.validation_error', ['field' => 'slug'])

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="{{route('category.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                            <button class="btn btn-success">{{__('messages.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/plugin/summernote/summernote-bs4.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoryRequest', '#edit-category-form') !!}
<script>
    $(document).ready(function() {
      var hidsubcat = '{{$category->level}}';
      if(hidsubcat == 0){
        $('.hideifparent').hide();
      }else{
        $('.hideifparent').show();
      }
        $('#description').summernote({
            placeholder: "{{__('messages.description')}}",
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            tabsize: 2,
            height: 300
        });
        $('#template_layout').select2({
            theme: "bootstrap"
        });
        $("i.expand-icon").each(function() {
            if ($(this).closest('li').find('ul').find('[name="parent_id"]:checked').length > 0) {
                if (!$($(this).data('target')).hasClass( "show" )) {
                    $($(this).data('target')).collapse('show');
                }
            }
        });
        //category_edit_page
        // $('input[name="parent_id"]').on('click',function(){
        //     var value = $(this).val();
        //     //alert(value);
        //     if(value == '1'){
        //         jQuery('.hideifparent').show();
        //     }else if(value == '0'){
        //         jQuery('.hideifparent').hide();
        //     }
        //     else{
        //         jQuery('.hideifparent').show();
        //     }
        // });
    });
</script>
@endsection