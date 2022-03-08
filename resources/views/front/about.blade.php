
@extends('layouts.front.app')

@section('content')

<div class="breadcrumb-area water-effect jquery-ripples">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h1 class="page-title">{{__('About Coponoo')}}</h1>
                    <ul class="page-list">
                        <li><a href="{{route('home.front' , app()->getLocale())}}">{{__('Home')}}</a><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                        <li>{{__('About Coponoo')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner area end-->

<div class="contact-page pd-bottom-100">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-sm-12">
                <div class="section-title mb-0 pb-5 {{app()->getLocale() == 'ar' ? 'text-align:right' : 'text-align:left'}} ">
                    <h2 class="title">{{__('About us?')}}</h2>
                    <p>{{__('COPONOO is a company specialized in E-commerce in general and affiliate marketing in particular, as it has its own product, also markets various products for other companies, operates within the Egyptian market and is subject to laws within the Arab Republic of Egypt.')}}</p>
                </div>
            </div>


            <div class="col-lg-12 col-sm-12">
                <div class="section-title mb-0 pb-5 {{app()->getLocale() == 'ar' ? 'text-align:right' : 'text-align:left'}} ">
                    <h2 class="title">{{__('Vision')}}</h2>
                    <p>{{__('COPONOO LOOKS FORWARD TO LEADING THE FIELD OF E-COMMERCE WITHIN EGYPT IN THE NEXT FIVE YEARS AND OPENING SEVERAL MARKETS WITHIN THE ARAB REGION.')}}</p>
                </div>
            </div>

            <div class="col-lg-12 col-sm-12">
                <div class="section-title mb-0 pb-5 {{app()->getLocale() == 'ar' ? 'text-align:right' : 'text-align:left'}} ">
                    <h2 class="title">{{__('Mission')}}</h2>
                    <p>{{__('COPONOO seeks to develop the sales process electronically by cooperating with fast delivery shipping companies, paying attention to the quality of the products offered to its customers, and training the largest number of marketers who seek to achieve satisfactory profit effectively without compromising the quality of the sales process for the end consumer. It also seeks to attract the largest number of merchants and companies with popular and diverse high-')}}</p>
                </div>
            </div>

            <div class="col-lg-12 col-sm-12">
                <div class="section-title mb-0 pb-5 {{app()->getLocale() == 'ar' ? 'text-align:right' : 'text-align:left'}} ">
                    <h2 class="title">{{__('Values')}}</h2>
                    <ul style="{{app()->getLocale() == 'ar' ?
                    'text-align: right;
                        float: right;
                        direction: rtl;' : ''}}" class="pl-list-inner style-1">
                        <li><i style="padding-left: 10px" class="fa fa-check"></i>{{__('COPONOO\'s top priority is customer satisfaction (final consumer marketers)')}}</li>
                        <li><i style="padding-left: 10px" class="fa fa-check"></i>{{__('Credibility and honesty in dealing and mastering the work.')}}</li>
                        <li><i style="padding-left: 10px" class="fa fa-check"></i>{{__('Working to spread the spirit of one team between employees and customers of COPONOO.')}}</li>
                        <li><i style="padding-left: 10px" class="fa fa-check"></i>{{__('Investing human energies and working to develop the skills of COPONOO employees.')}}</li>
                        <li><i style="padding-left: 10px" class="fa fa-check"></i>{{__('SPREADING AWARENESS TO SERVE THE HOMELAND AND ITS CITIZENS.')}}</li>
                        <li><i style="padding-left: 10px" class="fa fa-check"></i>{{__('Justice, order and self-esteem among COPONOO employees.')}}</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-12 col-sm-12">
                <div class="section-title mb-0 pb-5 {{app()->getLocale() == 'ar' ? 'text-align:right' : 'text-align:left'}} ">
                    <h2 class="title">{{__('Social responsibility')}}</h2>
                    <p>{{__('Coponoo PARTICIPATES IN THE EGYPTIAN LABOR MARKET, BECAUSE OF ITS SOCIAL RESPONSIBILITY TO CONTRIBUTE TO THE DEVELOPMENT OF THE MODERN EGYPTIAN ECONOMY, PROVIDE JOB OPPORTUNITIES FOR THE YOUTH OF THE COUNTRY, AND DEVELOP THE MENTAL IMAGE OF THE END CONSUMER ABOUT THE FIELD OF AFFILIATE MARKETING.')}}</p>
                </div>
            </div>


        </div>
    </div>
</div>




@endsection
