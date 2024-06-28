<select {{ $attributes->merge(['class' => $typeClass(), 'id' => $id, 'name' => $name, 'label' => $label]) }} >
    @if ($label)
        <option value=" ">{{ $label }}</option>
    @endif
    @if(!empty($options))
	    @foreach ($options as $option)
	        <option value="{{ $option[$optionkey] }}" {{ $selectedValue($option[$optionkey]) }} {{ $isSelected($option[$optionkey]) ? 'selected="selected"' : '' }}>{{ $option[$optionvalue] }}</option>
	    @endforeach
    @endif
</select>
