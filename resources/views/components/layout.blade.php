<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  @vite(['resources/scss/app.scss'])

</head>

<header>
  <div class="container">
    <h1>Conds</h1>
  </div>
  @if (auth()->check())
    <div class="header-buttons">
      <form action="/logout" method="POST">
        @csrf
        <button>
          Logout
        </button>
      </form>
    </div>
  @else
    <div class="header-buttons">
      <a href="/login">
        <button>
          Login
        </button>
      </a>
      <a href="/register">
        <button>
          Criar conta
        </button>
      </a>
      </a>
    </div>
  @endif
  </div>
</header>

@if (session()->has('msg'))
  <div class="msg-container">
    <span>
      {{ session('msg') }}
    </span>
  </div>
@endif

<body>
  {{ $slot }}
</body>

</html>
