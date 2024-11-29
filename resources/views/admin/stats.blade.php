@extends('layouts.admin')
@section('css')
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
                {{-- Row thống kê trạng thái đơn hàng --}}
                <div class="row">
                    {{-- Đơn hàng chờ xác nhận --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3>{{ $pendingOrder }}</h3>
                                <p>Đơn hàng chờ xác nhận</p>
                            </div>
                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                style="background-color: #FF9800; border-radius: 50%; padding: 4px;">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 2.25a9.75 9.75 0 1 0 9.75 9.75A9.76 9.76 0 0 0 12 2.25zm0 18a8.25 8.25 0 1 1 8.25-8.25 8.26 8.26 0 0 1-8.25 8.25zm.375-13.5a.75.75 0 0 0-1.5 0v6a.75.75 0 0 0 .45.69l3.75 1.5a.75.75 0 1 0 .6-1.38l-3.3-1.32z">
                                </path>
                            </svg>
                        </div> <!--end::Small Box Widget 4-->
                    </div>
                    {{-- Đơn hàng đang giao --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-info">
                            <div class="inner">
                                <h3>{{ $shippingOrder }}</h3>
                                <p>Đơn hàng đang giao</p>
                            </div>
                            <!-- Biểu tượng vận chuyển -->
                            <svg class="small-box-icon" fill="#1976D2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                style="background-color: #BBDEFB; border-radius: 50%; padding: 6px;">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15 1a1 1 0 0 1 1 1v1h3a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-3v1a1 1 0 0 1-2 0v-1H9v1a1 1 0 0 1-2 0v-1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h3V1a1 1 0 0 1 2 0v1h6V1a1 1 0 0 1 1-1zm2 14V6h-2v9h2zm-4 0V6h-2v9h2zm-4 0V6H8v9h2zm-2 1h6v1H8v-1zM4 3v11h12V3H4z">
                                </path>
                            </svg>
                        </div> <!--end::Small Box Widget 1-->
                    </div>
                    {{-- Đơn hàng đã giao --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3>{{ $completedOrder }}</h3>
                                <p>Đơn hàng đã giao</p>
                            </div>
                            <!-- Biểu tượng dấu tích hoàn thành -->
                            <svg class="small-box-icon" fill="#4CAF50" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                style="background-color: #E8F5E9; border-radius: 50%; padding: 6px;">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9 16.62l-3.62-3.62a1 1 0 1 0-1.42 1.42l4 4a1 1 0 0 0 1.42 0l8-8a1 1 0 1 0-1.42-1.42L9 16.62z">
                                </path>
                            </svg>
                        </div> <!--end::Small Box Widget 2-->
                    </div>
                    {{-- Đơn hàng bị hủy --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3>{{ $canceledOrder }}</h3>
                                <p>Đơn hàng bị hủy</p>
                            </div>
                            <!-- Biểu tượng thùng rác (đơn hàng bị hủy) -->
                            <svg class="small-box-icon" fill="#D32F2F" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                style="background-color: #FFEBEE; border-radius: 50%; padding: 6px;">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M19 2.25h-3.75l-.75-1.5h-7.5l-.75 1.5H5a.75.75 0 0 0-.75.75v.75h16.5v-.75a.75.75 0 0 0-.75-.75zm-2.25 2.25h-11.25V3h11.25v1.5zM9 6.75h6v12a.75.75 0 0 1-.75.75h-4.5a.75.75 0 0 1-.75-.75V6.75zM6 6.75v12a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25V6.75a.75.75 0 0 0-.75-.75h-12a.75.75 0 0 0-.75.75z">
                                </path>
                            </svg>
                        </div> <!--end::Small Box Widget 3-->
                    </div>
                </div> <!--end::Row--> <!--begin::Row-->
                {{-- Row thống kê doanh thu theo ngày tháng năm --}}
                <div class="row ">
                    <div class="row mb-4 justify-content-center align-items-center">
                        <!-- Bộ lọc -->
                        <div class="col-md-4 d-flex flex-column align-items-center">
                            <label for="filter" class="form-label fw-bold">Lọc theo</label>
                            <select class="form-select w-75" id="filter">
                                <option value="default" id="filterDefault">Chọn Ngày/Tháng/Năm</option>
                                <option value="day">Ngày</option>
                                <option value="month">Tháng</option>
                                <option value="year">Năm</option>
                            </select>
                        </div>
                        <!-- Nhập ngày/tháng/năm -->
                        <div class="col-md-4 d-flex flex-column align-items-center">
                            <label id="dynamicLabel" class="form-label fw-bold">Chọn Ngày </label>
                            <input type="date" class="form-control w-75" id="dynamicInput">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" id="cartTitle">Doanh thu 14 ngày gần nhất </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="barChart" style=" width: 80%; height: 500px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Row thống kê sản phẩm theo danh mục và 10 sản phẩm chạy nhất --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Tỷ Lệ Sản Phẩm Bán Chạy </h5>
                            </div>
                            <div class="card-body d-flex align-items-center">
                                <!-- Label dọc -->
                                <div class="text-center fw-bold" style="writing-mode: vertical-rl;  ">
                                </div>
                                <canvas id="pieChart" style="width: 100%; height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Top 10 Sản Phẩm Bán Chạy Nhất</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Sản Phẩm</th>
                                            <th scope="col">Số Lượng Bán</th>
                                            <th scope="col">Tổng doanh thu sản phẩm </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bestSellerTop10 as $key => $render)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $render->product_name }}</td>
                                                <td>{{ $render->total_sold }}</td>
                                                <td>{{ number_format($render->total_revenue, 0, '.', '.') }}đ</td>
                                            </tr>
                                        @endforeach
                                        <!-- Dữ liệu mẫu -->


                                        <!-- Tiếp tục thêm các sản phẩm khác -->
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        $(document).ready(function() {
            const defaultLabels = @json($labels);
            const defaultRevenue = @json($revenue);

            if (defaultLabels && defaultRevenue) {
                updateBarChart({
                    labels: defaultLabels,
                    revenue: defaultRevenue
                });
            }

            $('#filter').change(function() {
                var filterValue = $(this).val();
                // Cập nhật label và kiểu input theo lựa chọn

                if (filterValue == 'day') {
                    $('#filterDefault').hide();
                    $('#cartTitle').text('Doanh thu theo ngày');
                    $('#dynamicLabel').text('Chọn Ngày');
                    $('#dynamicInput').attr('type', 'date').removeAttr('min max step');
                } else if (filterValue == 'month') {
                    $('#filterDefault').hide();
                    $('#cartTitle').text('Doanh thu theo tháng');
                    $('#dynamicLabel').text('Chọn Tháng');
                    $('#dynamicInput').attr('type', 'month').removeAttr('min max step');
                } else if (filterValue == 'year') {
                    $('#filterDefault').hide();
                    $('#cartTitle').text('Doanh thu theo năm');
                    $('#dynamicLabel').text('Chọn Năm');
                    $('#dynamicInput').attr('type', 'number')
                        .attr('min', '1900')
                        .attr('max', '2100')
                        .attr('step', '1')
                        .attr('placeholder', 'Nhập Năm');
                }
            });

            // Lắng nghe sự thay đổi của input
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
                            // Kiểm tra và gọi update biểu đồ với dữ liệu mới
                            if (response.labels && response.revenue) {
                                updateBarChart({
                                    labels: response
                                        .labels, // Dữ liệu các tháng hoặc ngày
                                    revenue: response.revenue // Dữ liệu doanh thu
                                });
                            } else {
                                alert("Không có dữ liệu cho khoảng thời gian này.");
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Vui lòng chọn lọc theo ngày/tháng/năm trước");
                            window.location.reload(); // Làm mới trang sau khi hiển thị lỗi
                        }
                    });
                } else {
                    alert("Vui lòng chọn cả ngày và lọc theo!");
                }
            });
        });
    </script>
    <script>
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
    <script>
        // Truyền dữ liệu từ PHP sang JavaScript
        const bestSellingPercentage = @json($bestSellingPercentage);
        const averageSellingPercentage = @json($averageSellingPercentage);
        const lowSellingPercentage = @json($lowSellingPercentage);
        // console.log(bestSellingPercentage, averageSellingPercentage, lowSellingPercentage);  

        // Dữ liệu cho biểu đồ tròn
        const labels = ['Nhiều (20)', 'Trung bình (6-19)', 'Ít  (5)'];
        const data = [bestSellingPercentage, averageSellingPercentage, lowSellingPercentage];

        // Dữ liệu mẫu cho biểu đồ tròn
        const pieData = {
            labels: labels,
            datasets: [{
                label: 'Tỷ lệ sản phẩm bán chạy ',
                data: data,
                backgroundColor: [
                    '#FFC1E3', // Màu cho nhóm bán chạy
                    '#81D4FA', // Màu cho nhóm trung bình
                    '#FFE082' // Màu cho nhóm ít bán
                ],
                borderColor: [
                    '#FF80AB',
                    '#29B6F6',
                    '#FFC107'
                ],
                borderWidth: 1
            }]
        };

        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: pieData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right', // Đặt chú thích ở bên phải
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const total = tooltipItem.chart.data.datasets[0].data.reduce((a, b) =>
                                    parseFloat(a) + parseFloat(b), 0);
                                const currentValue = tooltipItem.raw; // Giá trị phần tử hiện tại
                                const percentage = ((currentValue / total) * 100).toFixed(2);
                                return ` ${tooltipItem.label}: ${currentValue} (${percentage}%)`;
                            }
                        }
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            const total = ctx.chart.data.datasets[0].data.reduce((a, b) => parseFloat(a) +
                                parseFloat(b), 0);
                            const percentage = ((value / total) * 100).toFixed(2); // Tính tỷ lệ %
                            return value > 0 ? `${percentage}%` : null; // Hiển thị nếu giá trị > 0
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Sử dụng plugin ChartDataLabels
        });
    </script>
@endsection
