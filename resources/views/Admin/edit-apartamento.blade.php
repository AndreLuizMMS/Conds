@props(['num_ap', 'idCondominio', 'user', 'moradores'])
<x-layout>
  <x-sidebar :user="$user" />

  <a href="/admin/condominios/edit/{{ $idCondominio }}">back</a>

  <h1>Apartamento {{ $num_ap }}</h1>
  <h3>condominio {{ $idCondominio }}</h3>


  <br>
  <h2>Adicionar novo morador</h2>
  <div class="add-morador">
    <form action="/admin/condominios/edit/{{ $idCondominio }}/ap/{{ $num_ap }}/add-morador" method="POST">
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
