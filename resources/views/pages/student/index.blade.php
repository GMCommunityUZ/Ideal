@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 >O'quvchilar ro'yhati</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">O'quvchilar ro'yhati</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if(auth()->user()->hasRole('Super Admin'))
                            <div class="btn-group float-right">
                                <a href="{{route('studentAdd')}}" class="btn btn-success btn-sm ">
                                    <span class="fas fa-plus-circle"></span>
                                    Qo'shish
                                </a>
                                <a href="{{route('graphicStudentAdd')}}" class="btn btn-warning btn-sm">
                                    <span class="fas fa-table "></span>
                                    Grafikka qo'shish
                                </a>
                            </div>
                        @else
                            <a href="{{route('studentAdd')}}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                        @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->

                        <table  class="table table-bordered table-striped table-responsive-lg" role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ism familiya</th>
                                <th>Gurux nomi</th>
                                @if(auth()->user()->hasRole('Super Admin'))
                                    <th>O'qituvchi</th>
                                    <th>Fani</th>
                                @endif
                                <th>Telefon raqam 1</th>
                                <th>Telefon raqam 2</th>
                                <th class="w-25">Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>@if(isset($student->group->name)) {{ $student->group->name }}  @else <a class="btn-sm btn-danger">Topilmadi</a> @endif</td>
                                    @if(auth()->user()->hasRole('Super Admin'))
                                        <td>@if(isset($student->group->teacher->name )) {{ $student->group->teacher->name }} @else <a class="btn-sm btn-danger">Topilmadi</a> @endif</td>
                                        <td>@if(isset($student->group->teacher->course )) {{ $student->group->teacher->course }} @else <a class="btn-sm btn-danger">Topilmadi</a> @endif</td>
                                    @endif
                                    <td>{{$student->phone_1}}</td>
                                    <td>{{$student->phone_2}}</td>
                                    @if(auth()->user()->hasRole('Super Admin'))
                                        <td class="text-center">
                                            @can('user.delete')
                                                <form action="{{route('studentDestroy',$student->id)}}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                        @can('user.edit')
                                                            <a href="{{ route('studentEdit',$student->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Ishonchingiz komilmi?')) { this.form.submit() } "> <i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                </form>
                                            @endcan
                                        </td>
                                    @elseif(auth()->user()->hasRole('Super Admin'))
                                        <td class="text-center">
                                            @can('user.delete')
                                                <form action="{{route('studentDestroy',$student->id)}}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                        @can('user.edit')
                                                            <a href="{{ route('studentEdit',$student->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Ishonchingiz komilmi?')) { this.form.submit() } "> <i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                </form>
                                            @endcan
                                        </td>
                                    @elseif(auth()->user()->id == $student->group->teacher_id)
                                        <td class="text-center">
                                            @can('teacher.show')
                                                <form action="{{route('groupDestroy',$student->id)}}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                        @can('teacher.show')
                                                            <a href="{{ route('studentEdit',$student->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Ishonchingiz komilmi?')) { this.form.submit() } "> <i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                </form>
                                            @endcan
                                        </td>
                                    @else
                                        <td class="text-center">
                                            <a class="badge badge-danger ">Ruxsat etilmagan</a>
                                        </td>

                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer mt-3 ">
                        {!! $students->links() !!}
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
