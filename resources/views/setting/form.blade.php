@foreach ($settings as $key => $setting)
    <div class="mb-10">
        <label class="block text-gray-700 text-sm mb-2 border-b border-dashed">{{ $setting->label }}</label>
        @if($setting->field == 'number')
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $setting->param }}" type="number" value="{{ $setting->value }}">
        @elseif($setting->field == 'checkbox')
            @php
            $options = explode(',', $setting->options);
            if(count($options) > 0) {
                foreach ($options as $key => $option) {
                    echo '<div class="inline mr-5">
                        <input type="radio" name="'.$setting->param.'" value="'.$option.'" '.($setting->value == $option ? 'checked' : '').'>
                        <label>'.ucfirst($option).'</label>
                    </div>';
                }
            }
            @endphp
        @elseif($setting->field == 'textarea')
            <textarea name="{{ $setting->param }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $setting->value }}</textarea>
        @elseif($setting->field == 'datetime')
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $setting->param }}" type="datetime-local" value="{{ $setting->value }}">
        @elseif($setting->field == 'upload')
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $setting->param }}" type="file" value="">
        @else
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $setting->param }}" type="text" value="{{ $setting->value }}">
        @endif

        @if($setting->note)
            <br><small>{{ $setting->note }}</small>
        @endif

        @error($setting->param)
            <div notify="{{ $setting->id }}" class="bg-red-100 border-l-4 border-red-500 text-red-700 py-1 pl-2 my-2 text-sm">{{ $message }} <span class="cursor-pointer float-right mr-2" onclick="closeAlert('{{ $setting->id }}')">X</span></div>
        @enderror
    </div>
@endforeach