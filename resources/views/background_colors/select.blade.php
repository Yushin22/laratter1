<form action="{{ route('background-colors.store') }}" method="post">
    @csrf
    <label for="color_id">背景色を選択してください：</label>
    <select name="color_id" id="color_id">
        @foreach ($colors as $color)
            <option value="{{ $color->id }}">{{ $color->name }}</option>
        @endforeach
    </select>
    <button type="submit">選択</button>
</form>
