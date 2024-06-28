<div class="">

    <h5 class="get-filter-data"> </h5>

    <div class="table-responsive ">

        <table width="100%" cellspacing="0" cellpadding="0" class="table table-bordered">
            <tr>
                <th>Topic</th>
                <th>Sub Topic</th>
                <th>MCQ</th>
                <th>Fill in the blanks</th>
                <th>True and False</th>
                <th>Short Answer</th>
                <th>Long Answer</th>
                <th>SPR</th>
                <th>Unseen Passage 3</th>
                <th>Unseen Passage 4</th>
                <th>Unseen Passage 5</th>
                <th>Unseen Passage 7</th>
                <th>Total</th>
            </tr>

            @foreach ($reviewDashboardModels as $reviewDashboard)
                <tr>
                    <td>{{ $reviewDashboard['topic'] }}</td>
                    <td>{{ $reviewDashboard['subTopic'] }}</td>
                    <td>{{ $reviewDashboard['mcqCount'] }}</td>
                    <td>{{ $reviewDashboard['fibCount'] }}</td>
                    <td>{{ $reviewDashboard['tnfCount'] }}</td>
                    <td>{{ $reviewDashboard['shortAnswerCount'] }}</td>
                    <td>{{ $reviewDashboard['longAnswerCount'] }}</td>
                    <td>{{ $reviewDashboard['shortQuestionWithMulitpleCorrectAnswerCount'] }}</td>
                    <td>{{ $reviewDashboard['unseenPassage_3Count'] }}</td>
                    <td>{{ $reviewDashboard['unseenPassage_4Count'] }}</td>
                    <td>{{ $reviewDashboard['unseenPassage_5Count'] }}</td>
                    <td>{{ $reviewDashboard['unseenPassage_7Count'] }}</td>
                    <th>{{ $reviewDashboard['totalCount'] }}</th>
                </tr>

            @endforeach

            <tr>
                <th colspan="2">Grand Total</th>
                <th>{{ $grandTotal['mcqCount'] }}</th>
                <th>{{ $grandTotal['fibCount'] }}</th>
                <th>{{ $grandTotal['tnfCount'] }}</th>
                <th>{{ $grandTotal['shortAnswerCount'] }}</th>
                <th>{{ $grandTotal['longAnswerCount'] }}</th>
                <th>{{ $grandTotal['shortQuestionWithMulitpleCorrectAnswerCount'] }}</th>
                <th>{{ $grandTotal['unseenPassage_3Count'] }}</th>
                <th>{{ $grandTotal['unseenPassage_4Count'] }}</th>
                <th>{{ $grandTotal['unseenPassage_5Count'] }}</th>
                <th>{{ $grandTotal['unseenPassage_7Count'] }}</th>
                <th>{{ $grandTotal['totalCount'] }}</th>
            </tr>

        </table>

    </div>

</div>