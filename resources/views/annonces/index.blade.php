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
                            <th scope="col">titre</th>
                            <th scope="col">description</th>
                            <th scope="col">prix</th>
                            <th scope="col">Actions</th>
</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($annonces as $annonce)
                            <tr>
                                <td>{{ $annonce->titre }}</td>
                               
                                <td>{{ $annonce->description }}</td>
                                
                                <td>{{ $annonce->prix }} DT</td>
                                <td>
    <div class="btn-group" role="group" aria-label="Actions">
        @if ($annonce->accepte == 'non')
            <form action="{{ url('accepte', $annonce->id) }}" method="POST" style="display: inline; margin-right: 5px;">
                @csrf
                @method('Post')
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button class="btn btn-success" type="submit" title="Accepte annonce">Accepte</button>
            </form>
        @endif

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detailsModal{{ $annonce->id }}" style="display: inline; margin-right: 5px; ">Details</button>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $annonce->id }}">Delete</button>
    </div>
</td>


                            </tr>

                           

                            
                            <!-- Modal for Details -->
                            <div class="modal fade" id="detailsModal{{ $annonce->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailsModalLabel">Annonce Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        @foreach($users as $user)
                    @if($annonce->user_id == $user->id)
                    <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                        <img alt="Image placeholder" src="{{ asset('uploads/avatar/' . $user->avatar) }}">
                        </a>
                        <div class="media-body">
                          <span class="name mb-0 text-sm">{{ $user->name }}</span>
                          <br>
                          <span class="name mb-0 text-sm">{{ $annonce->created_at }}</span>
                        </div>
                       
                        
                        
                      </div>
                    @endif
                @endforeach
                <br>
                                            <!-- Display user details here -->
                                            <img src="{{ asset('uploads/image/' . $annonce->image) }}" alt="Annonce Image" class="img-fluid square-image custom-image-width" style="width:1000px; height: 200px; ">
                       <br>
                       <br>
   
                                        <p>titre: {{ $annonce->titre }}</p>
                                        <p>description: {{ $annonce->description }}</p>
                                        <p>prix: {{ $annonce->prix }} DT</p>
                                        <p>statut: {{ $annonce->statut }} </p>
                                        <p>accepte: {{ $annonce->accepte }} </p>
                                            @foreach($categories as $categrie)
                                            @if($annonce->cat_id == $categrie->id)
                                            <p>categorie: {{ $categrie->nomcat }}</p>
                    @endif
                @endforeach
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                         <!-- Modal for Delete -->
<div class="modal fade" id="deleteModal{{ $annonce->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('annonces.destroy', ['id' => $annonce->id]) }}" method="post">
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


@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
@endpush
    
  

