@extends('layouts.page', ['nav' => 'none'])

@section('content')
    <canvas style="top: 0; left: 0; width: 80%" class="h-100 border position-absolute"></canvas>
    <div style="top: 0; left: 80%; width: 20%" class="h-100 border-left position-absolute">
        <h2 class="text-center mt-1">Настройки</h2>

        <div class="m-2">
            <div class="form-group">
                <label for="size">Размер начальной популяции</label>
                <input type="range" min="0.6" max="1.5" step="0.1" value="1" class="form-control-range" id="size">
            </div>

            <hr>

            <div class="form-group">
                <label for="speed">Скорость <small class="text-muted" id="speed_print">1.0x</small></label>
                <input type="range" min="0.1" max="5" step="0.1" value="1" class="form-control-range" id="speed">
            </div>

            <hr>

            <div class="form-group">
                <label for="rule">Правило</label>

                <input value="23/3" class="form-control" id="rule" type="text" list="rules">
                <small class="text-muted">Правило для клеточного автомата. Подробнее в статье</small>

                <datalist id="rules">
                    <option value="23/3" selected>Игра "Жизнь"</option>
                    <option value="12345/3">Лабиринт</option>
                    <option value="/2">Странная штука</option>
                    <option value="2345/45678">Города со стенами</option>
                </datalist>
            </div>

            <hr>

            <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-secondary" id="restart">Перезапустить</button>
                <button type="button" class="btn btn-secondary" id="start">Пауза</button>
            </div>

            <button type="button" class="mt-2 w-100 btn btn-secondary" id="edit">Редактировать</button>
        </div>
    </div>
{{-- TODO: make normal z-index --}}
    @push('script')
        <script>
            let canvas = document.getElementsByTagName('canvas')[0];
            canvas.setAttribute('width', canvas.getBoundingClientRect().width / 2);
            canvas.setAttribute('height', canvas.getBoundingClientRect().height / 2);

            let ctx = canvas.getContext("2d");

            let size = 2;
            let width = Math.ceil(canvas.width / size);
            let height = Math.ceil(canvas.height / size);

            let speed = 1;
            let population_size = 1;

            let string_rule = '23/3';

            let map = [];
            let new_map = [];
            let pause = false;
            let is_edit = false;

            $('#speed').change(function () {
                speed = parseFloat($(this).val());
                $('#speed_print').html((speed).toFixed(1) + 'x')
            });

            $('#rule').change(function () {
                string_rule = $(this).val()
            });

            $('#size').change(function () {
                population_size = parseFloat($(this).val());
            });

            $('#restart').click(function () {
                reset_map()
            });

            $('#start').click(function () {
                if (pause) {
                    $(this).html('Пауза');
                    pause = false;
                    is_edit = false;
                    step()
                } else {
                    pause = true;
                    $(this).html('Продолжить')
                }
            });

            $('#edit').click(function () {
                pause = true;
                $('#start').html('Продолжить');

                map = [];
                new_map = [];
                for (let x = 0; x < width; x++) {
                    map[x] = [];
                    new_map[x] = [];
                    for (let y = 0; y < height; y++) {
                        map[x][y] = 0;
                        new_map[x][y] = undefined;
                    }
                }

                ctx.clearRect(0, 0, canvas.width, canvas.height);

                is_edit = true;
            });

            $('canvas').mousedown(function (event) {
               if (is_edit) {
                   let x = Math.floor(getMousePos(canvas, event).x / size);
                   let y = Math.floor(getMousePos(canvas, event).y / size);

                   console.log(x, y);

                   if (map[x][y]) {
                       map[x][y] = 0
                   } else {
                       map[x][y] = 1
                   }

                   updateMap(map)
               }
            });

            function reset_map() {
                map = [];
                new_map = [];
                for (let x = 0; x < width; x++) {
                    map[x] = [];
                    new_map[x] = [];
                    for (let y = 0; y < height; y++) {
                        map[x][y] = Math.round(Math.random() * population_size);
                        new_map[x][y] = undefined;
                    }
                }
            }

            function  getMousePos(canvas, evt) {
                let rect = canvas.getBoundingClientRect(), // abs. size of element
                    scaleX = canvas.width / rect.width,    // relationship bitmap vs. element for X
                    scaleY = canvas.height / rect.height;  // relationship bitmap vs. element for Y

                return {
                    x: (evt.clientX - rect.left) * scaleX,   // scale mouse coordinates after they have
                    y: (evt.clientY - rect.top) * scaleY     // been adjusted to be relative to element
                }
            }

            function mod(n, m) {
                return ((n % m) + m) % m;
            }

            function updateMap(map) {
                for (let x = 0; x < width; x++) {
                    for (let y = 0; y < height; y++) {
                        if (map[x][y]) {
                            let color = ctx.getImageData(x * size, y * size, size, size).data;
                            if (color[0] === 255 && color[1] === 255 && color[2] === 255) {
                                ctx.fillStyle = 'rgb(255, 3, 3)';
                            } else {
                                ctx.fillStyle = 'rgb(' + (color[0] * 0.9) + ', ' + (color[1] * 0.9) + ', ' + (color[2] * 0.9) + ')';
                            }
                        } else {
                            ctx.fillStyle = 'rgb(255, 255, 255)';
                        }

                        ctx.fillRect(x * size, y * size, size, size);
                    }
                }
            }

            function rule(map, x, y, rule) {
                let live_neighbor = 0;

                for (let x_offset = -1; x_offset <= 1; x_offset++) {
                    for (let y_offset = -1; y_offset <= 1; y_offset++) {
                        if (x_offset !== 0 || y_offset !== 0) {
                            if (x + x_offset >= 0 && x + x_offset < width && y + y_offset >= 0 && y + y_offset < height) {
                                live_neighbor += map[x + x_offset][y + y_offset];
                            }
                        }
                    }
                }

                if (map[x][y] === 0) {
                    if (rule.split('/')[1].includes(live_neighbor)) {
                        return 1
                    }

                    return 0
                } else {
                    if (rule.split('/')[0].includes(live_neighbor)) {
                        return 1
                    }

                    return 0
                }
            }

            function step() {
                updateMap(map);

                for (let x = 0; x < width; x++) {
                    for (let y = 0; y < height; y++) {
                        new_map[x][y] = rule(map, x, y, string_rule);
                    }
                }

                for (let x = 0; x < width; x++) {
                    for (let y = 0; y < height; y++) {
                        map[x][y] = new_map[x][y]
                    }
                }

                if (!pause) {
                    setTimeout(step, 100 / speed)
                }
            }

            reset_map();
            step();
        </script>
    @endpush
@endsection
