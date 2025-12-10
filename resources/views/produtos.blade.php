<!doctype html>
<html>
<head>
  <!-- Sets the character encoding for the document -->
  <meta charset="utf-8">

  <!-- Ensures proper scaling on mobile devices -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Includes compiled CSS and JS assets using Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Adds Livewire styles (for Livewire components styling) -->
  @livewireStyles
</head>
<body class="bg-gray-50 p-8">
  <!-- Renders the Livewire 'produtos' component -->
  <livewire:produtos />

  <!-- Includes Livewire scripts (required for component reactivity and AJAX) -->
  @livewireScripts
</body>
</html>
