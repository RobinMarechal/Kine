@forelse($nav as $n)
	<li id="{{ $n['id'] }}" class="hvr-underline-from-center"><a href="{{ url($n['href']) }}">{{ $n['html'] }}</a></li>
@empty
@endforelse