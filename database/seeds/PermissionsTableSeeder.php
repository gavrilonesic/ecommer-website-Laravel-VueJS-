<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //parent 0
        collect([
        	[
            	'title' => 'Dashboard',
            	'permission_key' => 'dashboard',
            	'parent_id' => 0
            ],
            [
            	'title' => 'Products',
            	'permission_key' => 'manage-products',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'product-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-product',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-product',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-product',
	            	],
	            	[
	            		'title' => 'Import',
	            		'permission_key' => 'import-products',
	            	],
	            	[
	            		'title' => 'Export',
	            		'permission_key' => 'export-product',
	            	],
            	]
            ],
            [
            	'title' => 'Brands',
            	'permission_key' => 'manage-brands',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'brand-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-brand',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-brand',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-brand',
	            	]
            	]
            ],
            [
            	'title' => 'Categories',
            	'permission_key' => 'manage-categories',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'category-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-category',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-category',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-category',
	            	],
	            	[
	            		'title' => 'Import',
	            		'permission_key' => 'import-categories',
	            	],
	            	[
	            		'title' => 'Export',
	            		'permission_key' => 'export-category',
	            	],
            	]
            ],
            [
            	'title' => 'Attributes',
            	'permission_key' => 'manage-attributes',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'attribute-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-attribute',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-attribute',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-attribute',
	            	]
            	]
            ],
            [
            	'title' => 'Reviews',
            	'permission_key' => 'manage-reviews',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'review-listing',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-review',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-review',
	            	]
            	]
            ],
            [
            	'title' => 'Orders',
            	'permission_key' => 'manage-orders',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'order-listing',
	            	]
            	]
            ],
            [
            	'title' => 'Order Status',
            	'permission_key' => 'manage-order-status',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'order-status-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-order-status',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-order-status',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-order-status',
	            	]
            	]
            ],
            [
            	'title' => 'Admin Users',
            	'permission_key' => 'manage-users',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'user-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-user',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-user',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-user',
	            	]
            	]
            ],
            [
            	'title' => 'Customers',
            	'permission_key' => 'manage-customers',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'customer-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-customer',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-customer',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-customer',
	            	]
            	]
            ],
            [
            	'title' => 'Carousel',
            	'permission_key' => 'manage-carousel',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'carousel-listing',
	            	],
	            	[
	            		'title' => 'Add - Edit - Delete',
	            		'permission_key' => 'add-edit-delete-carousel',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-carousel',
	            	]
            	]
            ],
            [
            	'title' => 'Blogs',
            	'permission_key' => 'manage-blogs',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'blog-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-blog',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-blog',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-blog',
	            	]
            	]
            ],
            [
            	'title' => 'Blog Category',
            	'permission_key' => 'manage-blog-category',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'blog-category-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-blog-category',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-blog-category',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-blog-category',
	            	]
            	]
            ],
            [
            	'title' => 'CMS Pages',
            	'permission_key' => 'manage-cms-pages',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'cms-page-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-cms-page',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-cms-page',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-cms-page',
	            	]
            	]
            ],
            [
            	'title' => 'Testimonials',
            	'permission_key' => 'manage-testimonials',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'testimonial-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-testimonial',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-testimonial',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-testimonial',
	            	]
            	]
            ],
            [
            	'title' => 'Clients',
            	'permission_key' => 'manage-clients',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'client-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-client',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-client',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-client',
	            	]
            	]
            ],
            [
            	'title' => 'Banners',
            	'permission_key' => 'manage-banners',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'banner-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-banner',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-banner',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-banner',
	            	]
            	]
            ],
            [
            	'title' => 'Coupons',
            	'permission_key' => 'manage-coupons',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'coupon-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-coupon',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-coupon',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-coupon',
	            	]
            	]
            ],
            [
            	'title' => 'Videos',
            	'permission_key' => 'manage-videos',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'video-listing',
	            	],
	            	[
	            		'title' => 'Add',
	            		'permission_key' => 'add-video',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-video',
	            	],
	            	[
	            		'title' => 'Delete',
	            		'permission_key' => 'delete-video',
	            	]
            	]
            ],
            [
            	'title' => 'Emails',
            	'permission_key' => 'manage-emails',
            	'parent_id' => 0,
            	'child' => [
            		[
	            		'title' => 'Listing',
	            		'permission_key' => 'email-listing',
	            	],
	            	[
	            		'title' => 'Edit',
	            		'permission_key' => 'edit-email',
	            	],
	            	[
	            		'title' => 'Send Test Email',
	            		'permission_key' => 'send-test-email',
	            	],
	            	[
	            		'title' => 'Restore Default',
	            		'permission_key' => 'restore-default-email',
	            	]
            	]
            ],
            [
            	'title' => 'Settings',
            	'permission_key' => 'manage-settings',
            	'parent_id' => 0
            ],
        ])->each(function ($item, $key) {
        	$child = [];
        	if (isset($item['child'])) {
        		$child = $item['child'];
        		unset($item['child']);
        	}

            $permission = Permission::create($item);
            if (!empty($child)) {
            	$permission->childs()->createMany($child);
            }
        });
    }
}
