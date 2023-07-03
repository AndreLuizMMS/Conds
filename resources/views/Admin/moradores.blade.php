@props(['user', 'moradores'])
<x-layout>
  <x-sidebar :user="$user" />
  <a href="/admin/sindicos">back</a>
  <div class="moradores-container">

    <div class="moradores-h">
      <h3>Nome</h3>
      <h3>apartamento</h3>
      <h3>Condominio</h3>
    </div>
    <div class="moradores-info">
      @foreach ($moradores as $morador)
        <div class="info">
          <p> {{ $morador->nomeMorador }} </p>
          <p>{{ $morador->num_ap }}</p>
          <p>{{ $morador->nomeCond }}</p>
          <form action="/admin/moradores/delete/{{ $morador->idMorador }}">
            <button>excluir</button>
          </form>
        </div>
        <br>
      @endforeach
    </div>
  </div>
</x-layout>
