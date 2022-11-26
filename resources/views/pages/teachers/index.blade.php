@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 >O'qituvchilar ro'yhati</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">O'qituvchilar ro'yhati</li>
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
                        @can('teacher.add')
                            <a href="{{route('teacherAdd')}}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->

                        <table  class="table table-bordered table-striped table-responsive-lg" role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr class="text-center">
                                <th>Id</th>
                                <th>Ism familiya</th>
                                <th>Nomer</th>
                                <th>Email </th>
                                <th>Fan</th>
                                <th class="w-25">Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                          @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{$teacher->phone}}</td>
                                        <td>{{ $teacher->email}}</td>
                                        <td>{{$teacher->course}}</td>
                                        @if(auth()->user()->hasRole('Super Admin'))
                                            <td class="text-center">
                                                @can('teacher.delete')
                                                    <form action="{{route('teacherDestroy',$teacher->id)}}" method="post">
                                                        @csrf
                                                        <div class="btn-group">
                                                            @can('teacher.edit')
                                                                <a href="{{ route('teacherEdit',$teacher->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i></a>
                                                            @endcan
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "> <i class="fas fa-trash-alt"></i></button>
                                                        </div>
                                                    </form>
                                                @endcan
                                            </td>
                                        @elseif(auth()->user()->id == $teacher->id)
                                            <td class="text-center">
                                                <form action="{{route('teacherDestroy',$teacher->id)}}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                            <a href="{{ route('teacherEdit',$teacher->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i></a>
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "> <i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                </form>
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
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
