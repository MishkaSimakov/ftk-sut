@extends('layouts.page', ['nav' => 'none'])

@section('content')
    <canvas style="top: 0; left: 0; background-color: black" class="position-absolute w-100 h-100"></canvas>

    <div aria-live="polite" aria-atomic="true" style="min-height: 200px;">
        <div class="toast" style="position: absolute; top: 10px; right: 10px;">
            <div class="toast-header">
                <strong class="mr-auto">Помощь</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Для изменения масштаба используйте <kbd><kbd>+</kbd><kbd> -</kbd></kbd>
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
            ctx.fillStyle = "white";

            let centerX = Math.floor(canvas.width / 2);
            let centerY = Math.floor(canvas.height / 2);

            let scale = 5;
            let positions = [];


            function getPageContents(callback, url, params) {
                let http = new XMLHttpRequest();
                if(params!=null) {
                    http.open("POST", url, true);
                    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                } else {
                    http.open("GET", url, true);
                }
                http.onreadystatechange = function() {
                    if(http.readyState === 4 && http.status === 200) {
                        callback(http.responseText);
                    }
                };
                http.send(params);
            }

            function radians_to_degrees(radians) {
                let pi = Math.PI;
                return radians * (180 / pi);
            }

            function polarToDescartes(r, angle) {
                angle = radians_to_degrees(angle);

                return {
                    y: Math.sin(angle) * r,
                    x: Math.cos(angle) * r
                };
            }

            function parseData(data) {
                data = JSON.parse(data);
                let positions = [];

                console.log(data.length);

                for(let i = 0; i < 1000000; i++) {
                    let number = data[i];
                    positions[i] = polarToDescartes(number, number);
                }

                return positions
            }

            function draw(positions, scale) {
                let max = (canvas.height / 2) * scale / 10;

                ctx.clearRect(0, 0, canvas.width, canvas.height);

                for(let i = 0; i < max; i++) {
                    ctx.fillRect(positions[i].x / scale + centerX, positions[i].y / scale + centerY, 1, 1)
                }
            }

            $(window).bind('mousewheel DOMMouseScroll', function(event){
                if (event.originalEvent.wheelDelta < 0) {
                    scale *= 1.5
                } else {
                    scale /= 1.5
                }

                draw(positions, scale);
            });

            $(document).keydown((event) => {
                if (event.keyCode === 187) {
                    scale /= 1.5
                } else if (event.keyCode === 189) {
                    scale *= 1.5
                } else {
                    return
                }

                draw(positions, scale);
            });

            getPageContents(function (c) {
                positions = parseData(c);

                draw(positions, scale)
            }, '/lab_files/primes.txt')
        </script>
    @endpush
@endsection
