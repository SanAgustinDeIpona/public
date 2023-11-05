@extends('layouts.panel')

@section('template_title')
    Disease Group
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Disease Group') }}
                            </span>

                            <div class="float-right">
                                <a class="text-white mr-3 mt-3 btn btn-primary" data-toggle="modal" data-target="#CreateModal" data-modal-origin="create">Nuevo
                                    <i class="mr-2 fa-sharp fa-solid fa-plus"></i>
                                </a>
                          </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive" id="datatable">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Disease Group Name</th>
										<th>Description</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diseaseGroups as $diseaseGroup)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $diseaseGroup->disease_group_name }}</td>
											<td>{{ $diseaseGroup->description }}</td>

                                            <td>
                                                <form action="{{ route('disease-groups.destroy',$diseaseGroup->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-success" href="{{ route('disease-groups.edit',$diseaseGroup->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $diseaseGroups->links() !!}
            </div>
        </div>
    </div>

            <!-- Modal crear -->
            <div class="modal fade" id="CreateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="CreateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">Crear Grupo de enfermedad
                            <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action ="{{ route('diseases.store') }}" method = "POST" enctype="multipart/form-data">
                            {{@csrf_field()}}
            
                    <div class="mb-3">
                        <label for="disease_group_name" class="col-form-label">Nombre del grupo de enfermedad</label>
                        <input  id="disease_group_name" type="text" class="form-control input-redondeado  @error('disease_group_name') is-invalid @enderror" name="disease_group_name" value="" autocomplete="off" autofocus>
                        @error('disease_group_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                    <label for="description" class="col-form-label">Descripcion</label>
                    <input  id="description" type="text" class="form-control input-redondeado @error('description') is-invalid @enderror" name="affair" value="{{old('description')}}" autocomplete="off" autofocus>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-outline-primary btn-notification" data-dismiss="modal">Cancelar
                                <i class="fa-solid fa-circle-xmark" style="color: #ffffff;"></i>                        
                            <button type="submit" class="btn btn-primary btn-notification btn-notification-save" data-action="store">Guardar
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><style>svg{fill:#ffffff}</style><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal crear -->


@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
    $('#datatable').DataTable({
                language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
            },
            "lengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "Todos"]]
        })
    });
</script>
<script>
    $('.Form-Delete').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'El registro será eliminado permanentemente',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#01499B',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
            if (result.isConfirmed) {
                this.submit()
            }
        })
    })
</script>
@endsection

    @if ($errors->any())
    @include('includes.alerts.error')  
@endif
@if (session('mensaje') == 'OkDelete')
    @include('includes.alerts.delete')  
@endif
@if (session('mensaje') == 'OkCreate')
    @include('includes.alerts.create')  
@endif
@if (session('mensaje') == 'OkUpdate')
    @include('includes.alerts.edit')  
@endif
@endsection
