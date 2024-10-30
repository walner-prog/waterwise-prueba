

@section('css')
    


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-" crossorigin="anonymous" />

@endsection
<body class="bg-gray-100 p-4" style="width: 270px">
    <div class="btn-wrapper">
        <a href="{{ route('medidores.show', $id) }}" target="_blank" class="btn btn-purple">
            <i class="fas fa-eye"></i>
            <span class="tooltip">Ver</span>
        </a>
        <a href="{{ route('medidores.edit', $id) }}" class="btn btn-green">
            <i class="fas fa-edit"></i>
            <span class="tooltip">Editar</span>
        </a>

       
        <button type="button" class="btn btn-orange delete-btn" data-id="{{ $id }}">
            <i class="fas fa-trash"></i>
            <span class="tooltip">Eliminar</span>
        </button>
    </div>

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>