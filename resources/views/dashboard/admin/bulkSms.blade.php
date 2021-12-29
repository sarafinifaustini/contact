@extends('layouts.master')
@section('content')
<div class="container" id="app">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Messages</h3>
                </div>
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>

                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Message Title</th>
                        <th scope="col">Message</th>
                        <th scope="col">Send Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $index => $message)
                    <tr>
                        <th scope="row">{{++$index}}</th>

                        <td>{{ $message->title }}</td>
                        <td>{{ $message->message }}</td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="nav-icon fas fa-share-square"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        
        </div>
       
        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Send this message to selected suscriber categories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.send') }}" method="post">
                            @csrf
                            <input type="hidden" name="message_id">
                            <ul>
                                @foreach ($users as $user)
                                <li>
                                    <input type="checkBox" name="user_id" value="{{ $user->id }}">
                                    {{ $user->category }}
                                </li>
                                @endforeach
                            </ul>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>
@push('scripts')
<script>
    // your code
</script>
@endpush
@endsection
