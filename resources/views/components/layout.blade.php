<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @vite(['resources/scss/app.scss'])

</head>

<header>
  <div class="container">
    <h1>Conds</h1>
  </div>
</header>

<body>
  {{ $slot }}
</body>

</html>
