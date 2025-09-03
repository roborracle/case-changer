@props(['title' => 'Case Changer Pro', 'description' => 'Professional text transformation tools'])

<x-layouts.app :title="$title" :description="$description">
    @yield('content')
</x-layouts.app>