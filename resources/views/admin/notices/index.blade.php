@extends('layouts.app', ['activePage' => 'notices', 'titlePage' => __('Administración de avisos')])

@section('content')
    <div class="content">
        @include('alerts.success')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Avisos</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('notices.create') }}" class="btn btn-sm btn-primary">Agregar aviso</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table">
                                    <thead class="text-primary">
                                    <tr>
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Mensaje</th>
                                        <th>Activo</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($notices as $notice)
                                        <tr>
                                            <td>{{ $notice->title }}</td>
                                            <td>{{ ucfirst($notice->type) }}</td>
                                            <td>{{ Str::limit($notice->message, 50) }}</td>
                                            <td>
                                                @if($notice->is_active)
                                                    <span class="badge badge-success">Sí</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </td>
                                            <td class="td-actions text-right">
                                                <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('notices.edit', $notice->id) }}" title="Editar">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <form action="{{ route('notices.destroy', $notice->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-link" onclick="return confirm('¿Estás seguro de que deseas eliminar este aviso?')">
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay avisos registrados.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $notices->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

