@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-center">Narxlar boshqaruvi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('amountIndex') }}">Narxlar ro'yxati</a></li>
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

                        <form action="{{ route('amountUpdate', $amount->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Narx</label>
                                <input type="text" name="price" class="form-control {{ $errors->has('price') ? "is-invalid":"" }}" value="{{ old('price', $amount->price) }}" required>
                                @if($errors->has('price'))
                                    <span class="error invalid-feedback">{{ $errors->first('price') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Sana</label>
                                <input type="date" name="date" class="form-control {{ $errors->has('date') ? "is-invalid":"" }}" value="{{old('date',$amount->date) }}" required>
                                @if($errors->has('date'))
                                    <span class="error invalid-feedback">{{ $errors->first('date') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('amountIndex') }}" class="btn btn-default float-left">Bekor qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
