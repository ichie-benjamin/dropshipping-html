
        var canvasID = 'particles',
            canvas = document.getElementById(canvasID);

        function initHeader() {
            width = $headerSizer.width();
            height = $headerSizer.height();

            canvas = document.getElementById('particles');
            canvas.width = width;
            canvas.height = height;
            ctx = canvas.getContext('2d');

            circles = [];
            for(var x = 0; x < width * 0.5; x++) {
                var c = new Circle();
                circles.push(c);
            }
            animate();
        }

        function addListeners() {
            window.addEventListener('scroll', scrollCheck);
            window.addEventListener('resize', resize);
        }

        function scrollCheck() {
            if (document.body.scrollTop > height) {
                animateHeader = false;
            } else {
                animateHeader = true;
            }
        }

        function resize() {
            width = $headerSizer.width();
            height = $headerSizer.height();
            canvas.width = width;
            canvas.height = height;
        }

        function animate() {
            if(animateHeader) {
                ctx.clearRect(0, 0, width, height);
                for(var i in circles) {
                    circles[i].draw();
                }
            }
            requestAnimationFrame(animate);
        }

        function Circle() {
            var self = this;

            (function() {
                self.pos = {};
                init();
            })();

            function init() {
                self.pos.x = Math.random() * width;
                self.pos.y = height + Math.random() * 100;
                self.alpha = 0.1 + Math.random() * 0.3;
                self.scale = 0.1 + Math.random() * 0.3;
                self.velocity = Math.random();
            }

            this.draw = function() {
                if(self.alpha <= 0) {
                    init();
                }
                self.pos.y -= self.velocity;
                self.alpha -= 0.0004;
                ctx.beginPath();
                ctx.arc(self.pos.x, self.pos.y, self.scale * 10, 0, 2 * Math.PI, false);
                ctx.fillStyle = 'rgba(255,255,255,' + self.alpha + ')';
                ctx.fill();
            };
        }

        if (canvas) {

            var $headerSizer, width, height, ctx, circles, animateHeader = true;
          
            $headerSizer = $('.full-slider');

            initHeader();
            addListeners();

        }