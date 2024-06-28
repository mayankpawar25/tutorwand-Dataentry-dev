<script>
// Credit: Mateusz Rybczonec
answeredData = JSON.parse(localStorage.answeredResponse);
totalTime = answeredData.remainingTime;
const TIME_LIMIT = totalTime;
timePassed = 0;
timeLeft = TIME_LIMIT;

let timerInterval = null;
let remainingPathColor = COLOR_CODES.info.color;
if(totalTime){
  let examTimer = Math.round(answeredData.remainingTime);
  document.getElementById("timer").innerHTML = `<span id="base-timer-label">${formatTime(timeLeft)}</span>`;
}

function onTimesUp() {
  updatQuestionStatus();
  clearInterval(timerInterval);
  let answersArray = [];
  if(isOnline){
    msgToast("warning", timeUpText);
  }
  setInterval(() => {
    if($(`.paper-area`).attr(`style`) == "" || $(`.paper-area`).attr(`style`) == undefined){
        $(`.paper-area`).hide();
        $(`.submit-review-area`).show();
        if(isOnline){
          submitExam(paperId, studentID, feedBackScreenURL);
        }
    } else {
      submitExam(paperId, studentID, feedBackScreenURL);
    }
  }, fiveSeconds);
}

function startTimer() {
  timerInterval = setInterval(() => {
    timePassed = timePassed += 1;
    timeLeft = TIME_LIMIT - timePassed;
    answeredData.remainingTime = timeLeft;
    document.getElementById("base-timer-label").innerHTML = formatTime(
      timeLeft
    );
    setCircleDasharray();
    setRemainingPathColor(Math.floor(timeLeft / sixtyMinutes));

    if (timeLeft === 0) {
      timeLeft = 0;
      onTimesUp();
    }
    if (timeLeft < 0) {
      timeLeft = 0;
      onTimesUp();
    }
  }, 1000);
}

function formatTime(time) {
  const minutes = Math.floor(time / sixtyMinutes);
  let seconds = time % sixtyMinutes;

  if (seconds < 10) {
    seconds = `0${seconds}`;
  }
  return minutes<10 ? `0${minutes}:${seconds}`: `${minutes}:${seconds}`;
}

function setRemainingPathColor(timeLeft) {
  const { alert, warning, info } = COLOR_CODES;
  if (timeLeft <= alert.threshold) {
    
    $(".clock").css({
      'color': alert.color,
      'border': `1px solid ${alert.color}`,
      'background-color': `white`
    });
  }
}

function calculateTimeFraction() {
  const rawTimeFraction = timeLeft / TIME_LIMIT;
  return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
}

function setCircleDasharray() {
  const circleDasharray = `${( calculateTimeFraction() * FULL_DASH_ARRAY ).toFixed(0)} 283`;
}
</script>