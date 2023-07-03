@props(['user', 'proprietarios'])
<x-layout>
  <x-sidebar :user="$user" />

  <h1>Proprietarios</h1>

  <div class="proprietarios">
    <div class="info-headers">
      <span>Nome</span>
      <span>Apartamento</span>
      <span>Condominio</span>
    </div>

    <br>

    <div class="info-values">
      @foreach ($proprietarios as $proprietario)
        <div class="values">
          <p> {{ $proprietario->propNome }} </p>
          <a
            href="/admin/condominios/edit/{{ $proprietario->idCond }}/ap/{{ $proprietario->idApartamento }}/id/{{ $proprietario->num_ap }}">
            <p> {{ $proprietario->num_ap }} </p>
          </a>
          <a href="/admin/condominios/edit/{{ $proprietario->idCond }}">
            <p> {{ $proprietario->nomeCond }} </p>
          </a>
          <form
            action="/admin/proprietarios/{{ $proprietario->idProp }}/cond/{{ $proprietario->idCond }}/ap/{{ $proprietario->num_ap }}">
            <button>excluir</button>
          </form>
        </div>
      @endforeach
    </div>
  </div>

</x-layout>
