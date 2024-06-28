<div>
    <table class='table mb-0'>
        @php
            $totalMarks = 0;
            $totalQuestions = 0;
        @endphp
        @foreach ($data as $value)
            @php
                $totalQuestions += $value['numberOfQuestion'];
                $totalMarks += ($value['numberOfQuestion'] * $value['weightage']);
                $assignmentFormatName = getTemplateName($value['questionTypeId']);
            @endphp
            <tr>
                <td width='70%' class='text-ellipse-1'>{{ $assignmentFormatName }}</td>
                <td  width='10%' class='text-right'>{{ $value['numberOfQuestion'] }}</td>
                <td  width='10%' class='text-center'>X</td>
                <td  width='10%' class='text-right'>{{ $value['weightage'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td width='70%' class='text-ellipse-1'>{{ __('teachers.assessment.total') }}</td>
            <td  width='10%' class='text-right'>{{ $totalQuestions }}</td>
            <td  width='10%' class='text-center'> </td>
            <td  width='10%' class='text-right'>{{ $totalMarks }}</td>
        </tr>
    </table>
</div>
