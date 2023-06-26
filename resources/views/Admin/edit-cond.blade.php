@props(['cond'])
<x-layout>
  <a href="/admin/condominios">
    back
  </a>

  <h1>{{ $cond->nome }}</h1>
  <button id="changeNameBtn">mudar nome</button>

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
    <select name="turno" value="turno">
      <option value="0"></option>
      <option value="mat">Mat</option>
      <option value="ves">Ves</option>
      <option value="not">Not</option>
    </select>
    <button>
      Salvar
    </button>
  </form>

</x-layout>

<script>
  document.getElementById('changeNameBtn').addEventListener('click', function() {
    document.getElementById('editNameForm').style.display = 'block';
  });
</script>
