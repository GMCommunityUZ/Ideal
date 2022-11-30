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
                                <form action="{{route('filterGroup')}}" method="POST">
                                    @csrf
                                    <td colspan="">
                                        <select class="select2"  name="group_id" data-placeholder="Guruh" style="width: 100%;">
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}">{{$group->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td colspan="">
                                        <input type="date" name="date"  class=" form-control" >
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-dark" ><i class="fas fa-search"></i> Search</button>
                                            <a href="" class="btn btn-default"><i class="fas fa-recycle"></i> Clear Filters</a>
                                        </div>

                                    </td>
                                </form>
                            </tr>
                            </thead>
                            <tbody>
                               <tr class="text-center">
                                   <th>Ism Sharif</th>
                                   <th>Kuni</th>
                                   <th>Status</th>
                               </tr>
                            @if(isset($attendances))

                                @foreach($attendances as $attendance)

                                    <tr class="text-center">
                                        <td>{{$attendance->students->name}}</td>
                                        <td>{{date('Y-m-d',strtotime($attendance->created_at))}}</td>
                                        <td>
                                            <span class="badge badge-{{$attendance->status?"danger":"success"}}">{{$attendance->status?"Kelmagan":"Kelgan"}} </span>
                                        </td>

                                    </tr>

                                @endforeach

                            @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

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
