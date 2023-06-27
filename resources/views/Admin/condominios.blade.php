@props(['conds', 'user'])
<x-sidebar :user="$user" />
<x-layout>
  <br>
  <a href="/admin/home">
    back
  </a>

  <div class="condominios-container">
    <div class="add-container">
      <form action="condominios/add" method="POST">
        @csrf
        <label for="nome">Adicionar Condominio</label>
        <input type="text" name="nome" placeholder="Nome do condominio">
        @error('nome')
          <x-error-msg :message="$message" />
        @enderror
        <button type="submit">
          Adicionar
        </button>
      </form>
    </div>

    <h1>Condomínios</h1>
    @foreach ($conds as $cond)
      <x-condominios-list :cond="$cond" />
    @endforeach

  </div>

</x-layout>
