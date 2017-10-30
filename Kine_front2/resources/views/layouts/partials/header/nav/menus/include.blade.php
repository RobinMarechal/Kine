@forelse($nav as $n)
	<li id="{{ $n['id'] }}" class="nav-item">
		<a class="nav-link text-capitalize" href="{{ url($n['href']) }}">{{ $n['html'] }}</a>
	</li>
@empty
@endforelse