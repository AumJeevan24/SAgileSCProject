@section('dashboard')
    @foreach($pro as $pros)
        <li>
            <a href="{{ action('ProductFeatureController@index2', $pros['proj_name']) }}">
                {{ $pros['proj_name'] }} 
            </a>
        </li>
    @endforeach    
@endsection
