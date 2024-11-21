$(document).ready(function () {
    $('.status-select').change(function () {
        var userId = $(this).data('id');
        var status = $(this).val();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: changeActiveUrl,  // Sử dụng biến đã định nghĩa
            type: "POST",
            data: {
                id: userId,
                status: status,
                _token: csrfToken,
            },
            success: function (response) {
                if (response.active !== undefined) {
                    Swal.fire({
                        title: "Thành công!",
                        text: "Trạng thái đã được cập nhật thành công!",
                        icon: "success",
                        confirmButtonText: "OK",
                    });
                } else {
                    Swal.fire({
                        title: "Thất bại!",
                        text: "Có lỗi xảy ra, vui lòng thử lại.",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: "Thất bại!",
                    text: "Có lỗi xảy ra, vui lòng thử lại.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
            }
        });
    });
});