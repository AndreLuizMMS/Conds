@props(['cond'])
<div class="condominios-list">
  <span class="nome">
    {{ $cond->nome }}
  </span>

  <div class="options">
    <form action="condominios/edit/{{ $cond->id }}">
      <button>editar</button>
    </form>

    <form action="condominios/delete/{{ $cond->id }}"method="POST">
      @method('delete')
      @csrf
      <button>excluir</button>
    </form>
  </div>
</div>
