@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 >Bor Yo'qlama</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Bor Yo'qlama</li>
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
                         <p>Guruhlar Ro'yhati</p>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->

                           @foreach($groups as $group)
                            <form action="{{route('attendanceCreate')}}" method="POST">
                                @csrf
                               <div class="card collapsed-card">
                                   <div class="card-header border-transparent">
                                       <h3 class="card-title">{{$group->name}} <span class="m-1 badge badge-danger">{{ date("Y-m-d")}}</span></h3>
                                       <div class="card-tools">
                                           <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                               <i class="fas fa-plus"></i>
                                           </button>
                                           <button type="button" class="btn btn-tool" data-card-widget="remove">
                                               <i class="fas fa-times"></i>
                                           </button>
                                       </div>
                                   </div>
                                      <input type="hidden" name="group_id" value="{{$group->id}}">
                                   <div class="card-body p-0" style="display: none;">
                                       <div class="table-responsive">
                                           <table class="table m-0">
                                               <thead>
                                               <tr>
                                                   <th>Ism Sharif</th>
                                                   <th>Status</th>
                                               </tr>
                                               </thead>
                                               <tbody>
                                               <tr>
                                                   <td>{{$group->students->name}}</td>
                                                   <td> <div class="form-group">
                                                           <label>
                                                               <input type="hidden" name="attendances[{{$group->students->id}}]" value="off">
                                                               <input class="width:50%" type="checkbox" name="attendances[{{$group->students->id}}]" value="on"> </label>
                                                       </div>
                                                   </td>
                                               </tr>
                                               </tbody>
                                           </table>
                                       </div>

                                   </div>

                                   <div class="card-footer clearfix" style="display: none;">
                                       <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">O'quvchi Qo'shish</a>
                                       <button  class="btn btn-sm btn-success float-right">Saqlash</button>
                                   </div>

                               </div>

                            </form>
                           @endforeach

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
