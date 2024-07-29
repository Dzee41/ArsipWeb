<div class="app-brand demo">
    <a href="{{ route('home') }}" class="app-brand-link">
        <span class="app-brand-text demo menu-text fw-bolder"><span style="color: #696cff;">archives</span>.app</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
</div>

<div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    <!-- Layouts -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Pages</span>
    </li>
    {{-- documents --}}
    <li 
        class="menu-item {{ request()->routeIs('categories') || 
            request()->routeIs('documents.archivesIndexAll') || 
            request()->routeIs('documents.archiveShow') ||
            request()->routeIs('new-document') ||
            request()->routeIs('edit-archive.editArchive') ||
            request()->routeIs('file.preview')
            ? 'active open' : '' }}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-file"></i>
            <div data-i18n="User interface">Documents</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('categories') ? 'active' : '' }}">
                <a href="{{ route('categories') }}" class="menu-link">
                    <div data-i18n="Accordion">Categories</div>
                </a>
            </li>
            <li 
                class="menu-item {{ request()->routeIs('documents.archivesIndexAll') || 
                    request()->routeIs('documents.archiveShow') ||
                    request()->routeIs('new-document') ||
                    request()->routeIs('edit-archive.editArchive') ||
                    request()->routeIs('file.preview')
                    ? 'active' : '' }}">
                <a href="{{ route('documents.archivesIndexAll') }}" class="menu-link">
                    <div data-i18n="Accordion">Archives</div>
                </a>
            </li>
        </ul>
    </li>
    @if ( auth()->user()->role_id == "1" )
    {{-- management users --}}
    <li 
        class="menu-item {{ request()->routeIs('users-index') || 
            request()->routeIs('create-user') ||
            request()->routeIs('edit-profile') ||
            request()->routeIs('change_password') ||
            request()->routeIs('edit-user-profile') 
            ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
            <div data-i18n="Authentications">Management Accounts</div>
        </a>
        <ul class="menu-sub">
            <li 
                class="menu-item {{ request()->routeIs('users-index') ||
                    request()->routeIs('create-user') ||
                    request()->routeIs('edit-user-profile')
                    ? 'active' : '' }}">
                <a href="{{ route('users-index') }}" class="menu-link">
                    <div data-i18n="Basic">Management Users</div>
                </a>
            </li>
            <li 
                class="menu-item {{ request()->routeIs('edit-profile') ||
                    request()->routeIs('change_password') 
                    ? 'active' : '' }}">
                <a href="{{ route('edit-profile') }}" class="menu-link">
                    <div data-i18n="Basic">Account Setting</div>
                </a>
            </li>
        </ul>
    </li>  
    @endif


</ul>
