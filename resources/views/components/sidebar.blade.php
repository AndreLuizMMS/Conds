<div class="sidebar-container">

  <a href="/admin/home" class="profile-a">
    <div class="profile-container">
      <img src="{{ asset('/images/no-profile.avif') }}" alt="" class="avatar">
      <span class="nome">
        {{ $user->name }}
      </span>
    </div>
  </a>

  <div class="options">
    <a href="/admin/condominios">
      Condominios
    </a>
    <a href="/admin/sindicos">
      Síndicos
    </a>
    <a href="/admin/moradores">
      Moradores
    </a>
    <a href="/admin/proprietarios">
      Proprietarios
    </a>
  </div>
</div>
