document.getElementById('quizForm').addEventListener('submit', function(event) {
    var questions = JSON.parse(document.getElementById('questionsData').textContent);
    var allAnswered = true;

    questions.forEach(function(question) {
        var radios = document.getElementsByName('answers[' + question.id + ']');
        var answered = false;
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                answered = true;
                break;
            }
        }
        if (!answered) {
            allAnswered = false;
        }
    });

    if (!allAnswered) {
        event.preventDefault();
        alert('全ての質問に回答してください。');
    }
});