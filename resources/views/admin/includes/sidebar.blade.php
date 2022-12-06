<?php
if (empty($activeSidebarMenu)) {
    $activeSidebarMenu = "";
}
if (empty($activeSidebarSubMenu)) {
    $activeSidebarSubMenu = "";
}
$sidebarMenus = [
    'dashboards' => [
        'text' => __('messages.dashboard'),
        'routeName' => 'admin.dashboard',
        'icon' => 'icon-home'
    ],
    'products' => [
        'text' => __('messages.products'),
        'icon' => 'icon-layers',
        'routeName' => '',
        'subMenu' => [
            'products' => [
                'text' => __('messages.view'),
                'routeName' => 'product.index',
                'icon' => 'fas fa-list-alt',
                'menuName' => 'products',
            ],
            'brands' => [
                'text' => __('messages.brands'),
                'routeName' => 'brand.index',
                'icon' => 'fas fa-home',
                'menuName' => 'brands',
            ],
            'categories' => [
                'text' => __('messages.categories'),
                'routeName' => 'category.index',
                'icon' => 'fas fa-list-alt',
                'menuName' => 'categories',
            ],
            'attributes' => [
                'text' => __('messages.attributes'),
                'routeName' => 'attribute.index',
                'icon' => 'fas fa-list-alt',
                'menuName' => 'attributes',
            ],
            'reviews' => [
                'text' => __('messages.reviews'),
                'routeName' => 'review.index',
                'icon' => 'fas fa-stars',
                'menuName' => 'reviews',
            ],

        ]
    ],
    'orders' => [
        'text' => __('messages.orders'),
        'icon' => 'icon-basket-loaded',
        'routeName' => '',
        'subMenu' => [
            'orders' => [
                'text' => __('messages.view'),
                'routeName' => 'order.index',
                'icon' => 'fas fa-list-alt',
                'menuName' => 'orders',
            ],
            /*'orderStatus' => [
                'text' => __('messages.order_status'),
                'routeName' => 'order_status.index',
                'icon' => 'fas fa-home',
                'menuName' => 'orderStatus',
            ]*/

        ]
    ],
    'users' => [
        'text' => __('messages.users'),
        'icon' => 'icon-people',
        'routeName' => '',
        'subMenu' => [
            'user' => [
                'text' => __('messages.admin_users'),
                'routeName' => 'user.index',
                'menuName' => 'user',
            ],
            'customers' => [
                'text' => __('messages.customers'),
                'routeName' => 'customer.index',
                'menuName' => 'customers',
            ]

        ]
    ],
    'storefront' => [
        'text' => __('messages.storefront'),
        'icon' => 'icon-folder-alt',
        'routeName' => '',
        'subMenu' => [
            'carousels' => [
                'text' => __('messages.carousels'),
                'routeName' => 'carousel.index',
                'icon' => 'fas fa-list-alt',
                'menuName' => 'carousels',
            ],
            'blogs' => [
                'icon' => '',
                'text' => __('messages.blogs'),
                'routeName' => 'blog.index',
                'menuName' => 'blogs',
            ],
            'blogcategory' => [
                'icon' => '',
                'text' => __('messages.blog_categories'),
                'routeName' => 'blogcategory.index',
                'menuName' => 'blogcategory',
            ],
            'cmsPages' => [
                'text' => __('messages.cms_pages'),
                'routeName' => 'cms_page.index',
                'icon' => 'fas fa-list-alt',
                'menuName' => 'cmsPages',
            ],
            'testimonials' => [
                'text' => __('messages.testimonials'),
                'routeName' => 'testimonial.index',
                'icon' => 'fas fa-ticket-alt',
                'menuName' => 'testimonials',
            ],
            'clients' => [
                'text' => __('messages.clients'),
                'routeName' => 'client.index',
                'icon' => 'fas fa-ticket-alt',
                'menuName' => 'clients',
            ],
            'contactforms' => [
                'text' => __('messages.contact_information'),
                'routeName' => 'contactform.index',
                'icon' => '',
                'menuName' => 'contactforms',
            ],
            'videos' => [
                'text' => __('messages.videos'),
                'routeName' => 'video.index',
                'icon' => '',
                'menuName' => 'videos',
            ],
            'emails' => [
                'text' => __('messages.emails'),
                'routeName' => 'email.index',
                'icon' => '',
                'menuName' => 'emails',
            ],

        ]
    ],
    'marketing' => [
        'text' => 'Marketing',
        'icon' => 'icon-share',
        'routeName' => '',
        'subMenu' => [
            'banners' => [
                'text' => __('messages.banners'),
                'routeName' => 'banner.index',
                'icon' => 'fas fa-image',
                'menuName' => 'banners',
            ],
            'coupons' => [
                'text' => __('messages.coupons'),
                'routeName' => 'coupon.index',
                'icon' => 'fas fa-ticket-alt',
                'menuName' => 'coupons',
            ]
        ]
    ],
    'settings' => [
        'text' => __('messages.settings'),
        'icon' => 'icon-settings',
        'subMenu' => [
            'general-settings' => [
                'icon' => 'fas fa-cogs',
                'text' => __('messages.general_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'general-settings'],
                'menuName' => 'general-settings',
            ],
            'product-settings' => [
                'icon' => 'fas fa-tools',
                'text' => __('messages.product_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'product-settings'],
                'menuName' => 'product-settings',
            ],
            /*'email-settings' => [
                'icon' => 'fas fa-envelope-square',
                'text' => __('messages.email_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'email-settings'],
                'menuName' => 'email-settings',
            ], */
            "social-media-settings" => [
                'icon' => 'fas fa-envelope-square',
                'text' => __('messages.social_media_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'social-media-settings'],
                'menuName' => 'social-media-settings',
            ],
            /*'tax-settings' => [
                'icon' => 'fas fa-file-invoice',
                'text' => __('messages.tax_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'tax-settings'],
                'menuName' => 'tax-settings',
            ],*/
            'shipping-settings' => [
                'icon' => 'fas fa-shipping-fast',
                'text' => __('messages.shipping_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'shipping-settings'],
                'menuName' => 'shipping-settings',
            ],
            'payment-settings' => [
                'icon' => 'fas fa-file-invoice-dollar',
                'text' => __('messages.payment_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'payment-settings'],
                'menuName' => 'payment-settings',
            ],
            'mail-chimp-settings' => [
                'text' => __('messages.mail_chimp_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'mail-chimp-settings'],
                'menuName' => 'mail-chimp-settings',
            ],
            'review-settings' => [
                'text' => __('messages.review_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'review-settings'],
                'menuName' => 'review-settings',
            ],
             'sds-settings' => [
                'text' => __('messages.sds_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'sds-settings'],
                'menuName' => 'sds-settings',
            ],
            'seo-settings' => [
                'text' => __('messages.seo_settings'),
                'routeName' => 'settings',
                'parameter' => ['page' => 'seo-settings'],
                'menuName' => 'seo-settings',
            ],
        ]
    ],
];
?>
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <!-- <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="../assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            Hizrian
                            <span class="user-level">Administrator</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#edit">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#settings">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <ul class="nav nav-primary">
                <?php
                foreach ($sidebarMenus as $key => $menu) {
                    ?>
                    <li class="nav-item {{($key == $activeSidebarMenu) ? 'active' : ''}} <?php echo (!empty($menu['subMenu']) && in_array($activeSidebarSubMenu, array_column($menu['subMenu'], 'menuName'))) ? 'submenu' : ''; ?>">
                        <?php if (!empty($menu['subMenu'])) { ?>
                            <a data-toggle="collapse" href="#{{$key}}">
                                <i class="<?= $menu['icon']; ?>"></i>
                                <p>{{__($menu['text']) }}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse <?php echo (!empty($menu['subMenu']) && in_array($activeSidebarSubMenu, array_column($menu['subMenu'], 'menuName'))) ? 'show' : ''; ?>" id="{{$key}}">
                                <ul class="nav nav-collapse">
                                    <?php foreach ($menu['subMenu'] as $key => $subMenu) { ?>
                                        <li class="{{($key == $activeSidebarSubMenu) ? 'active' : ''}}">
                                            <a href="{{(!empty($subMenu['routeName'])) ? route($subMenu['routeName'], $subMenu['parameter'] ?? []) : 'javascript:;' }}">
                                                <span class="sub-item">{{__($subMenu['text'])}}</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } else { ?>
                            <a href="{{(!empty($menu['routeName'])) ? route($menu['routeName']) : 'javascript:;' }}">
                                <i class="<?= $menu['icon']; ?>"></i>
                                <p>{{__($menu['text']) }}</p>
                                <!-- <span class="badge badge-info">1</span> -->
                            </a>
                        <?php } ?>
                    </li>

                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<?php /*
<div class="sidebar-mobile-toggler text-center">
    <a href="#" class="sidebar-mobile-main-toggle">
        <i class="icon-arrow-left8"></i>
    </a>
    Navigation
    <a href="#" class="sidebar-mobile-expand">
        <i class="icon-screen-full"></i>
        <i class="icon-screen-normal"></i>
    </a>
</div>
<div class="sidebar-content">
    <!-- Main navigation -->
    <div class="card card-sidebar-mobile">
        <ul class="nav nav-sidebar" data-nav-type="accordion">
            <?php
            foreach ($sidebarMenus as $key => $menu) {
                ?>
                <?php if (empty($menu['permissionKey']) || \App\Helpers\PermissionHelper::hasAccess($menu['permissionKey'])) { ?>
                    <li class="nav-item <?php echo (!empty($menu['subMenu'])) ? 'nav-item-submenu' : ''; ?><?php echo ($key == $activeSidebarSubMenu) ? "nav-item-open" : ""; ?>" >
                        <a href="<?php echo (!empty($menu['routeName'])) ? route($menu['routeName']) : 'javascript:;'; ?>"  <?php echo ($key == $activeSidebarMenu) ? 'class="nav-link active"' : 'class="nav-link"'; ?>>
                            <i class="<?= $menu['icon']; ?>"></i>
                            <span>
                                {{__($menu['text']) }}
                            </span>
                        </a>
                        <?php if (!empty($menu['subMenu'])) { ?>
                            <ul class="nav nav-group-sub" data-submenu-title=" <?php echo __($menu['text']); ?>" <?php echo (in_array($activeSidebarSubMenu, array_column($menu['subMenu'], 'menuName'))) ? 'style="display: block;"' : ''; ?>>
                                <?php foreach ($menu['subMenu'] as $key => $subMenu) { ?>
                                    <?php if (empty($subMenu['permissionKey']) || \App\Helpers\PermissionHelper::hasAccess($subMenu['permissionKey'])) { ?>
                                        <li class="nav-item">
                                            <a href="<?php echo (!empty($subMenu['routeName'])) ? route($subMenu['routeName']) : 'javascript:;'; ?>" <?php echo ($key == $activeSidebarSubMenu) ? 'class="nav-link active"' : 'class="nav-link"'; ?>>
                                                <i class="<?= $subMenu['icon']; ?>"></i>
                                                <span class="title">
                                                    {{__($subMenu['text']) }}
                                                </span>
                                            </a>
                                    <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>
*/ ?>
