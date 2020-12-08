@extends("layout/layout")

@section("title", "Users crud")

@section("container")
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h3>Users crud</h3>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary btn-block" >New</button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <table id="tableCrud" class="table shadow-sm" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="tableCrudBody" ></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

