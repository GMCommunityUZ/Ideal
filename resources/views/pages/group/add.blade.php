@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Guruhlar boshqaruvi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Uy</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('groupIndex') }}">Guruhlar ro'yxati</a></li>
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

                        <form action="{{ route('groupCreate') }}" method="post">
                            @csrf
                            @if(auth()->user()->hasRole('Super Admin'))
                                <div class="form-group">
                                    <label>O'qituvchi</label>
                                    <select class="select2 {{ $errors->has('teacher_id') ? "is-invalid":"" }}"  name="teacher_id" data-placeholder="@lang('pleaseSelect')" style="width: 100%;">
                                        <option value=""></option>
                                        @foreach($teachers as $teacher)
                                            @if(auth()->user()->id != $teacher->id)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }} </option>
                                            @endif
                                        @endforeach
                                        @if($errors->has('teacher_id'))
                                            <span class="error invalid-feedback">{{ $errors->first('teacher_id') }}</span>
                                        @endif
                                    </select>
                                </div>
                            @else
                                <input type="hidden" value="{{auth()->user()->id}}" name="teacher_id">
                            @endif
                            <div class="form-group">
                                <label>Nomi</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('name') }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Narx</label>
                                <select class="select2 {{ $errors->has('amount_id') ? "is-invalid":"" }}"  name="amount_id" data-placeholder="@lang('pleaseSelect')" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($amounts as $amount)
                                        <option value="{{ $amount->id }}">{{ $amount->price }} </option>
                                    @endforeach
                                    @if($errors->has('amount_id'))
                                        <span class="error invalid-feedback">{{ $errors->first('amount_id') }}</span>
                                    @endif
                                </select>
                            </div>
                            <div class="row d-flex justify-content-around">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label><input type="checkbox" name="monday" value="monday" > Dushanba</label>
                                    </div>
                                    <div class="form-group">
                                        <label><input type="checkbox" name="tuesday" value="tuesday"  > Seshanba</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="wednesday" value="wednesday"> Chorshanba</label>
                                    </div>
                                    <div class="form-group">
                                        <label><input type="checkbox" name="friday" value="friday" > Payshanba</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label><input type="checkbox" name="thursday" value="thursday" > Juma</label>
                                    </div>
                                    <div class="form-group">
                                        <label><input type="checkbox" name="saturday" value="saturday"> Shanba</label>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label><input type="checkbox" name="sunday" value="sunday"> Yakshanba</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label>Dars boshlanish vaqti</label>
                                    <input type="time" name="starts_at" class="form-control {{ $errors->has('starts_at') ? "is-invalid":"" }}" value="{{ old('starts_at') }}" required>
                                    @if($errors->has('starts_at'))
                                        <span class="error invalid-feedback">{{ $errors->first('starts_at') }}</span>
                                    @endif
                                </div>
                                <div class="form-group ml-5">
                                    <label>Dars tugash vaqti</label>
                                    <input type="time" name="ends_at" class="form-control {{ $errors->has('ends_at') ? "is-invalid":"" }}" value="{{ old('ends_at') }}" required>
                                    @if($errors->has('ends_at'))
                                        <span class="error invalid-feedback">{{ $errors->first('ends_at') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('groupIndex') }}" class="btn btn-default float-left">Bekor qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
