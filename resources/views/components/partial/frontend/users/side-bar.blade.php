<div class="wn__sidebar">

    <!-- Start Single Widget -->
    <aside class="widget recent_widget">
            <ul>
                <li class="list-group-item">
                    {{-- <img src="{{ asset('') }}" alt=""> --}}
                </li>
                <li class="list-group-item"><a href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a></li>
                <li class="list-group-item"><a href="{{ route('user.create.post') }}">{{ __('Create Post') }}</a></li>
                <li class="list-group-item"><a href="{{ route('user.comments') }}">{{ __('Manage Comments') }}</a></li>
                <li class="list-group-item"><a href="{{ route('user.edit_info') }}">{{ __('Updae Infromation') }}</a></li>
                <li class="list-group-item"><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></li>
            </ul>
    </aside>

</div>