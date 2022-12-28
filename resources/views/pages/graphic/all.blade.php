@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 >Umumiy grafik</h5>
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
                        <div>
                            <p class="card-title">Ushbu oyning umumiy grafigi</p>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table  class="table table-bordered table-striped table-responsive-lg" role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <form action="{{route('graphicAll')}}" method="get">
                                <tr>
                                    <td></td>
                                    <td colspan="2">
                                        <input class="form-control" placeholder="F.I.O" type="text" name="name" value="{{old('name', request()->name)}}">
                                    </td>
                                    <td colspan="3">
                                        <select class="select2"  name="group_id" data-placeholder="Guruh bo'ycha" style="width: 100%;">
                                            <option value=""></option>
                                            @foreach($groups as $group)
                                                <option {{Request::get('group_id') == $group->id ? 'selected' : ''}} value="{{ $group->id }}">{{ $group->name }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td colspan="2">
                                        <select class="select2"  name="status" data-placeholder="Status bo'ycha" style="width: 100%;">
                                            <option value=""></option>
                                            <option {{Request::get('status') == 'To\'liq emas' ? 'selected' : ''}} value="To'liq emas">To'liq emas</option>
                                            <option {{Request::get('status') == 'To\'lanmagan' ? 'selected' : ''}} value="To'lanmagan">To'lanmagan</option>
                                            <option {{Request::get('status') == 'To\'langan' ? 'selected' : ''}} value="To'langan">To'langan</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="submit" name="search" class="btn btn-dark btn-sm" ><i class="fas fa-search"></i> Qidiruv</button>
                                            <a href="{{route('graphicAll')}}" class="btn btn-default btn-sm"><i class="fas fa-recycle"></i> Tozalash</a>
                                        </div>
                                    </td>
                                </tr>
                            </form>
                            <tr>
                                <th>№</th>
                                <th colspan="2">Ism familiya</th>
                                <th colspan="2">Guruh</th>
                                <th>Qarz</th>
                                <th>Chegirma</th>
                                <th>Status</th>
                                <th class="w-25 text-center">Amallar</th>
                            </tr>
                            </thead>
                            @foreach($graphics as $graphic)
                                <tbody>
                                <td>{{$loop->index+1}}</td>
                                <td colspan="2">{{$graphic->student->name}}</td>
                                <td colspan="2">{{$graphic->group->name}}</td>
                                <td >{{$graphic->remaining_amount}} so'm</td>
                                <td >{{$graphic->discount_amount}} so'm</td>
                                @if($graphic->status == 'To\'liq emas')
                                    <td><a class="badge badge-warning">{{$graphic->status}}</a> </td>
                                @elseif($graphic->status == 'To\'lanmagan')
                                    <td><a class="badge badge-danger">{{$graphic->status}}</a> </td>
                                @else
                                    <td><a class="badge badge-success">{{$graphic->status}}</a> </td>
                                @endif
                                <td class="text-center">
                                    @can('user.delete')
                                        <form action="{{route('graphicDestroy',$graphic->id)}}" method="post">
                                            @csrf
                                            <div class="btn-group">
                                                @can('user.edit')
                                                    <a href="{{ route('graphicEdit',$graphic->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i></a>
                                                @endcan
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Ishonchingiz komilmi?')) { this.form.submit() } "> <i class="fas fa-trash-alt"></i></button>
                                                    <a href="{{ route('graphicPay',$graphic->id) }}" type="button" class="btn btn-secondary btn-sm"> <i class="fas fa-check-circle"></i></a>
                                            </div>
                                        </form>
                                    @endcan
                                </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer mt-3 ">
                        {!! $graphics->links() !!}
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
