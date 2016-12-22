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
            <li><a href="#">{{ humanize_attribute("test_case") }}</a></li>
        @endforeach
    </ul>
@endsection


@section('content')

    @foreach($models as $name => $data)
        <nav class="panel">
            <p class="panel-heading">
                {{ $name }}
            </p>
            <div class="panel-block">
                <table class="table">
                    <thead>
                    <tr>
                        @foreach($data["attributes"] as $attribute => $type)
                            <th>{{ humanize_attribute($attribute) }}</th>
                        @endforeach
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        @foreach($data["attributes"] as $attribute => $type)
                            <th>{{ humanize_attribute($attribute) }}</th>
                        @endforeach
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="panel-block">
                <div class="columns">
                    <div class="column">
                        <button class="button is-primary is-outlined is-fullwidth">
                            Add New
                        </button>
                    </div>
                    <div class="column">
                        <button class="button is-danger is-outlined is-fullwidth">
                            Drop All
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    @endforeach
    <example></example>
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