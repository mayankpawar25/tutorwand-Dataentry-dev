<!-- People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius -->
<button {{ $attributes->merge(['type' => $type, 'class' => $class, 'id' => $id, 'name' => $name]) }} {{ $disabledKey }}> {{ $label }} </button>

<!-- Example : - <x-button type="button / submit" class="form-control" id="id" name="marks" disabledKey="disabled"></x-button> -->
