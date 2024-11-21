@extends('client.layouts')

@section('title')
    Giới Thiệu
@endsection

@section('content')
    <!-- Breadcrumb Area Start -->
    <section class="breadcrumb-area" style="background-color:rgb(215, 229, 229)">
        <div class="container" style="margin-top: -50px">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-hrading">Giới Thiệu</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="{{ url('/') }}">Trang Chủ</a></li>
                            <li>Giới Thiệu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Area End -->

    <!-- About Area Start -->
    <section class="about-area" style="margin-top: -100px; background-color:rgb(215, 229, 229)">
        <div class="container" >
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="{{ asset('client/assets/images/about.jpg') }}" alt="Giới thiệu"
                            class="img-fluid rounded shadow" width="600px" height="400px" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2>Chào Mừng Đến Với BVD Book</h2>
                        <p class="mt-4">
                            BVD Book là nơi mang đến những cuốn sách hay và ý nghĩa, giúp bạn khám phá tri thức và giải trí
                            trong thế giới sách phong phú. Chúng tôi cam kết mang lại trải nghiệm mua sắm tốt nhất với
                            các dịch vụ và sản phẩm chất lượng cao với định hướng: đưa tri thức tới mọi tầng lớp nhân dân,
                            nâng tầm tri thức Việt.
                        </p>
                        <p>
                            Từ các tác phẩm văn học kinh điển đến sách kỹ năng, hay những tiểu thuyết trinh thám, ngôn tình,
                            chúng tôi luôn cố gắng cập nhật những
                            đầu sách mới nhất để phục vụ mọi đối tượng độc giả.
                        </p>
                        <br>
                        <p>
                            Hiện tại, BVD Book tự hào là đơn vị tiên phong trong việc ứng dụng công
                            nghệ cao trong triển khai và phân phối nhiều thể loại ở Việt Nam, Chúng tôi sở hữu nền tảng công
                            nghệ hiện đại và đội ngũ phát triển sản phẩm chất lượng cao, đảm bảo
                            xây dựng nền tảng xuất bản tiên tiến, đáp ứng mọi nhu cầu đọc của người dùng từ tìm kiếm nội
                            dung đến trải nghiệm đọc sách, truyện tranh     trên bất cứ thiết bị di
                            động thông minh nào, ngay cả khi không có kết nối Internet.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="single-about text-center">
                        <img src="{{ asset('client/assets/images/about1.jpg') }}" alt="Công ty" class="mb-3" width="350px"/>
                        <h4>Công Ty</h4>
                        <p>
                            BVD Book được thành lập từ năm 2024 với mục tiêu là cầu nối giữa tác giả, dịch giả, nhà xuất bản
                            và bạn
                            đọc, kho nội dung của chúng tôi liên tục được cung cấp và cập nhật các nội dung số đa dạng giúp
                            nâng
                            cao văn hóa đọc của người Việt và mang đến một phong cách đọc sách hiện đại, tiện ích hơn.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-about text-center">
                        <img src="{{ asset('client/assets/images/about2.jpg') }}" alt="Đội ngũ" class="mb-3" width="350px"/>
                        <h4>Đội Ngũ</h4>
                        <p>
                            Chúng tôi sở hữu nền tảng công nghệ hiện đại và đội ngũ phát triển sản phẩm chất lượng cao,
                            đội ngũ nhân viên tận tâm và chuyên nghiệp luôn sẵn sàng hỗ trợ bạn trong hành trình khám phá
                            những cuốn sách tuyệt vời.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-about text-center">
                        <img src="{{ asset('client/assets/images/about3.jpg') }}" alt="Khách hàng"
                            class="mb-3"  width="350px"/>
                        <h4>Khách Hàng</h4>
                        <p>
                            Hơn 10,000 khách hàng tin tưởng sử dụng dịch vụ của chúng tôi mỗi năm là minh chứng rõ ràng
                            cho sự hài lòng và chất lượng của BVD Book.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Area End -->
@endsection
