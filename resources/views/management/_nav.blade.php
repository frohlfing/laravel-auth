@can('manage-users')
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item {{ is_active('admin/users') ? 'active' : '' }}" href="{{ url('admin/users') }}">
            <i class="fas fa-user-plus"></i> {{ __('auth::nav.management') }}
        </a>
    </div>
@endcan