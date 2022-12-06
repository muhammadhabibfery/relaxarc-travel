<p class="card-text">
<ul class="list-unstyled">
    @if(is_array($data))
    @foreach($data as $d)
    <li>{{ trim(ucfirst($d)) }}</li>
    @endforeach
    @else
    <li>{{ ucfirst($data) }}</li>
    @endif
</ul>
</p>
