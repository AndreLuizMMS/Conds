<div class="sidebar-container">

  <a href="" class="profile-a">
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
    <a href="#">
      Síndicos
    </a>
  </div>
</div>
