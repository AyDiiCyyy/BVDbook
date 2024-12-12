@extends('layouts.admin')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
@endsection
@section('content')
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Thống Kê</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Thống kê
                            </li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content Header--> <!--begin::App Content-->
        <div class="app-content"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                {{-- Row Lọc --}}
                <div class="row">
                    <div class="row mb-4 ">
                        <!-- Bộ lọc -->
                        <div class="col-2">
                            <label for="filter" class="form-label fw-bold text-uppercase">Lọc theo</label>
                            <select class="form-select w-100 fw-bold" id="filter">
                                <option value='default' id="optionDefault"> Chọn Thể Loại Lọc</option>
                                <option value="14day">14 ngày gần nhất</option>
                                <option value="day">Ngày</option>
                                <option value="month">Tháng</option>
                                <option value="year">Năm</option>
                                <option value="changeTime">Tùy chỉnh thời gian</option>
                            </select>
                        </div>
                        <!-- Nhập ngày/tháng/năm -->
                        <div class="col-2" id="optionDate">
                            <label id="dynamicLabel" class="form-label fw-bold text-uppercase">Chọn Ngày </label>
                            <input type="date" class="form-control w-100" id="dynamicInput">
                        </div>
                        <div class="col-2" id="fromDate">
                            <label id="startDateLabel" class="form-label fw-bold text-uppercase">Từ Ngày </label>
                            <input type="date" class="form-control w-100" id="startDate">
                        </div>
                        <div class="col-2" id="toDate">
                            <label id="endDateLabel" class="form-label fw-bold text-uppercase">Đến Ngày </label>
                            <input type="date" class="form-control w-100" id="endDate">
                        </div>
                    </div>
                </div>
                {{-- Row doanh thu --}}
                <div class="row">
                    {{-- Tổng doanh thu đơn hàng --}}
                    <div class="col-lg-4 col-6">
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3> {{ number_format($revenueTotal, 0, '.', '.') ?? 0 }} VNĐ </h3>
                                <p class="fw-bold"> Tổng doanh thu đơn hàng</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="small-box-icon" viewBox="0 0 512 512">
                                <path fill="#FFD43B"
                                    d="M512 80c0 18-14.3 34.6-38.4 48c-29.1 16.1-72.5 27.5-122.3 30.9c-3.7-1.8-7.4-3.5-11.3-5C300.6 137.4 248.2 128 192 128c-8.3 0-16.4 .2-24.5 .6l-1.1-.6C142.3 114.6 128 98 128 80c0-44.2 86-80 192-80S512 35.8 512 80zM160.7 161.1c10.2-.7 20.7-1.1 31.3-1.1c62.2 0 117.4 12.3 152.5 31.4C369.3 204.9 384 221.7 384 240c0 4-.7 7.9-2.1 11.7c-4.6 13.2-17 25.3-35 35.5c0 0 0 0 0 0c-.1 .1-.3 .1-.4 .2c0 0 0 0 0 0s0 0 0 0c-.3 .2-.6 .3-.9 .5c-35 19.4-90.8 32-153.6 32c-59.6 0-112.9-11.3-148.2-29.1c-1.9-.9-3.7-1.9-5.5-2.9C14.3 274.6 0 258 0 240c0-34.8 53.4-64.5 128-75.4c10.5-1.5 21.4-2.7 32.7-3.5zM416 240c0-21.9-10.6-39.9-24.1-53.4c28.3-4.4 54.2-11.4 76.2-20.5c16.3-6.8 31.5-15.2 43.9-25.5l0 35.4c0 19.3-16.5 37.1-43.8 50.9c-14.6 7.4-32.4 13.7-52.4 18.5c.1-1.8 .2-3.5 .2-5.3zm-32 96c0 18-14.3 34.6-38.4 48c-1.8 1-3.6 1.9-5.5 2.9C304.9 404.7 251.6 416 192 416c-62.8 0-118.6-12.6-153.6-32C14.3 370.6 0 354 0 336l0-35.4c12.5 10.3 27.6 18.7 43.9 25.5C83.4 342.6 135.8 352 192 352s108.6-9.4 148.1-25.9c7.8-3.2 15.3-6.9 22.4-10.9c6.1-3.4 11.8-7.2 17.2-11.2c1.5-1.1 2.9-2.3 4.3-3.4l0 3.4 0 5.7 0 26.3zm32 0l0-32 0-25.9c19-4.2 36.5-9.5 52.1-16c16.3-6.8 31.5-15.2 43.9-25.5l0 35.4c0 10.5-5 21-14.9 30.9c-16.3 16.3-45 29.7-81.3 38.4c.1-1.7 .2-3.5 .2-5.3zM192 448c56.2 0 108.6-9.4 148.1-25.9c16.3-6.8 31.5-15.2 43.9-25.5l0 35.4c0 44.2-86 80-192 80S0 476.2 0 432l0-35.4c12.5 10.3 27.6 18.7 43.9 25.5C83.4 438.6 135.8 448 192 448z" />
                            </svg>
                        </div> <!--end::Small Box Widget 4-->
                    </div>
                    {{-- Người dùng đăng ký  --}}
                    <div class="col-lg-4 col-6">
                        <div class="small-box text-bg-primary text-black">
                            <div class="inner">
                                <h3 id="registerUser"></h3>
                                <p class="fw-bold" id="registerUserLabel"></p>
                            </div>
                            <svg class="small-box-icon" fill="#1976D2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                style="background-color: #BBDEFB; border-radius: 50%; padding: 4px;">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                </path>
                            </svg>
                        </div> <!--end::Small Box Widget 1-->
                    </div>
                    {{-- Doanh thu theo lọc --}}
                    <div class="col-lg-4 col-6">
                        <div class="small-box " style="background-color:#FFA500;">
                            <div class="inner">
                                <div class="inner">
                                    <h3 id="revenueValue"></h3>
                                    <p class="fw-bold" id="revenueLabel"></p>
                                </div>
                            </div>
                            <!-- Biểu tượng đồ thị liên quan đến doanh thu với hình nền thay đổi -->
                            <svg class="small-box-icon" fill="#FFB300" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                style="background-color: #FFF3E0; border-radius: 50%; padding: 4px;">
                                <path
                                    d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                                </path>
                            </svg>

                        </div> <!--end::Small Box Widget 2-->
                    </div>
                </div>
                {{-- Row Trạng thái --}}
                <div class="row">
                    {{-- Đơn hàng chờ xác nhận --}}
                    <div class="col-lg-4 col-6">
                        <div class="small-box" style="background-color: #FFEB3B;">
                            <div class="inner">
                                <h3 id="pendingOrder"></h3>
                                <p class="fw-bold" id="pendingOrderLabel"></p>
                            </div>
                            <!-- Biểu tượng đồng hồ (biểu tượng chờ xác nhận) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="small-box-icon" viewBox="0 0 512 512">
                                <path fill="#FFD43B"
                                    d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                            </svg>
                        </div> <!--end::Small Box Widget-->
                    </div>
                    {{-- Đơn hàng đang xử lý --}}
                    <div class="col-lg-4 col-6">
                        <div class="small-box " style="background-color: #64B5F6;">
                            <div class="inner">
                                <h3 id="orderProcessing"></h3>
                                <p class="fw-bold" id="orderProcessingLabel"></p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="small-box-icon">
                                <path fill="#74C0FC"
                                    d="M0 336c0 79.5 64.5 144 144 144l368 0c70.7 0 128-57.3 128-128c0-61.9-44-113.6-102.4-125.4c4.1-10.7 6.4-22.4 6.4-34.6c0-53-43-96-96-96c-19.7 0-38.1 6-53.3 16.2C367 64.2 315.3 32 256 32C167.6 32 96 103.6 96 192c0 2.7 .1 5.4 .2 8.1C40.2 219.8 0 273.2 0 336z" />
                            </svg>

                        </div> <!--end::Small Box Widget-->
                    </div>
                    {{-- Đơn hàng chờ xác nhận hủy --}}
                    <div class="col-lg-4 col-6">
                        <div class="small-box text-bg-danger">
                            <div class="inner text-black">
                                <h3 id="cancelConfirmOrder"></h3>
                                <p class="fw-bold " id="cancelConfirmOrderLabel"></p>
                            </div>
                            <!-- Biểu tượng dấu chéo (hủy bỏ) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="small-box-icon" viewBox="0 0 384 512">
                                <path fill="#F28282"
                                    d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64l0 11c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437l0 11c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 256 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-11c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1l0-11c17.7 0 32-14.3 32-32s-14.3-32-32-32L320 0 64 0 32 0zM96 75l0-11 192 0 0 11c0 19-5.6 37.4-16 53L112 128c-10.3-15.6-16-34-16-53zm16 309c3.5-5.3 7.6-10.3 12.1-14.9L192 301.3l67.9 67.9c4.6 4.6 8.6 9.6 12.1 14.9L112 384z" />
                            </svg>
                        </div> <!--end::Small Box Widget-->
                    </div>
                </div>
                {{-- Biểu đồ --}}
                <div class="row ">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" id="cartTitle">Doanh thu 14 ngày gần nhất</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="barChart" style=" width: 100%; height: 523px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0 " id="cartTitleTop10"></h5>
                                </div>
                                <div class="card-body d-flex align-items-center">
                                    <!-- Label dọc -->
                                    <div class="text-center fw-bold" style="writing-mode: vertical-rl;  ">
                                    </div>
                                    <canvas id="pieChart" style="width: 100%; height: 500px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- Row Bảngg 10 sản phẩm chạy nhất --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0 " id="bestSellerLabel"></h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Sản Phẩm</th>
                                            <th scope="col"> Bán</th>
                                            <th scope="col">Tổng doanh thu sản phẩm </th>
                                        </tr>
                                    </thead>
                                    <tbody id="best-seller-table">
                                        <!-- Nội dung sẽ được chèn qua JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--end::App Content-->
    </main>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right", // Vị trí thông báo
            "timeOut": "3000", // Thời gian hiển thị thông báo (7 giây)
        };

        $(document).ready(function() {
            const defaultLabels = @json($labels);
            const defaultRevenue = @json($revenue);
            const defaultRegisterUser = @json($registerUser);
            const defaultPendingOrder = @json($pendingOrder);
            const defaultOrderProcessing = @json($orderProcessing);
            const defaultCancelConfirm = @json($cancelConfirm);
            const defaultBestSellerTop10 = @json($bestSellerTop10);
            const defaultCompletedOrder = @json($completedOrder);
            const defaultCancelOrder = @json($cancelOrder);
            $('#optionDate').hide();
            $('#fromDate').hide();
            $('#toDate').hide();
            // Hiển thị mặc định khi chưa lọc
            if (defaultLabels && defaultRevenue) {
                updateBarChart({
                    labels: defaultLabels,
                    revenue: defaultRevenue
                });
                updateRevenueInfo(defaultRevenue, 'Doanh thu 14 ngày gần nhất');
                updateRegisterUser(defaultRegisterUser, 'Người dùng đăng ký');
                pendingOrder(defaultPendingOrder, 'Đơn hàng chờ xác nhận');
                orderProcessing(defaultOrderProcessing, 'Đơn hàng đang xử lý')
                cancelConfirm(defaultCancelConfirm, 'Đơn hàng chờ xác nhận hủy');
                generateBestSellerTable(defaultBestSellerTop10, 'Top 10 sản phẩm bán chạy');
            }
            // **Thêm biểu đồ tròn khi lọc**
            if (defaultCompletedOrder !== undefined && defaultCancelOrder !== undefined) {
                rateCompletedAndCancel(defaultCompletedOrder, defaultCancelOrder,
                    'Tỷ lệ đơn hàng đã giao và đã hủy')
            }

            // 14 ngày xử lý AJAX
            $('#filter').change(function() {
                var filterValue = $(this).val();
                // Cập nhật label và kiểu input theo lựa chọn
                if (filterValue == '14day') {
                    $('#cartTitle').text('Doanh thu 14 ngày gần nhất');
                    $('#optionDefault').hide();
                    $('#optionDate').hide();
                    $('#fromDate').hide();
                    $('#toDate').hide();

                    // Gửi AJAX lấy dữ liệu 14 ngày gần nhất
                    $.ajax({
                        url: '{{ route('admin.statistic.getRevenue') }}',
                        method: 'POST',
                        data: {
                            filter: filterValue,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.labels && response.revenue) {
                                updateBarChart({
                                    labels: response.labels,
                                    revenue: response.revenue,
                                });
                                updateRevenueInfo(response.revenue, filterValue);
                            }
                            if (response.registerUser !== undefined) {
                                updateRegisterUser(response.registerUser, filterValue);
                            }
                            if (response.pendingOrder !== undefined) {
                                pendingOrder(response.pendingOrder, filterValue);
                            }
                            if (response.orderProcessing !== undefined) {
                                orderProcessing(response.orderProcessing, filterValue);
                            }

                            if (response.cancelConfirm !== undefined) {
                                cancelConfirm(response.cancelConfirm, filterValue);
                            }
                            if (response.bestSellerTop10 !== undefined) {
                                generateBestSellerTable(response.bestSellerTop10, filterValue);
                            }
                            if (response.completedOrder !== undefined && response
                                .cancelOrder !== undefined) {
                                rateCompletedAndCancel(response.completedOrder, response
                                    .cancelOrder, filterValue);
                            }

                            toastr.success('Dữ liệu doanh thu đã được cập nhật thành công!');
                        },
                        error: function() {
                            toastr.error("Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.");
                        }
                    });
                } else if (filterValue == 'day') {
                    $('#cartTitle').text('Doanh thu theo ngày ').show();
                    $('#optionDefault').hide();
                    $('#dynamicLabel').text('Chọn Ngày').show();
                    $('#dynamicInput').attr('type', 'date').removeAttr('min max step').show();
                    $('#optionDate').show();
                    $('#fromDate').hide();
                    $('#toDate').hide();
                } else if (filterValue == 'month') {
                    $('#cartTitle').text('Doanh thu theo tháng').show();
                    $('#optionDefault').hide();
                    $('#dynamicLabel').text('Chọn Tháng').show();
                    $('#dynamicInput').attr('type', 'month').removeAttr('min max step').show();
                    $('#optionDate').show();
                    $('#fromDate').hide();
                    $('#toDate').hide();
                } else if (filterValue == 'year') {
                    $('#cartTitle').text('Doanh thu theo năm').show();
                    $('#dynamicLabel').text('Chọn Năm').show();
                    $('#optionDefault').hide();
                    $('#dynamicInput').attr('type', 'number')
                        .attr('min', '1900')
                        .attr('max', '2100')
                        .attr('step', '1')
                        .attr('placeholder', 'Nhập Năm').show();
                    $('#optionDate').show();
                    $('#fromDate').hide();
                    $('#toDate').hide();
                } else if (filterValue == 'changeTime') {
                    $('#cartTitle').text('Doanh thu theo khoảng thời gian');
                    $('#optionDefault').hide();
                    $('#optionDate').hide();
                    $('#fromDate').show();
                    $('#toDate').show();
                }
            });

            // Ngày - Tháng - Năm xử lý AJAX
            $('#dynamicInput').change(function() {
                const filter = $('#filter').val();
                const date = $('#dynamicInput').val();
                if (filter && date) {
                    $.ajax({
                        url: '{{ route('admin.statistic.getRevenue') }}',
                        method: 'POST',
                        data: {
                            filter: filter,
                            date: $('#dynamicInput').val(),
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.labels && response.revenue) {
                                updateBarChart({
                                    labels: response.labels,
                                    revenue: response.revenue
                                });
                                updateRevenueInfo(response.revenue, filter);
                            }
                            if (response.registerUser !== undefined) {
                                updateRegisterUser(response.registerUser, filter);
                            }
                            if (response.pendingOrder !== undefined) {
                                pendingOrder(response.pendingOrder, filter);
                            }

                            if (response.orderProcessing !== undefined) {
                                orderProcessing(response.orderProcessing, filter);
                            }
                            if (response.cancelConfirm !== undefined) {
                                cancelConfirm(response.cancelConfirm, filter);
                            }
                            if (response.bestSellerTop10 !== undefined) {
                                generateBestSellerTable(response.bestSellerTop10, filter);
                            }
                            if (response.completedOrder !== undefined && response
                                .cancelOrder !== undefined) {
                                rateCompletedAndCancel(response.completedOrder, response
                                    .cancelOrder, filter);
                            }
                            toastr.success(
                                'Dữ liệu doanh thu đã được cập nhật thành công!');
                        },
                        error: function(xhr, status, error) {
                            toastr.error("Vui lòng chọn lọc theo ngày - tháng - năm trước");
                            window.location.reload(); // Làm mới trang sau khi hiển thị lỗi
                        }
                    });
                } else {
                    toastr.error("Vui lòng chọn cả ngày và lọc theo!");
                }
            });
            $('#startDate, #endDate').change(function() {
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();
                const filter = $('#filter').val();
                const today = new Date(); // Lấy ngày hiện tại
                const startDateObj = new Date(startDate); // Chuyển đổi startDate sang đối tượng Date
                const endDateObj = new Date(endDate); // Chuyển đổi endDate sang đối tượng Date
                // Kiểm tra nếu endDate lớn hơn hôm nay
                if (endDateObj  > today) {
                    $('#endDate').val();
                    toastr.error('Ngày kết thúc không được lớn hơn ngày hiện tại!');
                    return;
                }
                if (startDateObj  > today) {
                    $('#startDate').val();
                    toastr.error('Ngày bắt đầu không được lớn hơn ngày hiện tại!');
                    return;
                }
                // Kiểm tra nếu startDate lớn hơn endDate
                if (startDateObj > endDateObj) {
                    toastr.error('Ngày bắt đầu không được lớn hơn ngày kết thúc!');
                    return;
                }
                if (startDate && endDate) {
                    $.ajax({                      
                        url: '{{ route('admin.statistic.getRevenue') }}',
                        method: 'POST',
                        data: {
                            filter: filter,
                            startDate: startDate,
                            endDate: endDate,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.labels && response.revenue) {
                                updateBarChart({
                                    labels: response.labels,
                                    revenue: response.revenue,
                                });
                                updateRevenueInfo(response.revenue, filter);
                            }
                            if (response.registerUser !== undefined) {
                                updateRegisterUser(response.registerUser,filter);
                            }
                            if (response.pendingOrder !== undefined) {
                                pendingOrder(response.pendingOrder, filter);
                            }
                            if (response.orderProcessing !== undefined) {
                                orderProcessing(response.orderProcessing,filter);
                            }
                            if (response.cancelConfirm !== undefined) {
                                cancelConfirm(response.cancelConfirm,filter);
                            }
                            if (response.bestSellerTop10 !== undefined) {
                                generateBestSellerTable(response.bestSellerTop10,filter);
                            }
                            if (response.completedOrder !== undefined && response.cancelOrder !==undefined) {
                                rateCompletedAndCancel(response.completedOrder, response.cancelOrder,filter);
                            }
                            toastr.success('Dữ liệu đã được cập nhật thành công!');
                        },
                        error: function() {
                            toastr.error('Đã xảy ra lỗi. Vui lòng thử lại.');
                        }
                    });
                } 
            });
        });
        // Top 10 Best Seller
        function generateBestSellerTable(data, filter) {
            let label = '';
            switch (filter) {
                case 'day':
                    label = 'Top 10 sản phẩm bán chạy theo ngày';
                    break;
                case 'month':
                    label = 'Top 10 sản phẩm bán chạy theo tháng';
                    break;
                case 'year':
                    label = 'Top 10 sản phẩm bán chạy theo năm';
                    break;
                case '14day':
                    label = 'Top 10 sản phẩm bán chạy 14 ngày gần nhất';
                    break;
                case 'changeTime':
                    label = 'Top 10 sản phẩm bán chạy khoảng thời gian';
                    break;
                default:
                    label = 'Top 10 sản phẩm bán chạy ';
                    break;
            }
            // Thêm tiêu đ�� và dữ liệu
            document.querySelector("#bestSellerLabel").innerText = label;
            let tableBody = document.querySelector("tbody");
            tableBody.innerHTML = ""; // Clear previous rows
            if (!data || data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='4' >Không có dữ liệu</td></tr>";
                return;
            }

            // Thêm dữ liệu vào bảng
            data.forEach((item, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                                    <th scope="row">${index + 1}</th>
                                    <td>${item.product_name}</td>
                                    <td>${item.total_sold}</td>
                                    <td>${item.total_revenue.toLocaleString()}đ</td>
                                `;
                tableBody.appendChild(row);
            });
        }
        // Cập nhật tổng doanh thu và nhãn
        function updateRevenueInfo(revenueData, filter) {
            if (!Array.isArray(revenueData) || revenueData.length === 0) {
                $('#revenueLabel').text('Doanh thu');
                $('#revenue').text('0đ');
                return; // Kết thúc hàm nếu không có dữ liệu
            }
            let totalRevenue = revenueData.reduce((sum, value) => sum + parseFloat(value), 0);
            // Đặt nhãn dựa trên filter
            let label = '';

            switch (filter) {
                case 'day':
                    label = 'Doanh thu theo ngày';
                    break;
                case 'month':
                    label = 'Doanh thu theo tháng';
                    break;
                case 'year':
                    label = 'Doanh thu theo năm';
                    break;
                case '14day':
                    label = 'Doanh thu 14 ngày gần nhất';
                    break;
                case 'changeTime':
                    label = 'Doanh thu theo khoảng thời gian';
                    break;
                default:
                    label = 'Doanh thu 14 ngày gần nhất';
                    break;
            }

            // Cập nhật nhãn vào phần tử p
            $('#revenueLabel').text(label);

            // Cập nhật tổng doanh thu vào phần tử h3
            $('#revenueValue').text(totalRevenue.toLocaleString() + ' VNĐ');
        }
        // Người dùng đăng ký 
        function updateRegisterUser(registerUser, filter) {
            // Kiểm tra xem countStatus có hợp lệ không
            if (registerUser === undefined || registerUser === null) {
                registerUser = 0; // Nếu không có dữ liệu, gán mặc định là 0
            }

            // Đặt nhãn dựa trên filter
            let label = '';

            switch (filter) {
                case 'day':
                    label = 'Người dùng đăng ký theo ngày';
                    break;
                case 'month':
                    label = 'Người dùng đăng ký theo tháng';
                    break;
                case 'year':
                    label = 'Người dùng đăng ký theo năm';
                    break;
                case '14day':
                    label = 'Người dùng đăng ký 14 ngày gần nhất';
                    break;
                case 'changeTime':
                    label = 'Người dùng đăng ký khoảng thời gian ';
                    break;
                default:
                    label = 'Người dùng đăng ký';
                    break;
            }
            $('#registerUserLabel').text(label);
            $('#registerUser').text(registerUser);
        }
        // Trạng thái đang xác nhận
        function pendingOrder(countStatus, filter) {
            let label = '';
            // Kiểm tra xem countStatus có hợp lệ không
            if (countStatus === undefined || countStatus === null) {
                countStatus = 0; // Nếu không có dữ liệu, gán mặc định là 0
            }
            switch (filter) {
                case 'day':
                    label = 'Đơn hàng chờ xác nhận theo ngày';
                    break;
                case 'month':
                    label = 'Đơn hàng chờ xác nhận theo tháng';
                    break;
                case 'year':
                    label = 'Đơn hàng chờ xác nhận theo năm';
                    break;
                case '14day':
                    label = 'Đơn hàng chờ xác nhận 14 ngày gần nhất';
                    break;
                case 'changeTime':
                    label = 'Đơn hàng chờ xác nhận khoảng thời gian ';
                    break;
                default:
                    label = 'Đơn hàng chờ xác nhận ';
                    break;
            }
            $('#pendingOrderLabel').text(label);
            $('#pendingOrder').text(countStatus);
        }
        // Trạng thái đang xử lý
        function orderProcessing(countStatus, filter) {
            let label = '';
            if (countStatus === undefined || countStatus === null) {
                countStatus = 0; // Nếu không có dữ liệu, gán mặc định là 0
            }
            switch (filter) {
                case 'day':
                    label = 'Đơn hàng đang xử lý theo ngày';
                    break;
                case 'month':
                    label = 'Đơn hàng đang xử lý theo tháng';
                    break;
                case 'year':
                    label = 'Đơn hàng đang xử lý theo năm';
                    break;
                case '14day':
                    label = 'Đơn hàng đang xử lý 14 ngày gần nhất';
                    break;
                case 'changeTime':
                    label = 'Đơn hàng đang xử lý khoảng thời gian ';
                    break;
                default:
                    label = 'Đơn hàng đang xử lý';
                    break;
            }
            $('#orderProcessingLabel').text(label);
            $('#orderProcessing').text(countStatus);
        }
        // Trạng thái chờ xác nhận và hủy    
        function cancelConfirm(countStatus, filter) {
            let label = '';
            if (countStatus === undefined || countStatus === null) {
                countStatus = 0; // Nếu không có dữ liệu, gán mặc định là 0
            }
            switch (filter) {
                case 'day':
                    label = 'Đơn hàng chờ xác nhận hủy theo ngày';
                    break;
                case 'month':
                    label = 'Đơn hàng chờ xác nhận hủy theo tháng';
                    break;
                case 'year':
                    label = 'Đơn hàng chờ xác nhận hủy theo năm';
                    break;
                case '14day':
                    label = 'Đơn hàng chờ xác nhận hủy 14 ngày gần nhất';
                    break;
                case 'changeTime':
                    label = 'Đơn hàng chờ xác nhận hủy khoảng thời gian ';
                    break;
                default:
                    label = 'Đơn hàng chờ xác nhận hủy';
                    break;
            }
            $('#cancelConfirmOrderLabel').text(label);
            $('#cancelConfirmOrder').text(countStatus);
        }
        let currentChart = null;
        // Tính tỷ lệ đã giao và đã hủy
        function rateCompletedAndCancel(completed, cancelled, filter) {
            let label = '';
            // Kiểm tra và gán giá trị mặc định cho các biến nếu không xác định
            completed = completed ?? 0;
            cancelled = cancelled ?? 0;
            // Gán nhãn tùy theo giá trị filter
            switch (filter) {
                case 'day':
                    label = 'Tỷ lệ đơn hàng đã giao và đã hủy theo ngày';
                    break;
                case 'month':
                    label = 'Tỷ lệ đơn hàng đã giao và đã hủy theo tháng';
                    break;
                case 'year':
                    label = 'Tỷ lệ đơn hàng đã giao và đã hủy theo năm';
                    break;
                case '14day':
                    label = 'Tỷ lệ đơn hàng đã giao và đã hủy 14 ngày gần nhất';
                    break;
                case 'changeTime':
                    label = 'Tỷ lệ đơn hàng đã giao và đã hủy khoảng thời gian';
                    break;
                default:
                    label = 'Tỷ lệ đơn hàng đã giao và đã hủy';
                    break;
            }
            // Thay đổi nội dung của cartTitleTop10 sử dụng jQuery
            $('#cartTitleTop10').text(label);

            // Tính toán tổng số đơn hàng và phần trăm
            const totalOrders = completed + cancelled;
            const completedPercentage = totalOrders > 0 ? ((completed / totalOrders) * 100).toFixed(2) : 0;
            const cancelledPercentage = totalOrders > 0 ? ((cancelled / totalOrders) * 100).toFixed(2) : 0;

            // Gọi hàm tạo biểu đồ hoặc hiển thị thông tin
            createPieChart('pieChart', {
                labels: ['Đã giao', 'Đã hủy'],
                data: [completed, cancelled],
                colors: ['#66BB6A', '#FF5252'], // Không có khoảng trắng thừa
                borderColors: ['#388E3C', '#D32F2F'], // Màu đường viền
                title: label, // Tiêu đề biểu đồ
                percentages: [completedPercentage, cancelledPercentage] // Chuyển phần trăm vào biểu đồ nếu cần
            });
        }

        // Hàm tạo biểu đồ tròn
        function createPieChart(canvasId, {
            labels,
            data,
            colors,
            borderColors,
            title
        }) {
            // Nếu biểu đồ đã tồn tại, phá hủy nó
            if (currentChart) {
                currentChart.destroy();
            }

            const ctx = document.getElementById(canvasId).getContext('2d');
            currentChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: colors,
                        borderColor: borderColors,
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const total = tooltipItem.chart.data.datasets[0].data.reduce((a, b) =>
                                        parseFloat(a) + parseFloat(b), 0);
                                    const currentValue = tooltipItem.raw;
                                    const percentage = ((currentValue / total) * 100).toFixed(2);
                                    return `${tooltipItem.label}: ${currentValue} (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: { // Đây là nơi plugin Data Labels hoạt động
                            formatter: (value, ctx) => {
                                const total = ctx.chart.data.datasets[0].data.reduce((a, b) => parseFloat(a) +
                                    parseFloat(b), 0);
                                const percentage = ((value / total) * 100).toFixed(2);
                                return value > 0 ? `${percentage}%` : null;
                            },
                            color: '#fff',
                            font: {
                                weight: 'bold',
                                size: 14
                            }
                        }

                    }
                },
                plugins: [ChartDataLabels] // Sử dụng plugin ChartDataLabels

            });
        }
        //Biều đồ cột
        function updateBarChart(data) {
            const ctxBar = document.getElementById('barChart').getContext('2d');

            // Nếu biểu đồ đã tồn tại, phá hủy nó và tạo lại
            if (window.barChartInstance) {
                window.barChartInstance.destroy();
            }

            // Tạo biểu đồ mới với dữ liệu nhận được
            window.barChartInstance = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: data.labels, // Ví dụ: ['Jan', 'Feb', 'Mar']
                    datasets: [{
                        label: 'Doanh thu Đơn Hàng',
                        data: data.revenue, // Dữ liệu doanh thu
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    }],

                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endsection
