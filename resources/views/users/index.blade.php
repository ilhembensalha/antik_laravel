@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <!-- Le reste de votre code HTML -->
          

            <div class="table-responsive">
                <table class="table table-secondary align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Creation Date</th>
                            <th scope="col"> <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUserModal">Add </button>
</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                            <td scope="row">
                      <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                        <img alt="Image placeholder" src="{{ asset('uploads/avatar/' . $user->avatar) }}">
                        </a>
                        <div class="media-body">
                          <span class="name mb-0 text-sm">{{ $user->name }}</span>
                        </div>
                      </div>
                    </td>
                              
                                <td>
                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detailsModal{{ $user->id }}">Details</button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal for Details -->
                            <div class="modal fade" id="detailsModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailsModalLabel">User Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Display user details here -->
       
                                            <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                        <img alt="Image placeholder" src="{{ asset('uploads/avatar/' . $user->avatar) }}">
                        </a>
                        <div class="media-body">
                          <span class="name mb-0 text-sm">{{ $user->name }}</span>
                        </div>
                      </div>
                      <br>
                                            <p>Email: {{ $user->email }}</p>
                                            <p>role: {{ $user->role }}</p>
                                            <p>Creation Date: {{ $user->created_at }}</p>
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


 <!-- Modal for CRREAT -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add User Form -->
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <!-- Form fields for adding user -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="User's name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="User's email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="User's password">
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add </button>
                </form>
            </div>
        </div>
    </div>
</div>


   
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Le reste de votre code HTML -->
        </div>
    </div>




    
    @include('layouts.footers.auth')
    </div>



@endsection


@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
@endpush
    
  

