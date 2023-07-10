<div class="sidebar-container">

  @if (auth()->user()->isAdmin)
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
  @elseif (auth()->user()->isSindico)
    <a href="/sindico/home" class="profile-a">
      <div class="profile-container">
        <img src="{{ asset('/images/no-profile.avif') }}" alt="" class="avatar">
        <span class="nome">
          {{ auth()->user()->name }}
        </span>
      </div>
    </a>

    <div class="options">
      <a href="/sindico/condominio">
        Condominio
      </a>
      <a href="/sindico/turnos">
        Turnos
      </a>
    </div>
  @endif
</div>
