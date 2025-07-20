console.log("Lightning click effect loaded");

const canvas = document.getElementById("lightning-canvas");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

window.addEventListener("resize", () => {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
});

function drawLightning(x1, y1, x2, y2, segments = 50) {
  let dx = (x2 - x1) / segments;
  let dy = (y2 - y1) / segments;

  ctx.beginPath();
  ctx.moveTo(x1, y1);

  for (let i = 0; i < segments; i++) {
    let offsetX = (Math.random() - 0.5) * 25;
    let offsetY = (Math.random() - 0.5) * 25;
    let cx = x1 + dx * i + offsetX;
    let cy = y1 + dy * i + offsetY;
    ctx.lineTo(cx, cy);
  }

  ctx.lineTo(x2, y2);
  ctx.strokeStyle = "rgba(0, 255, 0, 0.8)";
  ctx.lineWidth = 1.5;
  ctx.shadowColor = "#00ff00";
  ctx.shadowBlur = 15;
  ctx.stroke();
}

function clearCanvas() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
}

document.addEventListener("click", (e) => {
  const endX = e.clientX;
  const endY = e.clientY;

  for (let i = 0; i < 3; i++) {
    const delay = i * 100; // 0ms, 100ms, 200ms
    setTimeout(() => {
      const startX = Math.random() * canvas.width;
      const startY = 0;
      drawLightning(startX, startY, endX, endY);
    }, delay);
  }

  // Clear everything after 1 second
  setTimeout(clearCanvas, 1000);
});
