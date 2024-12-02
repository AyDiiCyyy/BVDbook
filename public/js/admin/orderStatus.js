$(document).ready(function () {
    // Hiển thị loading
    function showLoading() {
        $("#loading").css("display", "flex");
    }

    // Ẩn loading
    function hideLoading() {
        $("#loading").css("display", "none");
    }

    $(".status-select").change(function () {
        var selectElement = $(this);
        var orderId = selectElement.data("id");
        var status = selectElement.val();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        if (status == 6) {
            Swal.fire({
                title: "Xác nhận hủy đơn hàng",
                text: "Bạn có chắc chắn muốn hủy đơn hàng này không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Có",
                cancelButtonText: "Không",
            }).then((result) => {
                if (result.isConfirmed) {
                    processChangeStatus(
                        orderId,
                        status,
                        csrfToken,
                        selectElement
                    );
                } else {
                    selectElement.val(selectElement.data("current-status"));
                }
            });
        } else {
            processChangeStatus(orderId, status, csrfToken, selectElement);
        }
    });

    function processChangeStatus(orderId, status, csrfToken, selectElement) {
        // Hiển thị loading
        showLoading();

        $.ajax({
            url: changeStatusUrl, // Đảm bảo rằng `changeStatusUrl` được định nghĩa đúng
            type: "POST",
            data: {
                id: orderId,
                status: status,
                _token: csrfToken,
            },
            success: function (response) {
                hideLoading(); // Ẩn loading
                if (response.status) {
                    Swal.fire({
                        title: "Thành công!",
                        text: "Trạng thái đơn hàng đã được cập nhật thành công!",
                        icon: "success",
                        confirmButtonText: " OK",   
                    });
                    updateStatusSelect(selectElement, status);

                    // Kiểm tra nếu trạng thái mới là "Đã giao hàng" và trạng thái thanh toán là "Chưa thanh toán"
                    if (status == 4) {
                        // Nếu trạng thái mới là "Đã giao hàng"
                        // Cập nhật trạng thái thanh toán thành "Đã thanh toán"
                        selectElement.data("payment-status", 1); // Cập nhật trạng thái thanh toán
                        // Cập nhật giao diện người dùng
                        updatePaymentStatusDisplay(selectElement, 1);
                    }
                } else {
                    Swal.fire({
                        title: "Thất bại!",
                        text:
                            response.message ||
                            "Có lỗi xảy ra, vui lòng thử lại.",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                }
            },
            error: function (xhr, status, error) {
                hideLoading(); // Ẩn loading
                Swal.fire({
                    title: "Thất bại!",
                    text: "Có lỗi xảy ra, vui lòng thử lại.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
            },
        });
    }

    function updateStatusSelect(selectElement, currentStatus) {
        selectElement.empty();

        if (currentStatus == 1) {
            selectElement.append(
                '<option value="1" style="color: orange;" selected>Chờ xác nhận</option>'
            );
            selectElement.append(
                '<option value="2" style="color: blue;">Đang xử lý</option>'
            );
            selectElement.append(
                '<option value="5" style="color: red;">Chờ xác nhận hủy đơn</option>'
            );
        } else if (currentStatus == 2) {
            selectElement.append(
                '<option value="2" style="color: blue;" selected>Đang xử lý</option>'
            );
            selectElement.append(
                '<option value="3" style="color: green;">Đang giao hàng</option>'
            );
        } else if (currentStatus == 3) {
            selectElement.append(
                '<option value="3" style="color: green;" selected>Đang giao hàng</option>'
            );
            selectElement.append(
                '<option value="4" style="color: darkgreen;">Đã giao hàng</option>'
            );
        } else if (currentStatus == 4) {
            selectElement.append(
                '<option value="4" style="color: darkgreen;" selected>Đã giao hàng</option>'
            );
        } else if (currentStatus == 5) {
            selectElement.append(
                '<option value="5" style="color: red;" selected>Chờ xác nhận hủy đơn</option>'
            );
            selectElement.append(
                '<option value="6" style="color: gray;">Đã hủy</option>'
            );
        } else if (currentStatus == 6) {
            selectElement.append(
                '<option value="6" style="color: gray;" selected>Đã hủy</option>'
            );
        }
    }

    function updatePaymentStatusDisplay(selectElement, paymentStatus) {
        // Cập nhật giao diện người dùng để phản ánh trạng thái thanh toán
        var paymentStatusText =
            paymentStatus == 1 ? "Đã thanh toán" : "Chưa thanh toán";
        $("#payment-status-" + selectElement.data("id")).text(
            paymentStatusText
        );
    }
});
