<div class="table-responsive">
    <table class="display table table-head-bg-primary table-striped">
        <thead>
            <tr>
                <th>
                    {{__('messages.image')}}
                </th>
                <th>
                    {{__('messages.attribute')}}
                </th>
                <th>
                    {{__('messages.sku')}}
                </th>
                <th>
                    {{__('messages.weight')}} ({{setting('weight_in')}})
                </th>
                <th>
                    {{__('messages.depth')}} ({{setting('depth_in')}})
                </th>
                <th>
                    {{__('messages.height')}} ({{setting('height_in')}})
                </th>
                <th>
                    {{__('messages.width')}} ({{setting('width_in')}})
                </th>
                <th>
                    {{__('messages.default_price')}} ({{setting('currency_symbol')}})
                </th>
                <th>
                    {{__('messages.include_product_option_in_feed')}}
                </th>
                <th>
                    Hazmat
                </th>
                <th>
                    Ship By Air
                </th>
                <th class="show-attribute-level-inventory">
                    {{__('messages.quantity')}}
                </th>
                <th class="show-attribute-level-inventory">
                    {{__('messages.low_stock')}}
                </th>
                <th>
                    {{__('messages.action')}}
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $isEdit = false;
                if (!empty($product->id)) {
                    $isEdit = true;
                }
                $types = App\ProductSku::HAZMAT_TYPES;
            @endphp


            @foreach($attributeMatrix as $key => $attributes)
                @php
                    $variant = $attributeOption = [];
                    if ($isEdit) {
                        $attributeObject = $attributes;
                        $attributes = $attributes->productSkuValues;
                        $variant['option'] = '';
                    } else if (isset($oldData)) {
                        $attributeObject = $attributes;
                        $attributeOption = $attributeObject['sku_values'];
                        $variant['option'] = $attributeObject['option_slug'];
                    }

                    $attributeObject = $attributeObject ?? [];

                @endphp
                @if(!isset($oldData))
                    @foreach($attributes as $attribute)
                        @php
                            if ($isEdit) {
                                $attribute = $attribute->attributeOptions->toArray();
                            }
                            if (!empty($variant)) {
                                $variant['option'] .= ' ' . $attribute['option'];
                                // $variant['option_id'] .= '-' . $attribute['id'];
                                // $variant['attribute_id'] .= '-' . $attribute['attribute_id'];
                            } else {
                                $variant['option'] = $attribute['option'];
                                // $variant['option_id'] = $attribute['id'];
                                // $variant['attribute_id'] = $attribute['id'];
                            }
                            $attributeOption[] = [
                                'attribute_id' => $attribute['attribute_id'],
                                'attribute_option_id' => $attribute['id']
                            ];
                        @endphp
                    @endforeach
                    @php
                        $attributeOption = json_encode($attributeOption);
                    @endphp
                @endif
                <tr>
                    <td>
                        <div class="input-file input-file-image">
                            <img class="img-upload-preview" width="150" src="{{isset($attributeObject->medias) ? $attributeObject->medias->getUrl() : asset('images/150x150.png')}}" alt="preview">
                            {!! Form::file("attribute[$key][image]", ['id' => "image[$key]", 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                            <label for="image[{{$key}}]" class="label-input-file">
                                <span class="btn-label">
                                <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="Add Image"></i>
                                </span>
                                <!-- {{__('messages.upload_image')}} -->
                            </label>
                        </div>
                    </td>
                    @php
                        if ($isEdit) {
                            $attributeObject = $attributeObject->toArray();
                        }
                    @endphp
                    <td>
                        {{$variant['option']}}
                    </td>
                    <td>
                        @if ($isEdit)
                            {!! Form::hidden("attribute[$key][id]", $attributeObject['id'] ?? "") !!}
                        @endif
                        {!! Form::hidden("attribute[$key][sku_values]", $attributeOption) !!}
                        {!! Form::hidden("attribute[$key][option_slug]", $variant['option']) !!}
                        {!! Form::text("attribute[$key][sku]", $attributeObject['sku'] ?? "", ['class' => "form-control", 'placeholder' => __('messages.sku')]) !!}
                    </td>
                    <td>
                        {!! Form::text("attribute[$key][weight]", $attributeObject['weight'] ?? "", ['class' => "form-control", 'placeholder' => __('messages.weight')]) !!}
                    </td>
                    <td>
                        {!! Form::text("attribute[$key][depth]", $attributeObject['depth'] ?? "", ['class' => "form-control", 'placeholder' => __('messages.depth')]) !!}
                    </td>
                    <td>
                        {!! Form::text("attribute[$key][height]", $attributeObject['height'] ?? "", ['class' => "form-control", 'placeholder' => __('messages.height')]) !!}
                    </td>
                    <td>
                        {!! Form::text("attribute[$key][width]", $attributeObject['width'] ?? "", ['class' => "form-control", 'placeholder' => __('messages.width')]) !!}
                    </td>
                    <td>
                        {!! Form::text("attribute[$key][price]", $attributeObject['price'] ?? "", ['class' => "form-control", 'placeholder' => __('messages.price')]) !!}
                    </td>
                    <td class="form-group">
                            {!! Form::checkbox("attribute[$key][include_in_feed]", '1', isset($attributeObject['include_in_feed']) && $attributeObject['include_in_feed'] ? true : null) !!}
                    </td>
                    <td class="form-group text">
                        <select class="form-control" name="attribute[{{$key}}][hazmat_type]">
                            @foreach ($types as $key=>$type)
                                <option {{isset($attributeObject['hazmat_type']) && $attributeObject['hazmat_type'] == $key ? 'selected' : ''}} value="{{$key}}">{{$type}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="form-group">
                        {!! Form::checkbox("attribute[$key][is_shipping_by_air]", '1', isset($attributeObject['is_shipping_by_air']) && $attributeObject['is_shipping_by_air'] ? true : null) !!}
                    </td>
                    <td class="show-attribute-level-inventory">
                        {!! Form::text("attribute[$key][quantity]", $attributeObject['quantity'] ?? "", ['class' => "form-control", 'placeholder' => __('messages.quantity')]) !!}
                    </td>
                    <td class="show-attribute-level-inventory">
                        {!! Form::text("attribute[$key][low_stock]", $attributeObject['low_stock'] ?? "", ['class' => "form-control", 'placeholder' => __('messages.low_stock')]) !!}
                    </td>
                    <td>
                        <button class="btn btn-link btn-danger btn-delete-attribute" data-original-title="Delete Attribute">
                            <i class="icon-close"  data-toggle="tooltip" data-placement="top" title="Delete Attributes"></i>
                      
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>