<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/fontawesome.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>      
        
    </head>
    <body class="bg-light">
        <div class="container">   
          <div class="row">
            <div class="col-lg-12">
              <h4 class="mb-3">{{ __('Generar llave nueva') }}</h4>
              
           
           @if($messageGK=Session::get("successGK"))
                <div class="alert alert-success" role="alert">
                  <p> Key: {{Session::get("key")}} </p>
                </div>
           @elseif($messageGK=Session::get("errorGK"))
               <div class="alert alert-danger" role="alert">
                  {{$messageGK}}
               </div>
           @else
               <div class="alert alert-primary" role="alert">
                  Mostrar llave
               </div>
           @endif
            </div>
              <form class="needs-validation" method="POST" action="{{ route('generateKey') }}">
                @csrf
                <div class="mb-3">
                  <label for="username">Method Encryption</label>
                  <div class="input-group">
                    <select name="method" id="method" class="form-control">
                        <option value="sha511">sha512</option>
                    </select>
                  </div>
                </div>
                   
                <hr class="mb-12">
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">{{ __('Encriptar') }}</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <hr>
        <div class="container">   
          <div class="row">
            <div class="col-lg-12">
              <h4 class="mb-3">{{ __('Cadena a encriptar') }}</h4>
              
              
              @if($messageME=Session::get("successME"))
                <div class="alert alert-success" role="alert">
                 Cadena Encriptada: {{Session::get("encrypt")}} 
                </div>
              @elseif($messageME=Session::get("errorME"))
                  <div class="alert alert-danger" role="alert">
                     {{$messageME}}
                  </div>
              @else
                  <div class="alert alert-primary" role="alert">
                    Mostrar Encrypted
                  </div>
              @endif
            </div>
              <form class="needs-validation" method="POST" action="{{ route('encrypt') }}">
                @csrf
                <div class="mb-3">
                  <label for="username">Llave</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="key" placeholder="Llave de encriptación" name="key" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="username">Cadena</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="encript" placeholder="Cadena a encriptar" name="encript" required>
                  </div>
                </div>
                   
                <hr class="mb-12">
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">{{ __('Encriptar') }}</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <hr>
        <div class="container">   
          <div class="row">
            <div class="col-lg-12">
              <h4 class="mb-3">{{ __(' Mostrar Decrypt') }}</h4>
              
              @if($messageMDE=Session::get("successMDE"))
                <div class="alert alert-success" role="alert">
                 Cadena Encriptada: {{Session::get("decrypt")}} 
                </div>
              @elseif($messageMDE=Session::get("errorMDE"))
                  <div class="alert alert-danger" role="alert">
                     {{$messageMDE}}
                  </div>
              @else
                  <div class="alert alert-primary" role="alert">
                      Mostrar Decrypt
                  </div>
              @endif
            </div>
              <form class="needs-validation" method="POST" action="{{ route('decrypt') }}">
                @csrf
                <div class="mb-3">
                  <label for="username">Llave</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="key" placeholder="Llave de encriptación" name="key" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="username">Cadena</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="encript" placeholder="Cadena encriptada" name="encript" required>
                  </div>
                </div>
                   
                <hr class="mb-12">
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">{{ __('Desencriptar') }}</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </body>
</html>
