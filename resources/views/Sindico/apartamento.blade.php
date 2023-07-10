@props(['num_ap', 'idCondominio', 'user', 'moradores', 'proprietario'])
<x-layout>
  <x-sidebar :user="$user" />

  <a href="/sindico/condominio/{{ $idCondominio }}">back</a>

  <h1>Apartamento {{ $num_ap }}</h1>
  <h3>condominio {{ $idCondominio }}</h3>

  <h1>Proprietário</h1>
  @if (!$proprietario)
    <span>
      <strong>Sem proprietário</strong>
    </span>
    <br>
    <span> Proprietários são definidos apenas por Administradores </span>
  @else
    <span> {{ $proprietario->nome }} </span>
  @endif

  <br>

  <h1>Moradores</h1>
  <div class="moradores">
    @if (count($moradores) > 0)
      @foreach ($moradores as $morador)
        <span>
          {{ $morador->nome }}
        </span>
      @endforeach
    @else
      <p>
        <strong>Sem Moradores</strong>
      </p>
      <span>Moradores são definidos apenas por Administradores</span>
    @endif
  </div>

</x-layout>
