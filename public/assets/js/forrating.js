window.onload = () => {
    let p = document.querySelector('.reply_title');
    let undo = document.querySelector('#undo');

    undo.addEventListener("click", ()=>  {
        p.textContent = "Add new Review " ;
        undo.textContent = "";
        document.querySelector("#comments_parentid").value = null;



    })



    document.querySelectorAll("[data-reply]").forEach(element => {
        element.addEventListener("click", function(){
            document.querySelector("#comments_parentid").value = this.dataset.id;
            p.textContent = "Reply to " + this.dataset.name ;
            undo.textContent = "Undo Replay";
        });
    });

}
const ratingStars = [...document.getElementsByClassName("rating__star")];
const ratingResult = document.querySelector(".rating__result");

printRatingResult(ratingResult);

function executeRating(stars, result) {
    const starClassActive = "rating__star fas fa-star fa-2x";
    const starClassUnactive = "rating__star far fa-star fa-2x";
    const starsLength = stars.length;
    let i;
    stars.map((star) => {
        star.onclick = () => {
            i = stars.indexOf(star);

            if (star.className.indexOf(starClassUnactive) !== -1) {
                printRatingResult(result, i + 1);
                for (i; i >= 0; --i) stars[i].className = starClassActive;
            } else {
                printRatingResult(result, i);
                for (i; i < starsLength; ++i) stars[i].className = starClassUnactive;
            }
        };
    });
}

function printRatingResult(result, num = 0) {
    result.textContent = `${num}/5`;
    document.querySelector("#comments_stars").value= num ;

}
executeRating(ratingStars, ratingResult);
