@props(['sindico', 'user', 'turnos'])
<x-layout>
  <x-sidebar :user="$user" />
  <a href="/admin/sindicos">
    back
  </a>

  <h1 id="sindicoNome">{{ $sindico->nome }}</h1>
  <button id="changeNameBtn">mudar nome</button>

  <div id="editNameForm" style="display: none;">
    <form action="/admin/sindicos/nome-sindico/{{ $sindico->id }}" method="POST">
      @csrf<br>
      <input type="text" name="novoNome">
      <br><br>
      <button>salvar</button>
    </form>
  </div>

  <h1>Turnos</h1>
  <div class="turnos">
    <div class="info">
      <span>Condominio</span>
      <span>Horário</span>
    </div>
    <div class="info-value">
      @foreach ($turnos as $turno)
      <div class="info-value-val">
        <span>{{ $turno->nome }}</span>
        <span>{{ $turno->turno }}</span>
      </div>
      @endforeach
    </div>
  </div>


</x-layout>

<script>
  document.getElementById('changeNameBtn').addEventListener('click', function() {
    document.getElementById('editNameForm').style.display = 'block';
  });
</script>
