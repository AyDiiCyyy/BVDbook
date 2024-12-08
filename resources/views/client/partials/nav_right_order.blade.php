<div class="col-md-3">
    <div class="list-group">
        <a href="{{ route('my-account') }}" class="list-group-item list-group-item-action">Hồ Sơ</a>
        <a href="{{ route('client.account.update-profile') }}"
            class="list-group-item list-group-item-action">Thông Tin</a>
        <a href="{{ route('client.account.orders') }}" class="list-group-item list-group-item-action">Đơn
            Hàng</a>
        <a href="{{ route('voucher') }}" class="list-group-item list-group-item-action">Voucher</a>
        <a
            href="{{ route('client.account.change-password.form') }}"class="list-group-item list-group-item-action">Đổi
            Mật Khẩu</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <a href="#" class="btn btn-danger mt-3"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a>
    </div>
</div>