<?php

namespace App\Http\Controllers\Front;

use App\Banner;
use App\Category;
use App\CategoryInquiry;
use App\Country;
use App\Http\Requests\CategoryInquiryRequest;
use App\Http\Controllers\Front\FrontController;
use App\Product;
use SEOMeta;
use OpenGraph;
use App\Email;
use Session;

class CategoryController extends FrontController
{
    public function getChildCategories($categorySlug)
    {
        $category = Category::with(['childs' => function ($query) {
            $query->orderBy('name', 'asc');
            $query->active()->with(['childs' => function ($query) {
                $query->active();
                $query->orderBy('name', 'asc');
            }]);
        }, 'medias' => function ($query) {
            $query->where('collection_name', 'logo');
        }, 'childs.medias' => function ($query) {
            $query->where('collection_name', 'category');
        }, 'parent.medias' => function ($query) {
            $query->where('collection_name', 'logo');
        }])->active()->orderBy('name', 'asc')->where('slug', $categorySlug)->firstOrFail();

        $parentCategory = Category::where('parent_id', $category->parent_id)->orderBy('name', 'asc')->active()->get();

        $products = Product::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })
        ->with(['brand', 'medias' => function ($query) {
            $query->whereJsonContains('custom_properties->default_image', true);
        }])->active()->select('id', 'name', 'brand_id', 'slug', 'price', 'short_description', 'mark_as_new', 'mark_as_featured')
        ->paginate(12);

        $compareProductList = Product::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->Active()->select('id', 'name', 'custom_fields')->whereJsonLength('custom_fields', '>', 0)->get()->toArray();

        $compareProductFields = [];
        $productApplication   = false;
        foreach ($compareProductList as &$value) {
            $customFields = [];
            foreach (json_decode($value['custom_fields'], true) as $key => $row) {
                $key = strtolower(trim($key));
                if ($key == "application") {
                    $productApplication = true;
                }
                if (!in_array($key, $compareProductFields)) {
                    $compareProductFields[] = $key;
                }
                foreach ($row as $val) {
                    $customFields[$key] = isset($customFields[$key]) ? ", " . $val : $val;
                }
            }
            $value['custom_fields'] = $customFields;
        }

        $topBanner = Banner::getBannerOnFront(config('constants.BANNER_TYPE.FULL_WIDTH'), config('constants.BANNER_POSITION.TOP'), 'for_specific_category', $category->id);
        if ($topBanner->count() > 0) {
            $topBanner = $topBanner->random(1)->first();
        }

        $leftSideBanner = Banner::getBannerOnFront(config('constants.BANNER_TYPE.SMALL_WIDTH'), config('constants.BANNER_POSITION.LEFT'), 'for_specific_category', $category->id);
        if ($leftSideBanner->count() > 0) {
            $leftSideBanner = $leftSideBanner->random(1)->first();
        }

        SEOMeta::setTitle($category->page_title ?? $category->name);
        SEOMeta::setDescription($category->meta_tag_description ?? $category->short_description);
        SEOMeta::setKeywords($category->meta_tag_keywords ?? $category->name);
        if (!empty($category->getMedia('category')) && $category->getMedia('category')->count() > 0) {
            OpenGraph::addImage($category->getMedia('category')->first()->getFullUrl());
        }elseif(!empty($category->medias) && $category->medias->count() > 0) {
            OpenGraph::addImage($category->medias()->first()->getFullUrl());
        }
        // dd($category->template_layout);
        return view('front.category.' . $category->template_layout, compact('category', 'parentCategory', 'products', 'topBanner', 'compareProductList', 'compareProductFields', 'productApplication', 'leftSideBanner'));
    }

    public function getCategoryInquiryForm($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $country = Country::pluck('name','id');
        return view('front.category.category_inquiry',compact('country','category'));
    }


    public function postCategoryInquiryForm(CategoryInquiryRequest $request,$categorySlug)
    {
        try{
            $category = Category::where('slug', $categorySlug)->firstOrFail();

            $data = $request->all();
            $data['category_id'] = $category->id;
            $contact = CategoryInquiry::create($data);
            $country = Country::where('id', $contact->country)->firstOrFail();
            $placeHolders = [
                '[Customer First Name]'      => $contact->first_name ?? '',
                '[Customer Last Name]'      => $contact->last_name ?? '',
                '[Customer Company Name]'      => $contact->company_name ?? '',
                '[Customer Email]'     => $contact->email ?? '',
                '[Customer Telephone]' => $contact->phone ?? '',
                '[Customer Street Address]' => $contact->street_address ?? '',
                '[Customer Address Line 2]' => $contact->address_line_2 ?? '',
                '[Customer City]' => $contact->city ?? '',
                '[Customer State]'   => $contact->state ?? '',
                '[Customer Zipcode]'   => $contact->zipcode ?? '',
                '[Customer Country]'   => $country->name ?? '',
                '[Customer Process Time]'   => $contact->process_time ?? '',
                '[Customer Temperature]'   => $contact->temperature ?? '',
                '[Customer Concentration]'   => $contact->concentration ?? '',
                '[Customer SOAK]'   => $contact->soak ?? '',
                '[Customer Reference]'   => $contact->reference ?? '',
                '[Customer Special Requirement]'   => $contact->special_requirements ?? '',
                '[Customer Comments]'   => $contact->comments ?? '',
            ];

            // Email to Admin
            if ($category->email != NULL) {
                Email::sendEmail('admin.category_enquiry', $placeHolders, $category->email);
            } else {
                Email::sendEmail('admin.category_enquiry', $placeHolders, setting('email'));
            }

            Email::sendEmail('customer.category_enquiry', $placeHolders, $contact->email ?? '');

            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.enquiry_submission')]));

            return redirect()->back();

        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error', __('messages.record_add_error_msg', ['name' => __('messages.enquiry_submission')]));
        }
        
    }
}
