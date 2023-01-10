@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 >Yillik grafik</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Yillik grafik</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

            <div class="card ">
                <div class="card-header ">
                    <h3 class="card-title"><span class="m-1 badge badge-primary">{{now()->format('Y')}}-yil</span></h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            @foreach($newDateTime as $item)
                                    <tr>
                                        <td>
                                            #
                                        </td>
                                        <td>
                                            <a href="{{route('groupGraphicTeacher', $item)}}">
                                                @if($item == 'January')
                                                    Yanvar
                                                @elseif($item == 'February')
                                                    Fevral
                                                @elseif($item == 'March')
                                                    Mart
                                                @elseif($item == 'April')
                                                    Aprel
                                                @elseif($item == 'May')
                                                    May
                                                @elseif($item == 'June')
                                                    Iyun
                                                @elseif($item == 'July')
                                                    Iyul
                                                @elseif($item == 'August')
                                                    Avgust
                                                @elseif($item == 'September')
                                                    Sentabr
                                                @elseif($item == 'October')
                                                    Oktabr
                                                @elseif($item == 'November')
                                                    Noyabr
                                                @elseif($item == 'December')
                                                    Dekabr
                                                @endif
                                            </a>
                                            <br>
                                            <small>
                                            </small>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
