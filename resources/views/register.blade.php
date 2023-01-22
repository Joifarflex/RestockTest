<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>Register</title>
        <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
            crossorigin="anonymous"></script>
    </head>
    <body class="bg-light">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    {{-- Error Alert --}}
                                    @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{session('error')}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4"><b>User </b>Register</h3>
                                    </div>
                                    <div class="card-body">
                                    <form method="POST" action="{{ route('actionregister') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                @error('login_gagal')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                        {{-- <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span> --}}
                                                        <span class="alert-inner--text"><strong>Warning!</strong> {{ $message }}</span>
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    @enderror
                                                <label class="mb-1" for="username">Username</label>
                                                <input class="form-control py-4" id="username" name="username" type="text" placeholder="Masukkan Username"/>
                                                @if($errors->has('username'))
                                                    <span class="error">{{ $errors->first('username') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1" for="email">E-mail</label>
                                                <input class="form-control py-4" id="email" name="email" type="text" placeholder="Masukkan E-mail"/>
                                                @if($errors->has('email'))
                                                    <span class="error">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1" for="password">Password</label>
                                                <input class="form-control py-4" id="password" type="text" name="password" placeholder="Masukkan Password"/>
                                                @if($errors->has('password'))
                                                    <span class="error">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1"> Foto Profil</label>
                                                <input type="file" class="form-control" name="image" placeholder="Choose image" id="image">
                                                @if($errors->has('image'))
                                                    <span class="error">{{ $errors->first('image') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <img id="preview-image" src="https://via.placeholder.com/150"
                                                alt="preview image" style="max-height: 250px;">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-lg float-right" type="submit">Register</button>
                                            </div>
                                            <!-- <button class="btn btn-outline-primary btn-lg float-right reset">Reset</button>                                         -->

                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small">
                                            <span>Sudah punya akun? <b><a href="{{url('login')}}">Langsung masuk!</a></b></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </div>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            crossorigin="anonymous"></script>
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
        <script src="{{url('assets/js/scripts.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 
        <script type="text/javascript"> 
        $(document).ready(function (e) {
            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {             
                $('#preview-image').attr('src', e.target.result); 
                }
                reader.readAsDataURL(this.files[0]); 
            });
            
            $(".reset").click( function(){
                    $('#username').val("");
                    $('#password').val("");
                    $('#image').val('');
                    $('#preview-image').attr('src', "https://via.placeholder.com/150"); // replace preview image with default image
                });

        });
        </script>
    </body>
</html>
