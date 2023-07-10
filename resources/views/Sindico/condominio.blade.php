@props(['condominio'])

<x-layout>
  <x-sidebar />
  <h1>Condominios</h1>
  <div class="conds-sindico">
    @foreach ($condominios as $condominio)
      <div>
        <p>{{ $condominio->nome }}</p>
        <a href="/sindico/condominio/{{ $condominio->id }}">
          <button>Ver mais</button>
        </a>
      </div>
    @endforeach
  </div>
</x-layout>
