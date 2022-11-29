@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>O'quvchilar boshqaruvi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Uy</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('studentIndex') }}">O'quvchilar ro'yxati</a></li>
                        <li class="breadcrumb-item active">Tahrirlash</li>
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
                        <h3 class="card-title">Tahrirlash</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('studentUpdate', $student->id) }}" method="post">
                            @csrf
                            @if(auth()->user()->hasRole('Super Admin'))
                                <div class="form-group">
                                    <label>Guruh</label>
                                    <select class="select2 {{ $errors->has('group_id') ? "is-invalid":"" }}"  name="group_id" data-placeholder="@lang('pleaseSelect')" style="width: 100%;">
                                        <option value=""></option>
                                        @foreach($groups as $group)
                                            <option {{$student->group_id == $group->id ? 'selected' : ''}} value="{{ $group->id }}">{{ $group->name }} | {{$group->teacher->name}} | {{$group->teacher->course}}</option>
                                        @endforeach
                                        @if($errors->has('group_id'))
                                            <span class="error invalid-feedback">{{ $errors->first('group_id') }}</span>
                                        @endif
                                    </select>
                                </div>
                            @else
                                <div class="form-group">
                                    <label>Guruh</label>
                                    <select class="select2 {{ $errors->has('group_id') ? "is-invalid":"" }}"  name="group_id" data-placeholder="@lang('pleaseSelect')" style="width: 100%;">
                                        <option value=""></option>
                                        @foreach($groups as $group)
                                            @if($group->teacher_id == auth()->user()->id)
                                                <option value="{{ $group->id }}">{{ $group->name }} </option>
                                            @endif
                                        @endforeach
                                        @if($errors->has('group_id'))
                                            <span class="error invalid-feedback">{{ $errors->first('group_id') }}</span>
                                        @endif
                                    </select>
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Ism familiya</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('name', $student->name) }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Telefon raqam 1</label>
                                <input type="text" name="phone_1" class="form-control {{ $errors->has('phone_1') ? "is-invalid":"" }}" value="{{ old('phone_1', $student->phone_1) }}" required>
                                @if($errors->has('phone_1'))
                                    <span class="error invalid-feedback">{{ $errors->first('phone_1') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Telefon raqam 2</label>
                                @if($student->phone_2 == 'Mavjud emas')
                                    <input type="text" name="phone_2" class="form-control {{ $errors->has('phone_2') ? "is-invalid":"" }}" >
                                @else
                                    <input type="text" name="phone_2" class="form-control {{ $errors->has('phone_2') ? "is-invalid":"" }}" value="{{ old('phone_2', $student->phone_2) }}" >
                                @endif
                                @if($errors->has('phone_2'))
                                    <span class="error invalid-feedback">{{ $errors->first('phone_2') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('studentIndex') }}" class="btn btn-default float-left">Bekor qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
