<?php

return [
    "MASTER_ADMIN_ID" => 1,
    'ADMINISTATOR_TITLE' => 'General Chemical',
    'ADMIN_CONST' => [
        'STATUS_DELETE' => 2,
        'STATUS_ACTIVE' => 1,
        'STATUS_INACTIVE' => 0,
        'SUPER_ADMIN' => 1,
        'PAGE_TITLE_SEPARATOR' => ' | ',
    ],
    'STATUS' => [
        'STATUS_ACTIVE' => 1,
        'STATUS_INACTIVE' => 0,
        "STATUS_CANCEL" => 0,
        "STATUS_RETURN" => 2,
    ],
    'REVIEW_STATUS' => [
        // 0 => 'Pending',
        1 => 'Approved',
        2 => 'Disapproved',
    ],
    'REVIEW_RATING' => [
        1 => 'Poor',
        2 => 'Below Average',
        3 => 'Average',
        4 => 'Good',
        5 => 'Excellent',
    ],
    'IMAGE_PATH' => [
        'AVATAR' => 'public/avatars/',
        'GENERAL_IMAGE' => 'images/',
        'CATEGORY_IMAGE' => 'public/category/',
        'DRIVER' => 'local'
    ],
    'DEFAULT_IMAGE_NAME' => [
        'AVATAR' => 'default-avatar.png',
    ],
    "TEMPLATE_LAYOUT" => [
        "default" => "Default",
        "category_with_product" => "Category With Product",
        "category_with_compare_products" => "Category With Compare Product",
        "category_with_product_application" => "Category With Product Application",
    ],
    "ATTRIBUTE_TYPE" => [
        "" => "Select Attribute",
        "select" => "Select",
        "radio" => "Radio",
    ],
    "PRODUCT_TYPE" => [
        "simple" => "Simple",
        "configurable" => "Configurable"
    ],
    "PRODUCT_MAX_UPLOAD" => 10,
    "THUMB_IMAGE" => [
        "HEIGHT" => 250,
        "WIDTH" => 250
    ],
    "MEDIUM_IMAGE" => [
        "HEIGHT" => 500,
        "WIDTH" => 500
    ],
    "CATEGORY_THUMB" => [
        "HEIGHT" => 185,
        "WIDTH" => 365
    ],
    "CATEGORY_LOGO_THUMB" => [
        "HEIGHT" => 100,
        "WIDTH" => 250
    ],
    "BANNER_IMAGE" => [
        "HEIGHT" => 500,
        "WIDTH" => 1300
    ],
    "SAVE_AS_DRAFT" => 0,
    "BILLING_TYPE" => [
        0 => 'Billing',
        1 => 'Shipping',
    ],
    "ADDRESS_TYPE" => [
        0 => 'Residential',
        1 => 'Commercial',
    ],
    'STATUS_LIST' => [
        1 => "Active",
        0 => "Inactive",
    ],
    "ORDER_DELIVERED" => 1,
    "ROLES" => [
        1 => "Admin",
        2 => "User",
    ],
    "ADMIN_ROLE" => 1,
    "USER_ROLE" => 2,
    "BANNER_TYPE" => [
        "SMALL_WIDTH" => 0,
        "FULL_WIDTH" => 1,
    ],
    "BANNER_POSITION" => [
        "TOP" => 0,
        "LEFT" => 1
    ],
    "CART_SESSION" => 'product-into-cart',
    "DEFAULT_ORDER_STATUS" => 1,
    "ORDER_STATUS" => [
        "AWAITING_PICKUP" => 3,
        "SHIPPED" => 4,
        "DECLINED_CANCELLED" => 6,
        "COMPLETED" => 5,
    ],
    "CUSTOMER_EMAIL_TEMPLATE" => [
        1 => 'customer.order_confirm',
        3 => 'customer.order_awaiting_pickup',
        4 => 'customer.order_shipped',
        5 => 'customer.order_completed',
        6 => 'customer.order_cancelled',
    ],
    "MAXIMUM_QUANTITY_PER_PRODUCT" => 500,
    "SHIPPING_ZONES" => [
        0 => [
            'title' => 'add_a_country_zone',
            'view' => 'country_zone',
        ],
        1 => [
            'title' => 'add_a_state_zone',
            'view' => 'state_zone',
        ],
        2 => [
            'title' => 'add_the_rest_of_the_world',
            'view' => 'rest_of_the_world',
        ],
    ],
    "SHIPPING_QUOTES" => [
        "free_shipping" => [
            'view' => 'free_shipping',
            'is_free' => 1,
        ],
        "truck_freight_shipping" => [
            'view' => 'truck_freight_shipping',
        ],
        "flat_rate" => [
            'view' => 'flat_rate',
        ],
        "pickup_in_store" => [
            'view' => 'pickup_in_store',
        ],
    ],
    "SHIPPING_RATE" => [
        "TYPE" =>[
            "1" => "Per Order",
            "2" => "Per Item",
        ]
    ],
    "PAGE_META_TITLE"=>[
        'login' => 'Login',
        'register' => 'Register',
        'reset' => 'Reset Password',
        'my-account' => 'My Account',
        'my-profile' => 'My Profile',
        'my-order' => 'My Orders',
        'my-addresses' => 'My Addresses',
        'cart' => 'Cart',
        'checkout' => 'Checkout',
        'my-wishlist'=>'My Wishlist',
        'order-place'=>'Thank You',
    ],
    "ORDER_DELETE"=>false,
    'SHIPPING_PROVIDERS' => [
        1 => 'UPS',
        2 => 'Other'
    ],
    'CUSTOM_SHIPPING_PROVIDER_ID' => 2,

    "DEFAULT_COUNTRY_ID" => 233,

    'hazmat_shipping_cost' => 55,

    'ltl_hazmat_shipping_cost' => 75,
];
