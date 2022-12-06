@extends('front.layouts.app')
@section('content')
<div class="container">
    <h1 class="text-center mb-4">Become a Distributor</h1>
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
        <p>General Chemical Corp. is looking for distributors and partners.</p>
        <p>
            Distributors have access to our entire product line throughout multiple different industries.<br>
            We can supply with our General Chemical Corp labels or work together for private branding opportunities.
        </p>

        <p>
            Our wide range of packaging capabilities allow us to fill liquid products for numerous clients, as well as ship in single to bulk case quantities.<br>
            Along with outstanding product quality, we can support your endeavors with a variety of marketing, logistic and development services.
        </p>

        <p>Some of the various services we offer include:</p>

        <ul class="bulleted-list">
            <li>Product formulation by our in-house and consultant chemists.
            </li>
            <li>Quality control to insure your product will meet your customer’s specifications.</li>
            <li>Turnkey order distribution from our factory in Brighton, Michigan. Our proximity to Canada allows for convenient exporting.</li>
            <li>Drop - ship order fulfillment.</li>
            <li>We will work with you to identify the appropriate product for your customers' applications. Depending on the opportunity, the research team can create a custom product that will provide the best possible performance for your target market.</li>
        </ul>

        <p>If you have special surface protection related needs, we can still help. Our experienced chemists are available to formulate products especially for your applications. We have done this numerous times for our customers, and will be happy to do it for you.</p>

        <p>By partnering with us, you leverage OUR capacity to develop, manufacture, and technically support leading edge products with your company’s experience in sales, marketing and customer service in the markets that you know best. As our partner, you can enjoy the benefits of our experience and capabilities without having to create an extensive infrastructure within your company.</p>

        <p>Under your company’s brand, our products will help give you the technical edge to stand above your competitors in the marketplace.</p>

        <p>These products will help you meet your customers' needs by providing outstanding performance while maintaining the highest standard of heath, safety, and environmental stewardship, at a competitive price.</p>

        <p>If you are interested in learning more about our distribution or private label opportunities, please fill out the below form and we will contact you shortly.</p> 
            <form action="{{ route('become_a_distributor.store') }}" id="become-a-distributor-form" method="POST">
                @csrf
                
                <input type="text" class="form-control" name="name" placeholder="Name*">
                @include('front.error.validation_error', ['field' => 'name'])

                <input type="email" class="form-control" name="email" placeholder="Email*">
                @include('front.error.validation_error', ['field' => 'email'])

                <input type="text" class="form-control" name="company_name" placeholder="Company Name">
                @include('front.error.validation_error', ['field' => 'company_name'])

                <input type="text" class="form-control" name="state" placeholder="State">
                @include('front.error.validation_error', ['field' => 'state'])

                <input type="tel" class="form-control" name="phone" placeholder="Phone*">
                @include('front.error.validation_error', ['field' => 'phone'])

                <textarea class="form-control" name="product_interest" placeholder="Product Interest"></textarea>
                @include('front.error.validation_error', ['field' => 'product_interest'])

                <button class="btn" type="submit">Send</button>
            </form>
        </div>
    </div>

</div>

@endsection

@section('script')
{!! JsValidator::formRequest('App\Http\Requests\BecomeADistributorFormRequest', '#become-a-distributor-form') !!}
@endsection