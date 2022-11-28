<p class="card-text">
<ul>
    @if(is_array($data))
    @foreach($data as $d)
    <li>{{ trim(ucfirst($d)) }}</li>
    @endforeach
    @else
    <li>{{ ucfirst($data) }}</li>
    @endif
</ul>
</p>
