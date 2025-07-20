document.addEventListener("DOMContentLoaded", () => {
	if (typeof STACK_ICONS === 'undefined' || !STACK_ICONS.length) return;

	const startBtn = document.getElementById("start-game-btn");
	const canvas = document.getElementById("catch-the-stack");
	const ctx = canvas.getContext("2d");

	let player = {
		x: 0,
		y: 0,
		width: 50,
		height: 50,
		speed: 7,
		color: "#00FFAA"
	};

	let icons = [];
	let score = 0;
	let keys = {};
	let canvasWidth, canvasHeight;

	function resizeCanvas() {
		canvasWidth = Math.min(window.innerWidth - 40, 800);
		canvasHeight = 600;
		canvas.width = canvasWidth;
		canvas.height = canvasHeight;

		player.x = canvasWidth / 2 - 25;
		player.y = canvasHeight - 60;
	}

	function setupIcons() {
		icons = [];
		STACK_ICONS.forEach(icon => {
			let img = new Image();
			img.src = icon.url;
			img.onload = () => {
				icons.push({
					...icon,
					img,
					x: Math.random() * (canvas.width - 40),
					y: -Math.random() * 500,
					width: 40,
					height: 40,
					speed: Math.random() * 2 + 1
				});
			};
		});
	}

	function checkCollision(a, b) {
		return (
			a.x < b.x + b.width &&
			a.x + a.width > b.x &&
			a.y < b.y + b.height &&
			a.y + a.height > b.y
		);
	}

	function updatePlayer() {
		if (keys["ArrowLeft"] && player.x > 0) player.x -= player.speed;
		if (keys["ArrowRight"] && player.x < canvas.width - player.width) player.x += player.speed;
	}

	function updateIcons() {
		for (let icon of icons) {
			icon.y += icon.speed;

			if (icon.y > canvas.height) {
				icon.y = -40;
				icon.x = Math.random() * (canvas.width - icon.width);
			}

			if (checkCollision(player, icon)) {
				score++;
				icon.y = -40;
				icon.x = Math.random() * (canvas.width - icon.width);
			}
		}
	}

	function drawPlayer() {
		ctx.fillStyle = player.color;
		ctx.fillRect(player.x, player.y, player.width, player.height);
	}

	function drawIcons() {
		for (let icon of icons) {
			ctx.drawImage(icon.img, icon.x, icon.y, icon.width, icon.height);
		}
	}

	function drawScore() {
		ctx.fillStyle = "white";
		ctx.font = "20px monospace";
		ctx.fillText("Score: " + score, 20, 30);
	}

	function gameLoop() {
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		updatePlayer();
		updateIcons();
		drawPlayer();
		drawIcons();
		drawScore();
		requestAnimationFrame(gameLoop);
	}

	function enableTouchControls() {
		canvas.addEventListener("touchstart", handleTouch);
		canvas.addEventListener("touchmove", handleTouch);
	}

	function handleTouch(e) {
		const touchX = e.touches[0].clientX - canvas.getBoundingClientRect().left;
		if (touchX < canvas.width / 2) {
			keys["ArrowLeft"] = true;
			keys["ArrowRight"] = false;
		} else {
			keys["ArrowLeft"] = false;
			keys["ArrowRight"] = true;
		}
	}

	startBtn.addEventListener("click", () => {
		startBtn.style.display = "none";
		canvas.style.display = "block";

		resizeCanvas();
		setupIcons();
		enableTouchControls();

		document.addEventListener("keydown", e => keys[e.key] = true);
		document.addEventListener("keyup", e => keys[e.key] = false);
		window.addEventListener("resize", resizeCanvas);

		// ✅ Background music setup
		const music = document.getElementById("game-music");
		const toggleSoundBtn = document.getElementById("toggle-sound");
		const soundOnIcon = document.getElementById("sound-on");
		const soundOffIcon = document.getElementById("sound-off");

		if (music) {
			music.volume = 0.5;
			music.play().catch(() => {
				console.warn("Autoplay blocked until user interacts.");
			});

			if (toggleSoundBtn) {
				toggleSoundBtn.addEventListener("click", () => {
					if (music.paused) {
						music.play();
						if (soundOnIcon) soundOnIcon.style.display = "inline";
						if (soundOffIcon) soundOffIcon.style.display = "none";
					} else {
						music.pause();
						if (soundOnIcon) soundOnIcon.style.display = "none";
						if (soundOffIcon) soundOffIcon.style.display = "inline";
					}
				});
			}
		}

		gameLoop();
	});
});
