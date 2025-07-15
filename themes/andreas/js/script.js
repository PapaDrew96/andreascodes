jQuery(document).ready(function ($) {

	$('#burger-toggle').on('click', function () {
		$('#site-navigation').toggleClass('active');
	});

	var swiper = new Swiper('.my-services-slider', {
	effect: 'fade',
	speed: 800,
	fadeEffect: { crossFade: true },
	slidesPerView: 1,
	spaceBetween: 0,
	loop: false,
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},
	pagination: {
		el: '.swiper-pagination',
		clickable: true,
	},
});

 if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
    console.warn('GSAP or ScrollTrigger not loaded');
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  const cards = document.querySelectorAll('.project-card-wrapper');

  cards.forEach((card, index) => {
    // Random direction: up, down, left, right
    const directions = [
      { x: 0, y: -150 }, // up
      { x: 0, y: 150 },  // down
      { x: -150, y: 0 }, // left
      { x: 150, y: 0 },  // right
    ];
    const dir = directions[index % directions.length];
    const rotateRand = gsap.utils.random(-10, 10);

    gsap.fromTo(
      card,
      {
        opacity: 0,
        x: dir.x,
        y: dir.y,
        rotate: rotateRand
      },
      {
        opacity: 1,
        x: 0,
        y: 0,
        rotate: 0,
        duration: 1.2,
        ease: 'power4.out',
        scrollTrigger: {
          trigger: card,
          start: 'top 90%',
          toggleActions: 'play none none none'
        }
      }
    );
  });

  const snippets = document.querySelectorAll('.code-snippet-card-wrapper');

	snippets.forEach((snippet, index) => {
		const directions = [
			{ x: 0, y: -120 }, // up
			{ x: 0, y: 120 },  // down
			{ x: -120, y: 0 }, // left
			{ x: 120, y: 0 },  // right
		];
		const dir = directions[index % directions.length];
		const rotateRand = gsap.utils.random(-8, 8);

		gsap.fromTo(snippet,
			{
				opacity: 0,
				x: dir.x,
				y: dir.y,
				rotate: rotateRand,
				scale: 0.95,
				filter: 'blur(4px)'
			},
			{
				opacity: 1,
				x: 0,
				y: 0,
				rotate: 0,
				scale: 1,
				filter: 'blur(0px)',
				duration: 1.4,
				ease: 'expo.out',
				scrollTrigger: {
					trigger: snippet,
					start: 'top 90%',
					toggleActions: 'play none none none'
				}
			}
		);
	});

	
});
