@extends('layouts.master')
@section('content')
<div>
    <div class="form-group">
        {{-- <label for="cat_id">t</label> --}}
       <select data-column="1"  class="form-control filter-select" name="cat_id" >
            <option value="">Filter with category</option>
        
            @foreach ($cats as $cat)
            <option value="{{ $cat->id }}"><h4>{{ $cat->category }}</h4>
            </option>
           
            @endforeach
        </select>
    </div>
</div>
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
    <table class="table table-striped" id="datatable">
        <thead>
            <tr>
                <td></td>
                <td>Name</td>
                <td>Email</td>
                <td>Category</td>
                <td colspan="1">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td></td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->cat->category}}</td>
                <td><a href="{{ route('admin.user.edit', $user->id)}}" class="btn btn-primary">Edit</a></td>
                <td>
                    <form action="{{ route('admin.user.destroy', $user->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        @endsection
 @section('javascripts')
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
$(document).ready(function(){
    
    var table =$('#datatable').DataTable({
        'processing':true,
        'serverSide':true,
        'ajax':"{{ route('admin.home') }}",
        'columns':[
            {'data':'name'},
            {'data':'email'},
            {'data':'category'},
               ],
    });
    $('.filter-input').keyup (function () {
        table.column($(this).data('column'))
        .search($(this).val())
        .draw();

    });
    $('.filter-select').change(function () {
        table.column($(this).data('column'))
        .search($(this).val())
        .draw();
    });
})

</script>
        @endsection
