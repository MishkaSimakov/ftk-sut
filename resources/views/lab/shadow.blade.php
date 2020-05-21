@extends('layouts.page', ['nav' => 'none'])

@section('content')
    <canvas style="background-color: black; top: 0; left: 0;" class="position-absolute w-100 h-100"></canvas>
    @push('script')
        <script>
            let ratio = window.devicePixelRatio;
            let canvas = document.getElementsByTagName("canvas")[0];
            canvas.width = window.innerWidth*ratio;
            canvas.height = window.innerHeight*ratio;

            let ctx = canvas.getContext('2d');

            let mouse = {x:0,y:0};

            canvas.addEventListener('mousemove',function(e){
                mouse.x = e.clientX*ratio;
                mouse.y = e.clientY*ratio;
            });

            let solids = [];

            function getAllSegments(solids){
                let output = [];
                output.push([{x:0,y:0},{x:canvas.width,y:0}]);
                output.push([{x:canvas.width,y:0},{x:canvas.width,y:canvas.height}]);
                output.push([{x:canvas.width,y:canvas.height},{x:0,y:canvas.height}]);
                output.push([{x:0,y:canvas.height},{x:0,y:0},{x:canvas.width,y:0}]);
                for (let i = 0; i < solids.length; i++){
                    for (let j = 0; j < solids[i].points.length; j++){
                        if (solids[i].points[j+1] !== undefined) {
                            output.push([{x:solids[i].points[j].x, y:solids[i].points[j].y},{x:solids[i].points[j+1].x, y:solids[i].points[j+1].y}]);
                        } else {
                            output.push([{x:solids[i].points[j].x, y:solids[i].points[j].y},{x:solids[i].points[0].x, y:solids[i].points[0].y}]);
                        }
                    }
                }
                return output;
            }
            function getAllPoints(solids){
                let output = [];
                output.push({x:0,y:0});
                output.push({x:canvas.width,y:0});
                output.push({x:canvas.width,y:canvas.height});
                output.push({x:0,y:canvas.height});
                for (let i=0;i<solids.length;i++){
                    for (let j = 0; j < solids[i].points.length; j++){
                        output.push(solids[i].points[j]);
                    }
                }
                return output;
            }
            function getAllFi(allPoints){
                let output = [];
                for (i=0;i<allPoints.length;i++){
                    let angle = Math.atan2(allPoints[i].y - mouse.y, allPoints[i].x - mouse.x);
                    output.push(angle, angle + .0001, angle - .0001);
                }
                return output;
            }

            function getIntersect(ray,side){
                let rx = ray[0].x,
                    ry = ray[0].y,
                    rdx = ray[1].x - ray[0].x,
                    rdy = ray[1].y - ray[0].y,
                    sx = side[0].x,
                    sy = side[0].y,
                    sdx = side[1].x - side[0].x,
                    sdy = side[1].y - side[0].y;

                let rmag = Math.sqrt(rdx*rdx + rdy*rdy),
                    smag = Math.sqrt(sdx*sdx + sdy*sdy);

                if (rdx/rmag == sdx/smag && rdy/rmag == sdy/smag) return false;

                let k2 = (rdx * (sy-ry) + rdy * (rx - sx)) / (sdx * rdy - sdy * rdx);
                let	k1 = (sx + sdx * k2 - rx) / rdx;

                if (k1 < 0 || k2<0 || k2>1) return false;

                return {x: rx + rdx * k1,y: ry + rdy * k1,d: k1};
            }

            function shootRay(ray,allSegments){
                let	closest = false;
                for (i=0;i<allSegments.length;i++){
                    let current = getIntersect(ray,allSegments[i]);
                    if (!closest || current.d < closest.d){
                        closest = current;
                    }
                }
                return closest;
            }

            function drawPoint(x,y){
                ctx.save();
                ctx.fillStyle = 'rgba(255,0,0,.2)';
                ctx.beginPath();
                ctx.arc(x,y,2,0,Math.PI*2);
                ctx.closePath();
                ctx.fill();
                ctx.restore();
            }

            let Solid = function(pointsArray){
                this.points = pointsArray;
            }
            Solid.prototype.draw = function(){
                ctx.save();
                ctx.fillStyle = 'rgb(0,0,35)';
                ctx.beginPath();
                ctx.moveTo(this.points[0].x,this.points[0].y);
                for (i=1;i<this.points.length;i++){
                    ctx.lineTo(this.points[i].x,this.points[i].y)
                }
                ctx.closePath();
                ctx.fill();
                ctx.restore();
            }

            function drawLaser(from,to){
                ctx.save();
                ctx.strokeStyle = 'rgba(255,0,0,.1)';
                ctx.beginPath();
                ctx.moveTo(from.x,from.y);
                ctx.lineTo(to.x,to.y);
                ctx.closePath();
                ctx.stroke();
                ctx.restore();
            }

            function shootAll(){
                let inters = [];
                for (r=0;r<allPoints.length;r++){
                    inters.push(shootRay([{x:mouse.x,y:mouse.y},{x:allPoints[r].x,y:allPoints[r].y}],allSegments));
                    drawPoint(inters[inters.length-1].x,inters[inters.length-1].y);
                    drawLaser({x:mouse.x,y:mouse.y},inters[inters.length-1]);
                }
            }
            function shootAllFi(){
                let inters = [];
                for (r=0;r<allFi.length;r++){
                    inters.push(shootRay([{x:mouse.x,y:mouse.y},{x:mouse.x + Math.cos(allFi[r]),y:mouse.y + Math.sin(allFi[r])}],allSegments));
                    inters[inters.length-1].fi = allFi[r];
                    //drawPoint(inters[inters.length-1].x,inters[inters.length-1].y);
                    //drawLaser({x:mouse.x,y:mouse.y},inters[inters.length-1]);
                }
                return inters.sort(function(a,b){
                    return a.fi - b.fi;
                });
            }
            function shine(inters){
                ctx.save();
                let shade = ctx.createRadialGradient(mouse.x,mouse.y,10,mouse.x,mouse.y,600*ratio);
                shade.addColorStop(0,'rgba(255,255,255,.5)');
                shade.addColorStop(.3,'rgba(255,255,255,.3)');
                shade.addColorStop(1,'rgba(100,100,255,0)');
                //ctx.fillStyle = "rgb(255,255,250)";
                ctx.fillStyle = shade;
                ctx.beginPath();
                ctx.moveTo(inters[0].x,inters[0].y);
                for (s=1;s<inters.length;s++){
                    ctx.lineTo(inters[s].x,inters[s].y);
                }
                ctx.closePath();
                ctx.fill();
                ctx.restore();
            }

            solids.push(new Solid([{x:50*ratio,y:50*ratio},{x:100*ratio,y:50*ratio},{x:150*ratio,y:100*ratio},{x:50*ratio,y:100*ratio}]));
            solids.push(new Solid([{x:400*ratio,y:280*ratio},{x:415*ratio,y:350*ratio},{x:256*ratio,y:315*ratio},{x:350*ratio,y:255*ratio}]));
            solids.push(new Solid([{x:600*ratio,y:100*ratio},{x:1518*ratio,y:108*ratio},{x:1450*ratio,y:360*ratio},{x:1518*ratio,y:560*ratio},{x:1134*ratio,y:520*ratio}]));
            solids.push(new Solid([{x:1000*ratio,y:800*ratio},{x:1020*ratio,y:800*ratio},{x:1020*ratio,y:820*ratio},{x:1000*ratio,y:820*ratio}]));
            solids.push(new Solid([{x:1040*ratio,y:800*ratio},{x:1060*ratio,y:800*ratio},{x:1060*ratio,y:820*ratio},{x:1040*ratio,y:820*ratio}]));
            solids.push(new Solid([{x:1080*ratio,y:800*ratio},{x:1100*ratio,y:800*ratio},{x:1100*ratio,y:820*ratio},{x:1080*ratio,y:820*ratio}]));
            solids.push(new Solid([{x:1120*ratio,y:800*ratio},{x:1140*ratio,y:800*ratio},{x:1140*ratio,y:820*ratio},{x:1120*ratio,y:820*ratio}]));

            let allSegments = getAllSegments(solids);
            let allPoints = getAllPoints(solids);
            let allFi = getAllFi(allPoints);

            ctx.fillStyle = 'rgb(0,0,20)';
            (function render(){
                ctx.fillRect(0,0,canvas.width,canvas.height);
                for (q=0;q<solids.length;q++){
                    solids[q].draw();
                }
                allFi = getAllFi(allPoints);
                shine (shootAllFi());
                //drawPoint(mouse.x,mouse.y);
                requestAnimationFrame(render);
            })();
        </script>
    @endpush
@endsection
