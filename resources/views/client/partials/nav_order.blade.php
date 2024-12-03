<nav>
    <div class="nav nav-pills">
        <a class="nav-link {{ Route::currentRouteName() == 'client.account.orders' ? 'active' : '' }}"
            href="{{ route('client.account.orders') }}">Tất cả</a>
        <a class="nav-link {{ Route::currentRouteName() == 'client.account.orders.waiting' ? 'active' : '' }}"
            href="{{ route('client.account.orders.waiting') }}">Chờ thanh toán</a>
        <a class="nav-link" href="{{ route('client.account.orders.transport') }}">Vận chuyển</a>
        <a class="nav-link" href="{{ route('client.account.orders.waitCancel') }}">Chờ xác nhận huỷ đơn</a>
        <a class="nav-link" href="{{ route('client.account.orders.complete') }}">Hoàn thành</a>
        <a class="nav-link" href="{{ route('client.account.orders.canceled') }}">Đã hủy</a>
    </div>
</nav>
