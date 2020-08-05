@extends('auth.contenido')

@section('login')
<div class="login-box">
    <div class="login-logo">
      <a href="plantilla/index2.html">Copitos<b>Dev</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"> <b>Ingresa tus datos para iniciar session</b></p>
  
      <form action="{{route('login')}}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
          <div class="input-group mb-3 {{$errors->has('usuario' ? 'is-invalid' : '')}}">
          <input type="text" class="form-control" placeholder="usuario" name="usuario" value="{{old('usuario')}}">
            
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div><br>
            
          </div>
          
          <div class="input-group mb-3 {{$errors->has('password' ? 'is-invalid' : '')}} ">
            <input type="password" class="form-control" placeholder="Password" name="password">          
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            {!!$errors->first('usuario','<small style="color:red;"> :message </small>')!!}
          </div>
          <div class="row">             
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>
            <!-- /.col -->
          </div>
        </form> 
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
@endsection
