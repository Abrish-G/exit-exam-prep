let timeLeft = 7200;

function updateTimer(){

    let hours =
        Math.floor(timeLeft / 3600);

    let minutes =
        Math.floor((timeLeft % 3600) / 60);

    let seconds =
        timeLeft % 60;

    document.getElementById("timer")
    .innerHTML =
        `${hours}:${minutes}:${seconds}`;

    timeLeft--;

    if(timeLeft < 0){

        alert("Time is up!");

        document.getElementById("examForm")
        .submit();
    }
}

setInterval(updateTimer, 1000);