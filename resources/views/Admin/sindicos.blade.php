@props(['sindicos', 'user'])
<x-sidebar :user="$user" />
<x-layout>
  <br>
  <a href="/admin/home">
    back
  </a>

  <h1>Sindicos atuais</h1>

  @foreach ($sindicos as $sindico)
    <x-sindicos-list :sindico="$sindico" />
  @endforeach


  </div>

</x-layout>
