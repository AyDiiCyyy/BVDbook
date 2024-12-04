<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="./index.html" class="brand-link">
            <!--begin::Brand Image--> <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text--> <span
                class="brand-text fw-light">AdminLTE 4</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div>
    <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.statistic.index') }}" class="nav-link "> <i
                            class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Thống kê
                            {{-- <i class="nav-arrow bi bi-chevron-right"></i> --}}
                        </p>
                    </a>

                </li>
                <li class="nav-item"> <a href="#" class="nav-link "> <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Danh mục
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('admin.category.index') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Danh sách</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{ route('admin.category.create') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Thêm mới</p>
                            </a>



                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-archive"></i>
                        <p>
                            Sản phẩm
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('admin.product.index') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        <li class="nav-item"> <a href="{{ route('admin.product.create') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Thêm mới</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link "> <i class="nav-icon bi bi-ticket-perforated-fill"></i>
                        <p>
                            Vouchers
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('admin.voucher.index') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        <li class="nav-item"> <a href="{{ route('admin.voucher.create') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Thêm mới</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"> <i class="nav-icon bi bi-person-circle"></i>
                        <p>
                            Người dùng
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('admin.user.index') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Danh sách người dùng</p>
                            </a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"> <i class="nav-icon bi bi-bag-check"></i>
                        <p>
                            Đơn hàng
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('admin.order.index') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Danh sách đơn hàng</p>
                            </a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"> 
                        <i class="nav-icon bi bi-chat-left"></i> 
                        <p>
                            Quản lí bình luận
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.comments.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Danh sách bình luận</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Slide
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('admin.slide.index') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        <li class="nav-item"> <a href="{{ route('admin.slide.create') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Thêm mới</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->
