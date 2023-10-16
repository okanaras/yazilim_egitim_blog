<div class="app-sidebar">
    <div class="logo">
        <a href="{{ route('admin.index') }}" class="logo-icon"><span class="logo-text">Neptune</span></a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="{{ route('admin.index') }}">
                <img src="{{ asset('assets/admin/images/avatars/avatar.png') }}">
                <span class="activity-indicator"></span>
                {{-- <span class="user-info-text">Chloe<br><span class="user-state-info">On a call</span></span> --}}
                <span class="user-info-text">User: <br><span
                        class="user-state-info">{{ auth()->user()->name }}</span></span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Apps
            </li>
            <li class="{{ Route::is('admin.index') ? 'open' : '' }}">
                <a href="{{ route('admin.index') }}">
                    <i class="material-icons-two-tone">dashboard</i>
                    Dashboard
                </a>
            </li>
            <li
                class="{{ Route::is('article.index') ||
                Route::is('article.create') ||
                Route::is('artical.comment.list') ||
                Route::is('artical.pending-approval')
                    ? 'open'
                    : '' }}">
                <a href="#" class="">
                    <i class="material-icons">tune</i>
                    Makale Yonetimi
                    <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                </a>
                <ul class="sub-menu" style="">
                    <li>
                        <a href="{{ route('article.create') }}"
                            class="{{ Route::is('article.create') ? 'active' : '' }}">Makale
                            Ekle</a>
                    </li>
                    <li>
                        <a href="{{ route('article.index') }}"
                            class="{{ Route::is('article.index') ? 'active' : '' }}">Makale
                            Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('artical.comment.list') }}"
                            class="{{ Route::is('artical.comment.list') ? 'active' : '' }}">
                            Yorum Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('artical.pending-approval') }}"
                            class="{{ Route::is('artical.pending-approval') ? 'active' : '' }}">Onay Bekleyen
                            Yorumlar</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Route::is('category.index') || Route::is('category.create') ? 'open' : '' }}">
                <a href="#" class="">
                    <i class="material-icons">tune</i>
                    Kategori Yonetimi
                    <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                </a>
                <ul class="sub-menu" style="">
                    <li>
                        <a href="{{ route('category.create') }}"
                            class="{{ Route::is('category.create') ? 'active' : '' }}">Kategori Ekle</a>
                    </li>
                    <li>
                        <a href="{{ route('category.index') }}"
                            class="{{ Route::is('category.index') ? 'active' : '' }}">Kategori Listesi</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Route::is('settings') ? 'open' : '' }}">
                <a href="{{ route('settings') }}" class="">
                    <i class="material-icons-two-tone">settings</i>
                    Ayarlar
                </a>
            </li>
        </ul>
    </div>
</div>
