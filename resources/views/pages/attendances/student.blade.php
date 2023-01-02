@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 >Guruh Bo'yicha</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Tekshiruv</li>
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
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->

                        <table  class="table table-bordered table-striped table-responsive-lg" role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <form action="{{route('filterStudent')}}" method="GET">
                                    <td >
                                        <input type="text" placeholder="Ism familiya" value="{{old('name', request()->name)}}" name="name" class="form-control">
                                    </td>
                                    <td colspan="2">
                                        <select class="select2"  name="group_id" data-placeholder="Guruh" style="width: 100%;">
                                            <option value=""></option>
                                            @foreach($groups   as $group)
                                                <option {{Request::get('group_id') == $group->id ? 'selected' : ''}} value="{{$group->id}}">{{$group->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td >
                                        <select class="select2"  name="status" data-placeholder="Status bo'ycha" style="width: 100%;">
                                            <option value=""></option>
                                            <option {{Request::get('status') == '0' ? 'selected' : ''}} value="0">Kelgan</option>
                                            <option {{Request::get('status') == '1' ? 'selected' : ''}} value="1">Kelmagan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" name="created_at" value="{{old('Y-m-d' , request()->created_at)}}">
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-dark" ><i class="fas fa-search"></i> Search</button>
                                            <a href="{{route('filterStudent')}}" class="btn btn-default"><i class="fas fa-recycle"></i> Clear Filters</a>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center">
                                <th>№</th>
                                <th colspan="3">Ism Sharif</th>
                                <th >Kuni</th>
                                <th>Status</th>
                            </tr>
                                @foreach($attendances as $attendance)

                                    <tr class="text-center">
                                        <td>{{$loop->index+1}}</td>
                                        <td colspan="3">{{$attendance->students->name}}</td>
                                        <td >{{date('Y-m-d',strtotime($attendance->created_at))}}</td>
                                        <td>
                                            <span class="badge badge-{{$attendance->status?"danger":"success"}}">{{$attendance->status?"Kelmagan":"Kelgan"}} </span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer mt-3 ">
                        {!! $attendances->links() !!}
                    </div>
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
