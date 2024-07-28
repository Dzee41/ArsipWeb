<ul class="nav nav-pills flex-column flex-md-row mb-3">
    <li class="nav-item">
        <a class="nav-link {{ $currentRouteName == 'edit-profile' || $currentRouteName == 'edit-user-profile' ? 'active' : '' }}"
            href="{{ route('edit-profile') }}"><i class="bx bx-user me-1"></i>
            Account</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $currentRouteName == 'change_password' ? 'active' : '' }}"
            href="{{ route('change_password') }}"><i class="bx bx-bell me-1"></i>
            Change Password</a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('forgot_password') }}"><i class="bx bx-bell me-1"></i>
            Forgot Password</a>
    </li> --}}
</ul>
