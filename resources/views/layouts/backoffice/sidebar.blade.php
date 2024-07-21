<div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
        <span class="app-brand-text demo menu-text fw-bolder"><span style="color: #696cff;">archives</span>.app</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
</div>

<div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item active">
        <a href="index.html" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    <!-- Layouts -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Pages</span>
    </li>
    {{-- documents --}}
    <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-file"></i>
            <div data-i18n="User interface">Documents</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('categories') }}" class="menu-link">
                    <div data-i18n="Accordion">Categories</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('documents.archiveShow', 1) }}" class="menu-link">
                    <div data-i18n="Accordion">Archives</div>
                </a>
            </li>
        </ul>
    </li>
    {{-- management users --}}
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
            <div data-i18n="Authentications">Management Accounts</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('users-index') }}" class="menu-link">
                    <div data-i18n="Basic">Management Users</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('edit-profile') }}" class="menu-link">
                    <div data-i18n="Basic">Account Setting</div>
                </a>
            </li>
        </ul>
    </li>


</ul>
