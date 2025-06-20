// ⏰ Digital Clock
function updateDigitalClock() {
  const now = new Date();
  const timeString = now.toLocaleTimeString('pt-BR');
  document.getElementById('hora-digital').textContent = timeString;
}
setInterval(updateDigitalClock, 1000);
updateDigitalClock();

// 🧠 Matrix-Style Analog Clock
const canvas = document.getElementById("analog-clock");
const ctx = canvas.getContext("2d");
const radius = canvas.height / 2;
ctx.translate(radius, radius);

function drawMatrixClock() {
  drawFace(ctx, radius);
  drawNumbers(ctx, radius);
  drawTime(ctx, radius);
}

function drawFace(ctx, radius) {
  const gradient = ctx.createRadialGradient(0, 0, radius * 0.95, 0, 0, radius * 1.05);
  gradient.addColorStop(0, "#003300");
  gradient.addColorStop(0.5, "#00ff00");
  gradient.addColorStop(1, "#003300");

  ctx.beginPath();
  ctx.arc(0, 0, radius * 0.95, 0, 2 * Math.PI);
  ctx.fillStyle = "black";
  ctx.fill();

  ctx.strokeStyle = "#00ff00";
  ctx.lineWidth = radius * 0.0666666;
  ctx.stroke();

  ctx.beginPath();
  ctx.arc(0, 0, radius * 0.05, 0, 2 * Math.PI);
  ctx.fillStyle = "#00ff00";
  ctx.fill();
}

function drawNumbers(ctx, radius) {
  ctx.font = radius * 0.15 + "px 'Courier New', monospace";
  ctx.textBaseline = "middle";
  ctx.textAlign = "center";
  ctx.fillStyle = "#00ff00";

  for (let num = 1; num <= 12; num++) {
    let ang = num * Math.PI / 6;
    ctx.rotate(ang);
    ctx.translate(0, -radius * 0.82);
    ctx.rotate(-ang);
    ctx.fillText(num.toString(), 0, 0);
    ctx.rotate(ang);
    ctx.translate(0, radius * 0.82);
    ctx.rotate(-ang);
  }
}

function drawTime(ctx, radius) {
  const now = new Date();
  let hour = now.getHours();
  let minute = now.getMinutes();
  let second = now.getSeconds();

  hour = hour % 12;
  hour = (hour * Math.PI / 6) +
         (minute * Math.PI / (6 * 60)) +
         (second * Math.PI / (360 * 60));
  drawHand(ctx, hour, radius * 0.5, radius * 0.06);

  minute = (minute * Math.PI / 30) + (second * Math.PI / (30 * 60));
  drawHand(ctx, minute, radius * 0.75, radius * 0.06);

  second = (second * Math.PI / 30);
  drawHand(ctx, second, radius * 0.85, radius * 0.015, "#00ffcc");
}

function drawHand(ctx, pos, length, width, color = "#00ff00") {
  ctx.beginPath();
  ctx.lineWidth = width;
  ctx.lineCap = "round";
  ctx.moveTo(0, 0);
  ctx.rotate(pos);
  ctx.lineTo(0, -length);
  ctx.strokeStyle = color;
  ctx.stroke();
  ctx.rotate(-pos);
}

setInterval(drawMatrixClock, 1000);
drawMatrixClock();

