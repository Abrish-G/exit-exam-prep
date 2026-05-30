document.querySelectorAll('.option-radio')
.forEach(radio => {

    radio.addEventListener('change', function(){

        let parent =
            this.closest('.card');

        let resultBox =
            parent.querySelector('.result-box');

        let selected =
            this.value;

        let correct =
            this.dataset.correct;

        let explanation =
            this.dataset.explanation;

        if(selected == correct){

            resultBox.innerHTML = `
                <div class="alert alert-success">
                    Correct ✅ <br>
                    ${explanation}
                </div>
            `;

        }else{

            resultBox.innerHTML = `
                <div class="alert alert-danger">
                    Wrong ❌ <br>
                    Correct Answer: ${correct}<br>
                    ${explanation}
                </div>
            `;
        }
    });

});