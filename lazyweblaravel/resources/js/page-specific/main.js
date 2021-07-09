

/* -------- Full Page Scroll App -------- */
new fullScroll({
    mainElement: "main",
    displayDots: true,
    dotsPosition: "left",
    animateTime: 0.7,
    animateFunction: "ease",
    transitionItems: []
});







 /* ------------------------ Page 2 Animation Trigger ------------------------ */
let animationToggleFlag = false;

let onIntersectionCallback = (entries, observer) => {
    entries.forEach(entry =>{
        if (entry.isIntersecting) {
            if (!animationToggleFlag) {
                animationToggleFlag = true;
                document.getElementById('skill1').classList.add('fade-1s');
                document.getElementById('skill2').classList.add('fade-2s');
                document.getElementById('skill3').classList.add('fade-3s');
            }
        }
    });
}

let pageOnViewDetector = new IntersectionObserver(onIntersectionCallback, {
    root: document.querySelector(null),
    rootMargin: '0px',
    threshold: 0.3
});

let target = document.querySelector('#skillContainer');
pageOnViewDetector.observe(target);




