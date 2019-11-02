<div class="col-sm-12 col-md-3 mb-3">
    <ul class="nav flex-column">
        @if($user->roles()->where('slug', 'user')->count() > 0)
            <li class="nav-item">
                <a class="nav-link{{ Request::is('my-account/uploaded-projects') ? ' text-primary' : '' }}" href="{{ URL::to('my-account/uploaded-projects') }}">ატვირთული პროექტები
                    <span class="badge badge-info">{{ $user->projects()->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('my-account/upload-project') ? ' text-primary' : '' }}" href="{{ URL::to('my-account/upload-project') }}">პროექტის ატვირთვა</a>
            </li>
        @elseif($user->roles()->where('slug', 'expert')->count() > 0)
            <li class="nav-item">
                <a class="nav-link{{ Request::is('my-account/evaluated') ? ' text-primary' : '' }}" href="{{ URL::to('my-account/evaluated') }}">შეფასებული პროექტები
                    <span class="badge badge-success">{{ count($user->getEvaluatedProjects()) }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('my-account/to-evaluate') ? ' text-primary' : '' }}" href="{{ URL::to('my-account/to-evaluate') }}">შესაფასებელი პროექტები
                    <span class="badge badge-warning">{{ count($user->getProjectsToEvaluate()) }}</span>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link{{ Request::is('my-account') ? ' text-primary' : '' }}" href="{{ URL::to('my-account') }}">პროფილი</a>
        </li>
    </ul>
</div>