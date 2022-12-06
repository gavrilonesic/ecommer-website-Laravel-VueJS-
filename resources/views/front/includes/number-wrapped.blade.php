@php
    $ind = rand(0,12304123123);
@endphp
<div class="input-group number-wrapper" id="number-wrapper-{{ $ind }}">
    <input type="button" value="-" class="button-minus" data-field="quantity">
    {!! Form::Number('quantity',1, [
        "step"      => "1",
        "min"       => "1",
        "max"       => "",
        "value"     => "1",
        "id"        => $attributes['id'],
        "data-id"   => $attributes['data-id'],
        "name"      => "quantity",
        "class"     => "quantity-field"
        ]) !!}
    <input type="button" value="+" class="button-plus" data-field="quantity">
</div>

<script>
    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field'),
            parent = $(e.target).closest('div'),
            currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10),
            $element = parent.find('input[name=' + fieldName + ']');
        if (!isNaN(currentVal)) {
            $element.val(currentVal + 1);
        } else {
            $element.val(1);
        }
        if($element.closest('.quick-add-to-cart').length > 0) {
            calculatePriceQuick();
        }

        calculatePrice();
    }
    
    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field'),
            parent = $(e.target).closest('div'),
            currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10),
            $element = parent.find('input[name=' + fieldName + ']');

        if (!isNaN(currentVal) && currentVal > 1) {
            $element.val(currentVal - 1);
        } else {
            $element.val(1);
        }

        $element.change();

    }
    
    $('#number-wrapper-{{ $ind }} .button-plus').on('click', function(e) {
        incrementValue(e);
    });

    $('#number-wrapper-{{ $ind }} .button-minus').on('click', function(e) {
        decrementValue(e);
    });
    
</script>
