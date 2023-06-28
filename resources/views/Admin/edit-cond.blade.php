@props(['cond', 'sindicos', 'user'])
<x-layout>
  <x-sidebar :user="$user" />
  <a href="/admin/condominios">
    back
  </a>

  <h1>{{ $cond->nome }}</h1>
  <button id="changeNameBtn">mudar nome</button>

  <br>
  <br>
  <br>

  <div id="editNameForm" style="display: none;">
    <form action="/admin/condominios/edit-name/{{ $cond->id }}">
      <input type="text" name="nome">
      <button type="submit">salvar nome</button>
      @error('nome')
        <x-error-msg :message="$message" />
      @enderror
    </form>
  </div>

  <form action="/admin/condominios/add-sindico/{{ $cond->id }}/" class="add-sindico" method="POST">
    @csrf
    <label for="nome">Adicionar Sindico</label>
    <input type="text" name="nome">
    @error('nome')
      <x-error-msg :message="$message" />
    @enderror
    <select name="turno" value="turno">
      <option value="mat">Mat</option>
      <option value="ves">Ves</option>
      <option value="not">Not</option>
    </select>
    <button>
      Salvar
    </button>
  </form>

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

          <form action="/admin/condominios/delete-sindico/{{ $sindico->id }}" method="POST">
            @csrf
            @method('delete')
            <button>excluir</button>
          </form>

          <form action="">
            <button>edit</button>
          </form>
        </div>
      @endforeach
    </div>
  </div>

  <div class="aps">
    <h1>Apartamentos</h1>
    <div class="aps-info">
      @foreach ($apartamentos as $ap)
        <p>{{ $ap->num_ap }}</p>
        <a href="/admin/condominios/edit/{{ $cond->id }}/ap/{{ $ap->num_ap }}">
          <button>Ver mais</button>
        </a>
      @endforeach
    </div>
  </div>

</x-layout>

<script>
  document.getElementById('changeNameBtn').addEventListener('click', function() {
    document.getElementById('editNameForm').style.display = 'block';
  });
</script>
