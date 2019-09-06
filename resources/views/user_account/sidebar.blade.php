<div class="col-sm-12 col-md-3 mb-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link{{ Request::is('my-account') ? ' text-primary' : '' }}" href="#">პროფილი</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Request::is('my-account/uploaded-projects') ? ' text-primary' : '' }}" href="{{ URL::to('my-account/uploaded-projects') }}">ატვირთული პროექტები</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Request::is('my-account/upload-project') ? ' text-primary' : '' }}" href="{{ URL::to('my-account/upload-project') }}">პროექტის ატვირთვა</a>
        </li>
    </ul>
</div>