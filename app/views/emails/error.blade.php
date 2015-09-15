<p>On path {{{$url}}}:</p>
<p>having been passed:
<ul>
@forelse($input as $k => $v)
	<li>{{{$k}}}:{{{$v}}}</li>
@empty
	<li>Nothing</li>
@endforelse
</ul>
</p>
<pre>{{{$error}}}</pre>