@extends('client.partials.menu')

@section('title')
    Liên Hệ
@endsection

@section('content')
    <!-- Breadcrumb Area start -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-hrading">Liên Hệ</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="index.html">Trang chủ</a></li>
                            <li>Liên Hệ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Area End -->
    <!-- contact area start -->
    <div class="contact-area mtb-60px">
        <div class="container">
            <div class="custom-row-2">
                <div class="col-lg-4 col-md-5">
                    <div class="contact-info-wrap">
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="contact-info-dec">
                                <p>0234 555 677</p>
                                <p>0988 777 477</p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="contact-info-dec">
                                <p><a href="#">bvdbook@email.com</a></p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="contact-info-dec">
                                <p>Tòa nhà FPT Polytechnic, Cổng số 2,</p>
                                <p> 13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</p>
                            </div>
                        </div>
                        <div class="contact-social">
                            <h3>Theo Dõi chúng tôi </h3>
                            <div class="social-info">
                                <ul>
                                    <li>
                                        <a href="#"><i class="ion-social-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="ion-social-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="ion-social-youtube"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="ion-social-google"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="ion-social-instagram"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                   <div>
                        <div id="map">
                            <div class="mapouter">
                                <div class="gmap_canvas">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8639311820675!2d105.74468687508111!3d21.0381297806135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1732166399525!5m2!1svi!2s" 
                                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    <a href="https://sites.google.com/view/maps-api-v2/mapv2"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="static-area-wrap">

                <div class="row">
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                        <div class="single-static pb-res-md-0 pb-res-sm-0 pb-res-xs-0">
                            <img src="{{ asset('client/assets/images/icons/static-icons-1.png') }}" alt=""
                                class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Miễn phí vận chuyển</h4>
                                <p>Cho tất cả đơn hàng trên 500.000</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                        <div class="single-static pb-res-md-0 pb-res-sm-0 pb-res-xs-0 pt-res-xs-20">
                            <img src="{{ asset('client/assets/images/icons/static-icons-2.png') }}" alt=""
                                class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Trả hàng miễn phí</h4>
                                <p>Trả hàng miễn phí trong vòng 5 ngày</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                        <div class="single-static pt-res-md-30 pb-res-sm-30 pb-res-xs-0 pt-res-xs-20">
                            <img src="{{ asset('client/assets/images/icons/static-icons-3.png') }}" alt=""
                                class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>Thanh toán an toàn 100%</h4>
                                <p>Thanh toán của bạn sẽ an toàn với chúng tôi</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                    <!-- Static Single Item Start -->
                    <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                        <div class="single-static pt-res-md-30 pb-res-sm-30 pt-res-xs-20">
                            <img src="{{ asset('client/assets/images/icons/static-icons-4.png') }}" alt=""
                                class="img-responsive" />
                            <div class="single-static-meta">
                                <h4>hỗ trợ liên hệ 24/7</h4>
                                <p>Liên hệ với chúng tôi qua điện thoại</p>
                            </div>
                        </div>
                    </div>
                    <!-- Static Single Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- contact area end -->
@endsection
