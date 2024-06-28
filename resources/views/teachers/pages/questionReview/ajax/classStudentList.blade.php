<select data-students class="selectAssignGroup" multiple name="select_students">
    @foreach ($studentGroups as $key => $studentGroup)
        @if (isset($studentGroup['students']) && !empty($studentGroup['students']))
            @if (count($studentGroup['students']) > 0)
                <optgroup  data-type="courses" data-value="{{ $studentGroup['courseId'] }}" label="{{ $studentGroup['courseName'] }}">
                @foreach ($studentGroup['students'] as $value)
                    @if ($value['givenName'] != null)
                        <option value="{{ $studentGroup['courseId'] }}_{{$value['googleId']}}" data-type="googleid" data-value="{{ $value['googleId'] }}" data-name="{{ $value['givenName'] }}" data-profilepic="{{ $value['photoUrl'] }}" data-email="{{ $value['emailId'] }}">{{ $value['givenName'] }}</option>
                    @endif
                @endforeach
                </optgroup>
            @endif
        @endif
    @endforeach
</select>