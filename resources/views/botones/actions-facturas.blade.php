

@section('css')
    


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-" crossorigin="anonymous" />

@endsection
<body class="bg-gray-100 p-4" >
    <div class="btn-wrapper" style="width: 250px">
        <a href="{{ route('facturas.show', $id) }}"  class="btn btn-purple">
            <i class="fas fa-eye"></i>
            <span class="tooltip">Ver</span>
        </a>
       
        <button type="button" class="btn btn-orange delete-btn" data-id="{{ $id }}">
            <i class="fas fa-trash"></i>
            <span class="tooltip">Eliminar</span>
        </button>
    </div>

    <!-- FontAwesome CDN -->
    
</body>