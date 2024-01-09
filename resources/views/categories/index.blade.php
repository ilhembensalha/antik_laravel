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
                            <th scope="col">Creation Date</th>
                            <th scope="col"> <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUserModal">Add </button>
</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $categorie)
                            <tr>
                                <td>{{ $categorie->nomcat }}</td>
                               
                                <td>{{ $categorie->created_at }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal{{ $categorie->id }}">Edit</button>
                                    </div>
                                </td>
                            </tr>

                           

                           <!-- Modal for Edit -->
<div class="modal fade" id="editModal{{ $categorie->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ route('categories.update', ['id' => $categorie->id]) }}">
                    @csrf
                    @method('PUT')
                    <!-- Form fields for editing user -->
                    <div class="form-group">
                        <label for="categorie">categorie</label>
                        <input type="text" class="form-control" id="categorie" name="nomcat" value="{{$categorie->nomcat}}">
                    </div>
                   
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Modal for CRREAT -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add User Form -->
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <!-- Form fields for adding user -->
                    <div class="form-group">
                        <label for="nomcat">nomcat</label>
                        <input type="text" class="form-control" id="nomcat" name="nomcat" placeholder="nomcat">
                    </div>
                 
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add categorie</button>
                </form>
            </div>
        </div>
    </div>
</div>


                         <!-- Modal for Delete -->
<div class="modal fade" id="deleteModal{{ $categorie->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('categories.destroy', ['id' => $categorie->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Confirmation message for deleting user -->
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
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
   <!-- 
@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
@endpush
    
  -->

