@props(['num_ap', 'idCondominio', 'user', 'moradores', 'proprietario'])
<x-layout>
  <x-sidebar :user="$user" />

  <a href="/admin/condominios/edit/{{ $idCondominio }}">back</a>

  <h1>Apartamento {{ $num_ap }}</h1>
  <h3>condominio {{ $idCondominio }}</h3>

  <h1>Proprietário</h1>
  @if ($proprietario)
    <span> {{ $proprietario->nome }} </span>
  @else 
    <span> Sem proprietário </span>
    <br>
    <form
      action="/admin/proprietarios/condominio/{{ $idCondominio }}/ap/{{ $num_ap }}/id/{{ $idApartamento }}/prop-def"
      class="prop-def" method="POST">
      @csrf
      <label for="novoProprietario">Definir Proprietário</label>
      <input type="text" name="novoProprietario">
      @error('novoProprietario')
        <x-error-msg :message="$message" />
      @enderror
      <button>Salvar</button>
    </form>
  @endif

  <br>
  <h2>Adicionar novo morador</h2>
  <div class="add-morador">
    <form action="/admin/condominios/edit/{{ $idCondominio }}/ap/{{ $num_ap }}/id/{{ $idApartamento }}/add-morador"
      method="POST">
      @csrf
      <input type="text" name="addMorador">
      <button>Adicionar</button>
      @error('addMorador')
        <x-error-msg :message="$message" />
      @enderror
    </form>
  </div>


  <h1>Moradores</h1>
  <div class="moradores">
    @foreach ($moradores as $morador)
      <span>
        {{ $morador->nome }}
        <form
          action="
          /admin/condominios/edit/{{ $idCondominio }}/ap/{{ $num_ap }}/morador/{{ $morador->condx_id }}"
          method="POST">
          @csrf
          @method('delete')
          <button>excluir</button>
        </form>
      </span>
    @endforeach
  </div>

</x-layout>
