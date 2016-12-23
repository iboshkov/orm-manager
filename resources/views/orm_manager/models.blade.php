@extends("orm_manager.layout")

@section("title", "Models")

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section("sidebar-nav")
    <p class="menu-label">
        Models
    </p>
    <ul class="menu-list">
        @foreach($models as $name => $data)
            <li><a href="#">{{ $name }}</a></li>
        @endforeach
    </ul>
@endsection


@section('content')

    @foreach($models as $name => $data)
        <model-component class-name="{{ $name }}"></model-component>
    @endforeach
@endsection

@section('footer')
    <p>
        <strong>ORM Manager</strong> by <a href="http://boshkov.tech">Ilija Boshkov</a>. The source code is licensed
        <a href="http://opensource.org/licenses/mit-license.php">MIT</a>.
    </p>
    <p>
        <a class="icon" href="https://github.com/iboshkov/orm-manager">
            <i class="fa fa-github"></i>
        </a>
    </p>
@endsection