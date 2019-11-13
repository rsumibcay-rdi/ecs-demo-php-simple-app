document.addEventListener('DOMContentLoaded', function(){
    var q = document.getElementById('quiz');

if (q){
    var questions = document.getElementsByClassName('question'),
        nextBtn = document.getElementById('next'),
        prevBtn = document.getElementById('previous'),
        submitBtn = document.getElementById('submit'),
        progressBar = document.getElementById('progress-inner'),
        slider = document.getElementById('slider'),
        radios = document.getElementsByClassName('radio'),
        scoreInput = document.getElementById('score'),
        answersInput = document.getElementById('answers'),
        form = document.querySelector('[data-slug="quiz-form"]'),
        answers = [],
        selected = [],
        points = 0,
        progress = 0,
        sliding = 0,
        progressStr,
        key,
        value,
        newInput;

    slider.addEventListener('change', function(event){
        nextBtn.disabled = false;
    })

    quiz.addEventListener('click', function(event){
        if (nextBtn === event.target){

            // slide the slider
            if (sliding > questions.length * (-100)){
                sliding -= 100;
                slide_to()
            }
            progress = (1/questions.length) * (sliding * -1);

            // update the progress bar
            progressStr = Math.round(progress)+"%";
            if (progress < 101){
                progressBar.style.width = progressStr;
                progressBar.innerHTML = progressStr+"&nbsp;&nbsp;";
                nextBtn.disabled = true;
            }
            // remove the prev/next buttons after the Questions
        }

        if (progressStr === "100%"){
            nextBtn.parentNode.style.visibility = 'hidden';
        }
        // slide to da left
        if (prevBtn === event.target){
            if (sliding < 0){
                sliding += 100;
                slide_to();
            }
        }

        if (submitBtn === event.target){
            // build array of selected answers
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked){
                    selected.push(radios[i]);
                }
            }
            // get points and answer text
            for (var i = 0; i < selected.length; i++) {
                if (answers.length < questions.length){
                    points += parseInt(selected[i].dataset.points, 10);
                    answers.push(selected[i].parentNode.innerText);
                }
            }

            // build question-answer hidden inputs to send to HubSpot
            for (var i = 0; i < questions.length; i++) {
                key = questions[i].dataset.hsfield;
                value = selected[i].parentNode.innerText;
                makeHiddenInput(key, value);
            }
            // submit score to hidden HTML form input
            scoreInput.value = points;
            makeHiddenInput('hubspot_form_id', q.dataset.hsform);
            makeHiddenInput('page_id', q.dataset.id);
            makeHiddenInput('module_key', q.dataset.key);
        }
    });

    if (typeof html_forms === 'undefined'){
        setTimeout(function(){}, 500); // hope for the best
    } else {
        html_forms.on('success', function(){
            var q = document.getElementById("quiz"),
                params = new FormData();

            params.set("action", "quiz_results");
            params.set("pageId", q.dataset.id);
            params.set("moduleKey", q.dataset.key);
            params.set("survey_score", points);

            request(hf_js_vars.ajax_url, params);
        });
    }

    function slide_to(amt){
        amt = sliding || amt;
        slider.style.transform = "translateX("+sliding+"%)";
    }

    function results_slide(r){
        if (r){
            slider.lastElementChild.insertAdjacentHTML('afterend', r)
            sliding -= 100;
            slide_to();
        }
    }

    function makeHiddenInput(key, value){
        newInput = document.createElement('input');
        newInput.setAttribute('name', key);
        newInput.setAttribute('type', 'hidden');
        newInput.setAttribute('value', value);
        form.appendChild(newInput);
    }

    function request(url, data){
        var httpRequest = new XMLHttpRequest();

        if (!httpRequest){
            console.log('Error with ajax request');
            return false;
        }
        httpRequest.onreadystatechange = function(){
            if (httpRequest.readyState != 4 || httpRequest.status != 200) return;

            results_slide(httpRequest.responseText);
        };
        httpRequest.open('POST', url);
        httpRequest.send(data);
    }
}

});
