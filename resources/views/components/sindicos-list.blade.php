@props(['sindico'])
<div class="sindico-list">
  <span class="nome">
    {{ $sindico->nome }}
  </span>

  <div class="options">
    <form action="sindicos/edit/{{ $sindico->id }}">
      <button>editar</button>
    </form>

    <form action="sindicos/delete/{{ $sindico->id }}"method="POST">
      @method('delete')
      @csrf
      <button>excluir</button>
    </form>
  </div>
</div>
