$('[jextstyle]').append("[canvas-src^='word2,']{background-color: #000;}");
$.task.push(function(){
	_('[canvas-src^="word2,"]').each(function(){
		var thi = $(this);
		thi.append('<canvas width="1920" height="572"></canvas>');
		var CANVAS = thi.find('canvas')[0];
		const CTX = CANVAS.getContext("2d");
		const CHARS = [];
		const MAX_CHARS = 360;
		const SEPARATION = 2.5;

		let ww, wh, camera;

		class Vector {
			constructor(x, y, z) {
				this.x = x;
				this.y = y;
				this.z = z;
			}

			rotate(dir, ang) {
				const X = this.x;
				const Y = this.y;
				const Z = this.z;

				const SIN = Math.sin(ang);
				const COS = Math.cos(ang);

				if (dir === "x") {
					this.y = Y * COS - Z * SIN;
					this.z = Y * SIN + Z * COS;
				} else if (dir === "y") {
					this.x = X * COS - Z * SIN;
					this.z = X * SIN + Z * COS;
				}
			}

			project() {
				const ZP = this.z + camera.z;
				const DIV = ZP / 600;
				const XP = (this.x + camera.x) / DIV;
				const YP = (this.y + camera.y) / DIV;
				const CENTER = getCenter();
				return [XP + CENTER[0], YP + CENTER[1], ZP];
			}
		}

		class Char {
			constructor(letter, pos) {
				this.letter = letter;
				this.pos = pos;
			}

			rotate(dir, ang) {
				this.pos.rotate(dir, ang);
			}

			render() {
				const PIXEL = this.pos.project();
				const XP = PIXEL[0];
				const YP = PIXEL[1];
				const MAX_SIZE = 50;
				const SIZE = (1 / PIXEL[2] * MAX_SIZE) | 0;
				const BRIGHTNESS = SIZE / MAX_SIZE;
				const COL = `rgba(255, 255, ${100 * BRIGHTNESS | 0 + 150}, ${BRIGHTNESS})`;
				
				CTX.beginPath();
				CTX.fillStyle = COL;
				CTX.font = SIZE + "px monospace";
				CTX.fillText(this.letter, XP, YP);
				CTX.fill();
				CTX.closePath();
			}
		}

		function getCenter() {
			return [ww / 2, wh / 2];
		}

		function signedRandom() {
			return Math.random() - Math.random();
		}

		function render() {
			for (let i = 0; i < CHARS.length; i++) {
				CHARS[i].render();
			}
		}
		
		let time = 0;
		function update() {
			CTX.clearRect(0, 0, ww, wh);
			for (let i = 0; i < CHARS.length; i++) {
				const DX = 0.005 * Math.sin(time * 0.001);
				const DY = 0.005 * Math.cos(time * 0.001);
				CHARS[i].rotate("x", DX);
				CHARS[i].rotate("y", DY);
			}
			++time;
		}

		function loop() {
			window.requestAnimationFrame(loop);
			update();
			render();
		}
		
		function getRandomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		};

		function createChars() {
			for (let i = 0; i < MAX_CHARS; i++) {
				const CHARACTER = String.fromCharCode((Math.random() * 93 + 34) | 0);
				const X = signedRandom() * SEPARATION;
				const Y = signedRandom() * SEPARATION;
				const Z = signedRandom() * SEPARATION;
				const POS = new Vector(X, Y, Z);
				const CHAR = new Char(CHARACTER, POS);
				CHARS.push(CHAR);
			}
		}

		function setDim() {
			ww = thi.width();
			wh = thi.height();
			CANVAS.width = ww;
			CANVAS.height = wh;
		}

		function initCamera() {
			camera = new Vector(0, 0, SEPARATION + 1);
		}

		window.onresize = setDim;

		(() => {
			setDim();
			initCamera();
			createChars();
			loop();
		})();
	});
});