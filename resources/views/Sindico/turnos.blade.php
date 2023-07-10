@props(['turnos'])

<x-layout>
  <x-sidebar />

  <h1>Turnos ativos</h1>
  <div class="turnos">

    <h1>
      {{ $turnos[0]->sindico }}
    </h1>

    <div class="turno-header">
      <p>Condominio</p>
      <p>Turno</p>
    </div>
    <div class="turno-info">
      @foreach ($turnos as $turno)
        <div>
          <span>{{ $turno->condominio }}</span>
          <span>{{ $turno->turno }}</span>
        </div>
      @endforeach
    </div>
  </div>

</x-layout>
