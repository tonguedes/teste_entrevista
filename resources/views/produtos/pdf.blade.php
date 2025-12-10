<!doctype html>
<html>
<head>
  <!-- Define character encoding -->
  <meta charset="utf-8">

  <!-- Page title -->
  <title>Lista de Produtos</title>

  <!-- Inline CSS styles -->
  <style>
    /* Set default font and size for the page */
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; }

    /* Make table full width, collapse borders, add top margin */
    table { width:100%; border-collapse: collapse; margin-top:10px; }

    /* Add padding, border, and text alignment for table cells */
    th, td { padding:8px; border:1px solid #ddd; text-align:left; }

    /* Set background color for table headers */
    th { background: #f4f4f4; }

    /* Remove default margin for h2 headings */
    h2 { margin:0; }
  </style>
</head>
<body>
  <!-- Main heading -->
  <h2>Lista de Produtos</h2>

  <!-- Table to display products -->
  <table>
    <thead>
      <tr>
        <!-- Table headers -->
        <th>ID</th>
        <th>Nome</th>
        <th>Preço</th>
      </tr>
    </thead>
    <tbody>
      <!-- Loop through products and display each in a row -->
      @foreach($produtos as $p)
      <tr>
        <td>{{ $p->id }}</td> <!-- Product ID -->
        <td>{{ $p->nome }}</td> <!-- Product Name -->
        <td>R$ {{ number_format($p->preco, 2, ',', '.') }}</td> <!-- Product Price formatted as BRL -->
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
