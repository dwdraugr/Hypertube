<video controls width="640" height="480">
    @foreach($videos as $type => $name)
        <source src="{{ $name }}" type="video/{{ $type }}">
    @endforeach

    @for($i = 1; $i <= count($subtitles); $i++)
        <track src="{{ $subtitles[$i] }}" kind="subtitles" label="subs-{{ $i }}">
    @endfor
</video>
