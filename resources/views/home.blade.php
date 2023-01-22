@extends('template')

@section('konten')
  <h4>Selamat datang <b>{{Auth::user()->username}}</b>
  <br><br>
  <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                        <br><br>
                        
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="col-sm-2">
                                        <label name="username" class="col-sm-1 control-label"> Username </label> 
                                    </div>
                                    <div class="col-md-1">
                                        <label name="username" class="col-sm-1 control-label"> : </label> 
                                    </div>
                                    <div class="col-sm-6">
                                        {{ $user->username }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="col-sm-2">
                                        <label name="email" class="col-sm-1 control-label"> Email </label> 
                                    </div>
                                    <div class="col-md-1">
                                        <label name="email" class="col-sm-1 control-label"> : </label> 
                                    </div>
                                    <div class="col-sm-6">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="col-sm-2">
                                        <label name="image" class="col-sm-1 control-label"> Foto </label> 
                                    </div>
                                    <div class="col-md-1">
                                        <label name="image" class="col-sm-1 control-label"> : </label> 
                                    </div>
                                    <div class="col-sm-6">
                                        <img src="/storage/{{$user->image}}" class="rounded mx-auto d-block img-fluid img-thumbnail">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection