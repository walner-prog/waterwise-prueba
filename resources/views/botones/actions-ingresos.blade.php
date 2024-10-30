

@section('css')
    


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-" crossorigin="anonymous" />

@endsection
<body class="bg-gray-100 p-4" style="width: 270px">
    <div class="btn-wrapper">
        <a href="{{ route('ingresos.show', $id) }}" target="_blank" class="btn btn-purple">
            <i class="fas fa-eye"></i>
        
        </a>
        
        <button type="button" class="btn btn-orange delete-btn" data-id="{{ $id }}">
            <i class="fas fa-trash"></i>
           
        </button>
    </div>

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>