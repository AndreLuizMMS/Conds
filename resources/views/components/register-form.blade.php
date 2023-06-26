<body>
  <div class="login-container">
    <div class="login-card">
      <h1 class="login-title">Registrar</h1>

      <form action="/register-form" method="POST">
        @csrf
        <div class="form-group">
          <label for="name">Nome</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="Insira seu Nome">
          @error('name')
            <x-error-msg :message="$message" />
          @enderror
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Insira seu email">
          @error('email')
            <x-error-msg :message="$message" />
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Senha</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Crie uma Senha">
          @error('password')
            <x-error-msg :message="$message" />
          @enderror
        </div>

        <div class="form-group">
          <label for="password_confirm">Confirme</label>
          <input type="password" id="password_confirm" name="password_confirmation" class="form-control"
            placeholder="Confirme sua senha">
          @error('password_confirmation')
            <x-error-msg :message="$message" />
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="/login" class="login-href">
          Já tenho uma conta
        </a>
      </form>


    </div>
  </div>

</body>
