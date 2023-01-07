@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 >Grafik</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('months') }}">Yillik grafik</a></li>
                        <li class="breadcrumb-item active">Grafik</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        @foreach($teachers as $teacher)
            <div class="card collapsed-card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">{{$teacher->name}} <span class="m-1 badge badge-primary">{{ $teacher->course }} </span></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">

                            <tbody>
                            @foreach($groups as $group)
                                @if($teacher->id == $group->teacher_id)
                                    <tr>
                                        <td>
                                            #
                                        </td>
                                        <td>
                                            <a href="{{url('graphics/'. $group->id .'/month/'.$item)}}">
                                                {{$group->name}}
                                            </a>
                                            <br>
                                            <small>
                                                Created {{$group->created_at}}
                                            </small>
                                        </td>


                                        <td class="project-state">
                                            <span class="badge badge-success">{{$group->counter()}}</span>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    @endforeach
    <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
