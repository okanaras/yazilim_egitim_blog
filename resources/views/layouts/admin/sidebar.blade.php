<div class="app-sidebar">
    <div class="logo">
        <a href="{{ route('admin.index') }}">
            <img src="{{ asset($settings->logo) }}" alt="logo" class="img-fluid">
        </a>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">

            <li class="sidebar-title">
                Yazilim Egitim
            </li>

            <li>
                <a href="{{ route('admin.index') }}" class="{{ Route::is('admin.index') ? 'active' : '' }}">
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

            <li class="{{ Route::is('user.index') || Route::is('user.create') ? 'open' : '' }}">
                <a href="#" class="">
                    <i class="material-icons">person</i>
                    Kullanici Yonetimi
                    <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                </a>
                <ul class="sub-menu" style="">
                    <li>
                        <a href="{{ route('user.create') }}"
                            class="{{ Route::is('user.create') ? 'active' : '' }}">Kullanici Ekle</a>
                    </li>
                    <li>
                        <a href="{{ route('user.index') }}"
                            class="{{ Route::is('user.index') ? 'active' : '' }}">Kullanici Listesi</a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ $settings ? 'open'
                    : '' }}">
                <a href="#" class="">
                    <i class="material-icons">tune</i>
                    Email Yonetimi
                    <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                </a>
                <ul class="sub-menu" style="">
                    <li>
                        <a href="{{ route('admin.email-themes.create') }}"
                            class="{{ Route::is('admin.email-themes.create') ? 'active' : '' }}">Dogrulama Emaili</a>
                    </li>
                </ul>
            </li>

            <li class="{{ Route::is('settings') ? 'open' : '' }}">
                <a href="{{ route('settings') }}" class="">
                    <i class="material-icons-two-tone">settings</i>
                    Ayarlar
                </a>
            </li>

            <li class="{{ Route::is('dbLogs') ? 'open' : '' }}">
                <a href="{{ route('dbLogs') }}" class="">
                    <i class="material-icons-two-tone">settings</i>
                    Log Yonetimi
                </a>
            </li>

        </ul>
    </div>
</div>
