@extends("orm_manager.layout")

@section("title", "Models")

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section("sidebar-nav")
    <p class="menu-label">
        Settings
    </p>
    <ul class="menu-list">
        <li><a href="#">Foo</a></li>
        <li><a href="#">Bar</a></li>
        <li><a href="#">Baz</a></li>
    </ul>
@endsection


@section('content')

    This is the content section
    <example></example>
@endsection
