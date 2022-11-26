@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 >Guruhlar ro'yhati</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Guruhlar ro'yhati</li>
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
                        @can('user.add')
                            <a href="{{route('groupAdd')}}" class="btn btn-success btn-sm float-right">
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
                            <tr>
                                <th>ID</th>
                                <th>Gurux nomi</th>
                                <th>O'qituvchisi</th>
                                <th>Fani</th>
                                <th>Narx</th>
                                <th>Dars boshlanish vaqti</th>
                                <th>Dars tugash vaqti</th>
                                <th>Dars kunlari</th>
                                <th class="w-25">Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($groups as $group)
                                <tr>
                                    <td>{{ $group->id }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>@if(isset($group->teacher->name)) {{ $group->teacher->name }}  @else <a class="btn-sm btn-danger">Topilmadi</a> @endif</td>
                                    <td>@if(isset($group->teacher->course )) {{ $group->teacher->course }} @else <a class="btn-sm btn-danger">Topilmadi</a> @endif</td>
                                    <td>{{ $group->amount->price }} so'm</td>
                                    <td>{{ $group->monday == 'monday' ? 'Du / ': '' }}{{ $group->tuesday == 'tuesday' ? 'Se / ': '' }}{{ $group->wednesday == 'wednesday' ? 'Chor / ': '' }}{{ $group->friday == 'friday' ? 'Pay / ': '' }}{{ $group->thursday == 'thursday' ? 'Ju ': '' }}{{ $group->saturday == 'saturday' ? 'Sha': '' }} {{ $group->sunday == 'sunday' ? 'Yak': '' }}
                                        @if($group->monday==null && $group->tuesday == null &&
                                        $group->wednesday == null && $group->friday == null  &&
                                        $group->thursday == null  && $group->saturday == null && $group->sunday == null)
                                            Bo'sh
                                        @endif</td>
                                    <td>{{date('H:i', strtotime($group->starts_at))}}</td>
                                    <td>{{date('H:i', strtotime($group->ends_at))}}</td>
                                    @if(auth()->user()->hasRole('Super Admin'))
                                        <td class="text-center">
                                            @can('user.delete')
                                                <form action="{{route('groupDestroy',$group->id)}}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                        @can('user.edit')
                                                            <a href="{{ route('groupEdit',$group->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Ishonchingiz komilmi?')) { this.form.submit() } "> <i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                </form>
                                            @endcan
                                        </td>
                                    @elseif(auth()->user()->id == $group->teacher_id)
                                        <td class="text-center">
                                            @can('user.delete')
                                                <form action="{{route('groupDestroy',$group->id)}}" method="post">
                                                    @csrf
                                                    <div class="btn-group">
                                                        @can('user.edit')
                                                            <a href="{{ route('groupEdit',$group->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i></a>
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
                        {!! $groups->links() !!}
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
