@php
    $eData = "";
    if (isset($type) && $type == 419) {
@endphp
        <script>
            window.location.href = '{{ route("home_page") }}'; //using a named route
        </script>
@php
    }
    if (isset($error) && !empty($error)) {
        $printData = [];
        foreach($error as $data) {
            array_push($printData, $data['totalAvailableCount'].' '.getQuestionTypeById($data['questionType']));
        }
        $eData = implode(', ', array_unique($printData));
    }
@endphp
<div class="insufficient-question">
    {{ $eData }}
</div>
