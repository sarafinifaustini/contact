@extends('layouts.master')
@section('content')
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Success!</h4>
    <p>{{ Session::get('success') }}</p>

    <button type="button" class="close" data-dismiss="alert aria-label=" Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (Session::has('errors'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Error!</h4>
    <p>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    </p>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<style>
    .uper {
        margin-top: 40px;
    }
</style>
<div class="uper">
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div><br />
    @endif
{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.contacts') }}">All</a>
        <a class="navbar-brand" href="{{ route('admin.news') }}">News</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="{{ route('admin.sports') }}">Sports</a>
                <a class="nav-link" href="{{ route('admin.politics') }}">Politics</a>
                <a class="nav-link" href="{{ route('admin.business') }}">Business</a>

            </div>
        </div>
    </div>
</nav> --}}
    <table class="table table-striped" id="datatable">
        <div>
            <div class="form-group">

                <select data-column="2" class="form-control filter-select" >
                    <option value="">Filter with category</option>

                    @foreach ($cats as $cat)
                    <option value="{{ $cat->category }}">
                        <h4>{{ $cat->category }}</h4>
                    </option>

                    @endforeach
                </select>
            </div>
        </div>

        <thead>
            <tr>
                <td></td>
                <td>Name</td>
                <td>Email</td>
                <td>Category</td>
                <td colspan="1">Action</td>
                <td colspan="1"></td>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td></td>
                 <td>{{$contact->name}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->cat->category}}</td>
           <td><a href="{{ route('admin.user.edit', $contact->id)}}" class="btn btn-primary">Edit</a></td>
                  <td>  <form action="{{ route('admin.user.destroy', $contact->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div class="mt-4">{{ $contacts->links() }}</div> --}}

</div>
@endsection

@section('javascript')

<script type="text/javascript" charset="utf8"
    src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){

var table =$('#datatable').DataTable({
'processing':true,
'serverSide':true,
'ajax':"{{ route('admin.contactIndex') }}",
'columns':[
    // {'data':'id'},
{'data':'name'},
{'data':'email'},
{'data':'category'},
],
});
// $('.filter-input').keyup (function () {
// table.column($(this).data('column'))
// .search($(this).val())
// .draw();

// });
$('.filter-select').change(function () {
table.column($(this).data('column'))
.search($(this).val())
.draw();
});
})
</script>
@endsection
