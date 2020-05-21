@extends('layouts.page', ['nav' => 'none'])

@section('content')
    <canvas style="top: 0; left: 0;" class="position-absolute w-100 h-100"></canvas>

    {{-- TODO: make normal z-index --}}
    @push('script')
        <script>
            let canvas = document.getElementsByTagName('canvas')[0];
            let ctx = canvas.getContext("2d");

            let zoom = 1;
            let x = 1;
            let y = 1;

            $(document).keydown((event) => {
                if (event.keyCode === 39) {
                    x -= 0.5 / zoom * 100
                } else if (event.keyCode === 37) {
                    x += 0.5 / zoom * 100
                } else if (event.keyCode === 38) {
                    y += 0.5 / zoom * 100
                } else if (event.keyCode === 40) {
                    y -= 0.5 / zoom * 100
                } else if (event.keyCode === 187) {
                    zoom *= 1.1
                } else if (event.keyCode === 189) {
                    zoom /= 1.1
                }

                draw();
            });
            $(window).bind('mousewheel DOMMouseScroll', function(event){
                if (event.originalEvent.wheelDelta < 0) {
                    zoom /= 1.1
                } else {
                    zoom *= 1.1
                }

                draw();
            });

            function draw(resolution) {
                for(let x = 0; x < canvas.width; x += resolution) {
                    for(let y = 0; y < canvas.height; y += resolution) {
                        let belongsToSet =
                            check(x / magnificationFactor - panX,
                                y / magnificationFactor - panY);

                        if(belongsToSet === 0) {
                            ctx.fillStyle = '#000';
                            ctx.fillRect(x, y, resolution, resolution); // Draw a black pixel
                        } else {
                            ctx.fillStyle = 'hsl(0, 100%, ' + belongsToSet + '%)';
                            ctx.fillRect(x, y, resolution, resolution); // Draw a colorful pixel
                        }
                    }
                }
            }

            draw();
        </script>
    @endpush
@endsection
