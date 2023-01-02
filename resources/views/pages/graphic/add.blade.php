@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-center">Grafik boshqaruvi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('graphicIndex') }}">Grafik</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('graphicStudents', $id) }}">O'quvchilar ro'yxati</a></li>
                        <li class="breadcrumb-item active">Qo'shish</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Qo'shish</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('graphicCreate') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>O'quvchi</label>
                                <select id="studentFromGroup" class="select2 {{ $errors->has('student_id') ? "is-invalid":"" }}"  name="student_id" data-placeholder="@lang('pleaseSelect')" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} </option>
                                    @endforeach
                                    @if($errors->has('student_id'))
                                        <span class="error invalid-feedback">{{ $errors->first('student_id') }}</span>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>To'lanayotgan miqdor</label>
                                <input type="text" name="paid_amount" class="form-control {{ $errors->has('paid_amount') ? "is-invalid":"" }}" value="{{ old('paid_amount') }}" required>
                                @if($errors->has('paid_amount'))
                                    <span class="error invalid-feedback">{{ $errors->first('paid_amount') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Chegirma</label>
                                <input type="text" name="discount_amount" class="form-control {{ $errors->has('discount_amount') ? "is-invalid":"" }}" value="{{ old('discount_amount') }}" >
                                @if($errors->has('discount_amount'))
                                    <span class="error invalid-feedback">{{ $errors->first('discount_amount') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Oy</label>
                                <input type="month" name="month" class="form-control {{ $errors->has('month') ? "is-invalid":"" }}" value="{{ old('month') }}">
                            </div>
                            <div class="form-group">
                                <label>Izoh</label>
                                <textarea name="comment" class="form-control" style="resize: none"></textarea>
                            </div>
                            <input type="hidden" name="group_id" value="{{$id}}">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('graphicStudents', $id) }}" class="btn btn-default float-left">Orqaga</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
