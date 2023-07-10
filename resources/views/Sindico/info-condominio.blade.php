@props(['cond', 'sindicos', 'user'])
<x-layout>
  <x-sidebar :user="$user" />
  <a href="/sindico/condominio">back</a>

  <h1>{{ $cond->nome }}</h1>
  <br>
  <br>
  <h1>Síndicos atuais</h1>


  <div class="sindicos-at">
    <div class="table-header">
      <span>Nome</span>
      <span>Turno</span>
    </div>
    <div class="sindicos-info">
      @foreach ($sindicos as $sindico)
        <div class="info">
          <span>{{ $sindico->nome }}</span>
          <span>{{ $sindico->turno }}</span>
        </div>
      @endforeach
    </div>
  </div>

  <div class="aps">
    <h1>Apartamentos</h1>
    <div class="aps-info">
      @foreach ($apartamentos as $ap)
        <div>
          <p>{{ $ap->num_ap }}</p>
          <a href="/sindico/condominio/{{ $ap->condominio }}/ap/{{ $ap->id }}/{{ $ap->num_ap }}/">
            <button>Ver mais</button>
          </a>
        </div>
      @endforeach
    </div>
  </div>

</x-layout>
