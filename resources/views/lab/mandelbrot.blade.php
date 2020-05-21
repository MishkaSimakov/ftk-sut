@extends('layouts.page', ['nav' => 'none'])

@section('content')
    <canvas style="cursor: move; top: 0; left: 0;" class="position-absolute w-100 h-100"></canvas>

    <div aria-live="polite" aria-atomic="true" style="min-height: 200px;">
        <div class="toast" style="position: absolute; top: 10px; right: 10px;">
            <div class="toast-header">
                <strong class="mr-auto">Помощь</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Для перемещения используйте  <kbd><kbd>↑</kbd><kbd> ↓ </kbd><kbd> → </kbd><kbd>←</kbd></kbd><br>
                <hr>
                Для изменения масштаба <kbd><kbd>+ </kbd><kbd>-</kbd></kbd><br>
                <hr>
                Для отображения в высоком качестве <kbd>Space</kbd><br>
                <small class="text-muted">Нужно немного подождать</small>
            </div>
        </div>
    </div>

    @push('script')
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

            let mouse_start_x = 0;
            let mouse_start_y = 0;
            let is_drag = false;

            let maxIterations = 100;
            let infinity = 4;

            function check(x, y) {
                let realComponentOfResult = x;
                let imaginaryComponentOfResult = y;


                for (let i = 0; i < maxIterations; i++) {
                    let tempRealComponent = realComponentOfResult * realComponentOfResult
                        - imaginaryComponentOfResult * imaginaryComponentOfResult
                        + x;
                    let tempImaginaryComponent = 2 * realComponentOfResult * imaginaryComponentOfResult
                        + y;
                    realComponentOfResult = tempRealComponent;
                    imaginaryComponentOfResult = tempImaginaryComponent;

                    // Return a number as a percentage
                    if(Math.pow(realComponentOfResult, 2) + Math.pow(imaginaryComponentOfResult, 2) > infinity)
                        return i / maxIterations * 100;
                }

                return 0;
            }

            let magnificationFactor = 200;
            let panX = 4;
            let panY = 1.5;

            $(document).keydown((event) => {
                if (event.keyCode === 39) {
                    panX -= 0.5 / magnificationFactor * 100
                } else if (event.keyCode === 37) {
                    panX += 0.5 / magnificationFactor * 100
                } else if (event.keyCode === 38) {
                    panY += 0.5 / magnificationFactor * 100
                } else if (event.keyCode === 40) {
                    panY -= 0.5 / magnificationFactor * 100
                } else if (event.keyCode === 187) {
                    magnificationFactor *= 1.1
                } else if (event.keyCode === 189) {
                    magnificationFactor /= 1.1
                } else if (event.keyCode === 32) {
                    draw(1);

                    return
                } else {
                    return
                }

                draw();
            });

            $(document).mousedown((event) => {
               mouse_start_x = event.clientX;
               mouse_start_y = event.clientY;

               is_drag = true;
            });
            $(document).mouseup(() => {
                is_drag = false;
                draw();
            });
            $(document).mousemove((event) => {
               if (is_drag) {
                   let offset_x = mouse_start_x - event.clientX;
                   let offset_y = mouse_start_y - event.clientY;

                   panX -= offset_x / (magnificationFactor);
                   panY -= offset_y / (magnificationFactor);

                   draw();

                   mouse_start_x = event.clientX;
                   mouse_start_y = event.clientY;
               }
            });

            $(window).bind('mousewheel DOMMouseScroll', function(event){
                if (event.originalEvent.wheelDelta < 0) {
                    magnificationFactor /= 5
                } else {
                    magnificationFactor *= 5
                }

                draw();
            });

            function draw(resolution=5) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                for(let x = 0; x < canvas.width; x += resolution) {
                    for(let y = 0; y < canvas.height; y += resolution) {
                        let belongsToSet =
                            check(x / magnificationFactor - panX,
                                y / magnificationFactor - panY);

                        if(belongsToSet === 0) {
                            ctx.fillStyle = '#000';
                            ctx.fillRect(x, y, resolution, resolution);
                        } else {
                            ctx.fillStyle = `rgb(${belongsToSet * 2.56}, ${belongsToSet * 2.56}, ${belongsToSet * 2.56})`;
                            ctx.fillRect(x, y, resolution, resolution);
                        }
                    }
                }
            }

            draw();
        </script>
    @endpush
@endsection
