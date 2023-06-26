<body>
  <div class="login-container">
    <div class="login-card">
      <h1 class="login-title">Login</h1>
      <form action="/login-form" method="POST">
        @csrf
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
          @error('email')
            <x-error-msg :message="$message" />
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
          @error('password')
            <x-error-msg :message="$message" />
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
        <a href="/register" class="login-href">
          Criar conta
        </a>
      </form>

    </div>
  </div>

</body>
