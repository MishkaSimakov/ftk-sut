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
            let canvas = document.getElementsByTagName('canvas')[0];
            canvas.setAttribute('width', window.innerWidth);
            canvas.setAttribute('height', window.innerHeight);

            let context = canvas.getContext('2d');
            let prev=0, simId = null;

            function Simulation (len, grav, angle0, tstep, callback) {
                //Аргументы: длина (м), ускорение свободного падения (м/c^2),
                //начальный угол (рад.), шаг по времени (мс), функция отрисовки
                let velocity = 0;
                let angle = angle0;
                let k = - grav / len;
                let tsec = tstep / 1000;
                let coeffT = 0.999; //"трение" из интервала ]0;1], =1 - без замедления

                return setInterval (function () {
                    let acceleration = k * Math.sin(angle);
                    velocity += acceleration * tsec;
                    angle += velocity * tsec;
                    angle *= coeffT;
                    callback (angle);
                }, tstep);
            }

            function myAngle (angle) {
                let size = Math.min (canvas.width, canvas.height); //размер, относительно которого считаем
                let rPend = size * 0.35; //длина плеча маятника
                let rBar = size * 0.005; //толшина плеча маятника
                let rBall = size * 0.03; //размер шарика
                let ballX = Math.sin(angle) * rPend;
                let ballY = Math.cos(angle) * rPend;

                context.fillStyle = 'rgba(255,255,255,0.51)';
                context.globalCompositeOperation = 'destination-out';
                //Целевое изображение отображается вне границ исходного
                context.fillRect (0, 0, canvas.width, canvas.height); //очистить
                context.fillStyle = "yellow"; //цвет заливки
                context.strokeStyle = "rgba(0,0,0,"+Math.max(0,1-Math.abs(prev-angle)*10)+")";
                context.globalCompositeOperation = "source-over";
                //Исходное изображение накрывает целевое
                context.save();
                context.translate (canvas.width/2, canvas.height/2); //начало координат
                context.rotate(angle); //поворот системы координат
                context.beginPath();
                context.rect (-rBar, -rBar, rBar*2, rPend+rBar*2); //плечо
                context.fill();
                context.stroke();
                context.beginPath();
                context.arc (0, rPend, rBall, 0, Math.PI*2, false); //шарик
                context.fill();
                context.stroke();
                context.restore();
                prev = angle;
            }

            canvas.onclick = function (event) {
                if (simId) {
                    clearInterval (simId); simId = null;
                }
                simId = Simulation(0.75, 9.80665, Math.PI*0.9, 10, myAngle);
            };

            window.addEventListener('load', function (e) {
                simId = Simulation(0.75, 9.80665, Math.PI*0.9, 10, myAngle);
            }, false);
        </script>
    @endpush
@endsection
