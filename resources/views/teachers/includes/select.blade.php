<tr>
    <td>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="21" viewBox="0 0 14 21"><g id="Group_225" data-name="Group 225" transform="translate(-234 -284)"><g id="Group_223" data-name="Group 223"><circle id="Ellipse_13" data-name="Ellipse 13" cx="2.5" cy="2.5" r="2.5" transform="translate(243 284)" fill="#ccc"/><circle id="Ellipse_14" data-name="Ellipse 14" cx="2.5" cy="2.5" r="2.5" transform="translate(243 292)" fill="#ccc"/><circle id="Ellipse_15" data-name="Ellipse 15" cx="2.5" cy="2.5" r="2.5" transform="translate(243 300)" fill="#ccc"/></g><g id="Group_224" data-name="Group 224" transform="translate(-9)"><circle id="Ellipse_13-2" data-name="Ellipse 13" cx="2.5" cy="2.5" r="2.5" transform="translate(243 284)" fill="#ccc"/><circle id="Ellipse_14-2" data-name="Ellipse 14" cx="2.5" cy="2.5" r="2.5" transform="translate(243 292)" fill="#ccc"/><circle id="Ellipse_15-2" data-name="Ellipse 15" cx="2.5" cy="2.5" r="2.5" transform="translate(243 300)" fill="#ccc"/></g></g></svg>
    </td>
    <td class="indexInput">${question_type}</td>
    <td>
        <input type="number" min="1" max="{{ config('constants.numberOfQuestionThreshold') }}" step="1" data-id="${question_id}" name="data[${question_type}]['numberOfQuestion']" class="form-control table-input count is_number onchangeValue"  data-value="${count}" value="${count}">
    </td>
    <td>
        <input type="number" min="0.5" max="{{ config('constants.weightageThreshold') }}" step="0.5" data-id="${question_id}" name="data[${question_type}]['weightage']" class="form-control table-input marks is_number onchangeValue"  data-value="${marks}" value="${marks}">
    </td>
    <td class="text-center total_marks">${subtotal}</td>
    <td>
        <span class="remove-table-tr remove" tabindex="0" role="button">{!! config('constants.icons.close-icon') !!}</span>
    </td>
</tr>
