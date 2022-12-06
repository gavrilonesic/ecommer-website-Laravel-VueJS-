<?php

// Home Route based on URL
Breadcrumbs::register('EditAdmin', function ($breadcrumbs) {
    $breadcrumbs->push('messages.edit_admin');
});

Breadcrumbs::register('Brands', function ($breadcrumbs) {
    $breadcrumbs->push('messages.brands', route('brand.index'));
});

Breadcrumbs::register('AddBrand', function ($breadcrumbs) {
    $breadcrumbs->parent('Brands');
    $breadcrumbs->push('messages.add_brand');
});

Breadcrumbs::register('EditBrand', function ($breadcrumbs) {
    $breadcrumbs->parent('Brands');
    $breadcrumbs->push('messages.edit_brand');
});

Breadcrumbs::register('Reviews', function ($breadcrumbs) {
    $breadcrumbs->push('messages.reviews', route('review.index'));
});

Breadcrumbs::register('AddReview', function ($breadcrumbs) {
    $breadcrumbs->parent('Reviews');
    $breadcrumbs->push('messages.add_review');
});

Breadcrumbs::register('EditReview', function ($breadcrumbs) {
    $breadcrumbs->parent('Reviews');
    $breadcrumbs->push('messages.edit_review');
});

Breadcrumbs::register('Blogs', function ($breadcrumbs) {
    $breadcrumbs->push('messages.blogs', route('blog.index'));
});

Breadcrumbs::register('AddBlog', function ($breadcrumbs) {
    $breadcrumbs->parent('Blogs');
    $breadcrumbs->push('messages.add_blog');
});

Breadcrumbs::register('EditBlog', function ($breadcrumbs) {
    $breadcrumbs->parent('Blogs');
    $breadcrumbs->push('messages.edit_blog');
});

Breadcrumbs::register('BlogCategory', function ($breadcrumbs) {
    $breadcrumbs->push('messages.blogcategory', route('blogcategory.index'));
});

Breadcrumbs::register('AddBlogCategory', function ($breadcrumbs) {
    $breadcrumbs->parent('BlogCategory');
    $breadcrumbs->push('messages.add_blog_category');
});

Breadcrumbs::register('EditBlogCategory', function ($breadcrumbs) {
    $breadcrumbs->parent('BlogCategory');
    $breadcrumbs->push('messages.edit_blog_category');
});

Breadcrumbs::register('Categories', function ($breadcrumbs) {
    $breadcrumbs->push('messages.categories', route('category.index'));
});

Breadcrumbs::register('AddCategory', function ($breadcrumbs) {
    $breadcrumbs->parent('Categories');
    $breadcrumbs->push('messages.add_category');
});

Breadcrumbs::register('EditCategory', function ($breadcrumbs) {
    $breadcrumbs->parent('Categories');
    $breadcrumbs->push('messages.edit_category');
});

Breadcrumbs::register('ImportCategory', function ($breadcrumbs) {
    $breadcrumbs->parent('Categories');
    $breadcrumbs->push('messages.import_categories');
});

Breadcrumbs::register('Attributes', function ($breadcrumbs) {
    $breadcrumbs->push('messages.attributes', route('attribute.index'));
});

Breadcrumbs::register('AddAttribute', function ($breadcrumbs) {
    $breadcrumbs->parent('Attributes');
    $breadcrumbs->push('messages.add_attribute');
});

Breadcrumbs::register('EditAttribute', function ($breadcrumbs) {
    $breadcrumbs->parent('Attributes');
    $breadcrumbs->push('messages.edit_attribute');
});

Breadcrumbs::register('Products', function ($breadcrumbs) {
    $breadcrumbs->push('messages.products', route('product.index'));
});

Breadcrumbs::register('AddProduct', function ($breadcrumbs) {
    $breadcrumbs->parent('Products');
    $breadcrumbs->push('messages.add_product');
});

Breadcrumbs::register('EditProduct', function ($breadcrumbs) {
    $breadcrumbs->parent('Products');
    $breadcrumbs->push('messages.edit_product');
});

Breadcrumbs::register('ImportProduct', function ($breadcrumbs) {
    $breadcrumbs->parent('Products');
    $breadcrumbs->push('messages.import_products');
});

Breadcrumbs::register('Banners', function ($breadcrumbs) {
    $breadcrumbs->push('messages.banners', route('banner.index'));
});

Breadcrumbs::register('AddBanner', function ($breadcrumbs) {
    $breadcrumbs->parent('Banners');
    $breadcrumbs->push('messages.add_banner');
});

Breadcrumbs::register('EditBanner', function ($breadcrumbs) {
    $breadcrumbs->parent('Banners');
    $breadcrumbs->push('messages.edit_banner');
});

Breadcrumbs::register('Coupons', function ($breadcrumbs) {
    $breadcrumbs->push('messages.coupons', route('coupon.index'));
});

Breadcrumbs::register('AddCoupon', function ($breadcrumbs) {
    $breadcrumbs->parent('Coupons');
    $breadcrumbs->push('messages.add_coupon');
});

Breadcrumbs::register('EditCoupon', function ($breadcrumbs) {
    $breadcrumbs->parent('Coupons');
    $breadcrumbs->push('messages.edit_coupon');
});

Breadcrumbs::register('Carousels', function ($breadcrumbs) {
    $breadcrumbs->push('messages.carousels', route('carousel.index'));
});

Breadcrumbs::register('AddCarousel', function ($breadcrumbs) {
    $breadcrumbs->parent('Carousels');
    $breadcrumbs->push('messages.add_carousel');
});

Breadcrumbs::register('EditCarousel', function ($breadcrumbs) {
    $breadcrumbs->parent('Carousels');
    $breadcrumbs->push('messages.edit_carousel');
});

Breadcrumbs::register('Customers', function ($breadcrumbs) {
    $breadcrumbs->push('messages.customers', route('customer.index'));
});

Breadcrumbs::register('AddCustomer', function ($breadcrumbs) {
    $breadcrumbs->parent('Customers');
    $breadcrumbs->push('messages.add_customer');
});

Breadcrumbs::register('EditCustomer', function ($breadcrumbs) {
    $breadcrumbs->parent('Customers');
    $breadcrumbs->push('messages.edit_customer');
});

Breadcrumbs::register('CmsPages', function ($breadcrumbs) {
    $breadcrumbs->push('messages.cms_pages', route('cms_page.index'));
});

Breadcrumbs::register('AddCmsPage', function ($breadcrumbs) {
    $breadcrumbs->parent('CmsPages');
    $breadcrumbs->push('messages.add_cms_page');
});

Breadcrumbs::register('EditCmsPage', function ($breadcrumbs) {
    $breadcrumbs->parent('CmsPages');
    $breadcrumbs->push('messages.edit_cms_page');
});

Breadcrumbs::register('Testimonials', function ($breadcrumbs) {
    $breadcrumbs->push('messages.testimonials', route('testimonial.index'));
});

Breadcrumbs::register('AddTestimonial', function ($breadcrumbs) {
    $breadcrumbs->parent('Testimonials');
    $breadcrumbs->push('messages.add_testimonial');
});

Breadcrumbs::register('EditTestimonial', function ($breadcrumbs) {
    $breadcrumbs->parent('Testimonials');
    $breadcrumbs->push('messages.edit_testimonial');
});

Breadcrumbs::register('Clients', function ($breadcrumbs) {
    $breadcrumbs->push('messages.clients', route('client.index'));
});

Breadcrumbs::register('AddClient', function ($breadcrumbs) {
    $breadcrumbs->parent('Clients');
    $breadcrumbs->push('messages.add_client');
});

Breadcrumbs::register('EditClient', function ($breadcrumbs) {
    $breadcrumbs->parent('Clients');
    $breadcrumbs->push('messages.edit_client');
});

Breadcrumbs::register('AdminUsers', function ($breadcrumbs) {
    $breadcrumbs->push('messages.admin_users', route('user.index'));
});

Breadcrumbs::register('AddAdminUser', function ($breadcrumbs) {
    $breadcrumbs->parent('AdminUsers');
    $breadcrumbs->push('messages.add_admin_user');
});

Breadcrumbs::register('EditAdminUser', function ($breadcrumbs) {
    $breadcrumbs->parent('AdminUsers');
    $breadcrumbs->push('messages.edit_admin_user');
});

Breadcrumbs::register('Videos', function ($breadcrumbs) {
    $breadcrumbs->push('messages.videos', route('video.index'));
});
Breadcrumbs::register('AddVideo', function ($breadcrumbs) {
    $breadcrumbs->parent('Videos');
    $breadcrumbs->push('messages.add_video');
});
Breadcrumbs::register('EditVideo', function ($breadcrumbs) {
    $breadcrumbs->parent('Videos');
    $breadcrumbs->push('messages.edit_video');
});

Breadcrumbs::register('Emails', function ($breadcrumbs) {
    $breadcrumbs->push('messages.emails', route('email.index'));
});
Breadcrumbs::register('EditEmail', function ($breadcrumbs) {
    $breadcrumbs->parent('Emails');
    $breadcrumbs->push('messages.edit_email');
});
