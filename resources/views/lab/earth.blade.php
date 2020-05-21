@extends('layouts.page', ['nav' => 'none'])

@section('content')
    <canvas style="pointer-events: none; background-color: #87ceeb; top: 0; left: 0;" class="position-absolute w-100 h-100"></canvas>

    <div aria-live="polite" aria-atomic="true" style="min-height: 200px;">
        <div class="toast" style="position: absolute; top: 10px; right: 10px;">
            <div class="toast-header">
                <strong class="mr-auto">Помощь</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Используйте <kbd><kbd>←</kbd><kbd> →</kbd></kbd> для перемещения<br>
                <kbd>ЛКМ</kbd>, чтобы создать воду
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/noisejs@2.1.0/index.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.toast').toast({
                    delay: 10000
                }).toast('show');
            });

            let canvas = document.getElementsByTagName('canvas')[0];
            canvas.setAttribute('width', window.innerWidth);
            canvas.setAttribute('height', window.innerHeight);

            let ctx = canvas.getContext("2d");
            ctx.fillStyle = "black";

            let seed = Math.random();
            let noise = new Noise();
            noise.seed(seed);

            let map = [];
            let heightmap = [];
            let x_offset = 0;

            let size = 5;
            let water = [];

            let mouse = {
                right: false,
                left: false,
            };

            $(document).mousedown(function (event) {
                if (event.which === 1) {
                    mouse.left = true
                }
                if (event.which === 3) {
                    mouse.right = true
                }
            });

            class Water {
                constructor(x, y) {
                    this.x = x;
                    this.y = y;
                }

                move(map) {
                    map[this.x][this.y] = 0;

                    if (!map[this.x][this.y - size]) {
                        this.y -= size
                    } else if (!map[this.x + size][this.y] && !map[this.x - size][this.y]) {
                        this.x += Math.round(Math.random() * 2 - 1) * size
                    } else if (!map[this.x + size][this.y]) {
                        this.x += size
                    } else if (!map[this.x - size][this.y]) {
                        this.x -= size
                    }

                    if (this.y < 0) {
                        delete this;
                    }

                    map[this.x][this.y] = 2;
                }

                draw() {
                    ctx.fillStyle = 'blue';
                    ctx.fillRect(this.x - x_offset, canvas.height - this.y, size, size);
                }
            }


            $(document).keydown((event) => {
                if (event.which === 39) {
                    x_offset += size * 2
                } else if (event.which === 37) {
                    x_offset -= size * 2
                } else {
                    return
                }

                draw();
            });

            $(document).click((event) => {
                let x = event.clientX - (event.clientX % size) + x_offset;
                let y = canvas.height - event.clientY;
                y -=  y % size;

                console.log(x, y);


                // water.push(new Water(x, y))
                water.push(new Water(x, y), new Water(x + size, y), new Water(x - size, y), new Water(x, y + size), new Water(x, y - size))
            });

            function color(y, height, ) {
                let color = [];

                if (height - y >= 20) {
                    color = [64, 64, 64]
                } else {
                    color = [18, 186, 10]
                }

                return `rgb(${color[0]}, ${color[1]}, ${color[2]})`
            }

            function check(x, y) {
                let height;

                if (map[x] !== undefined) {
                    if (map[x][y] !== undefined) {
                        return map[x][y];
                    }
                } else {
                    map[x] = [];
                }

                height = (noise.perlin2(x / 100, 0) + 1) * 250;
                height -= (height % size);

                heightmap[x] = height;
                map[x][y] = (y <= height) && !(noise.perlin3(x / 100, y / 100, seed) > 0.4);

                return map[x][y]
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                for (let x = x_offset; x < canvas.width + x_offset; x += size) {
                    for (let y = 0; y < canvas.height; y += size) {
                        if (check(x, y) == 1) {
                            ctx.fillStyle = color(y, heightmap[x]);

                            ctx.fillRect(x - x_offset, canvas.height - y, size, size);
                        }
                    }
                }
            }

            function moveWater() {
                for (let i = 0; i <= 10; i++) {
                    let x = 100 + Math.floor(Math.random() * (canvas.width - 200));
                    x -= (x % 5);

                    water.push(
                        new Water(
                            x,
                            canvas.height - (canvas.height % 5)
                        )
                    );
                }

                draw();

                for (let i = 0; i < water.length; i++) {
                    water[i].move(map);
                    water[i].draw();
                }
            }

            draw();

            setInterval(moveWater, 100)
        </script>
    @endpush
@endsection
