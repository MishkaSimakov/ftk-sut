<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ФТК-СЮТ</title>

    <style>
        .cell {
            position: absolute;
            border: 1px solid lightgray;
        }

        .live {
            background-color: ghostwhite;
        }

        .dead {
            background-color: gray;
            border-color: gray !important;
        }
    </style>
</head>
<body style="background-color: black">
<script>
    let size = 10;
    let width = Math.floor(window.innerWidth / size);
    let height = Math.floor(window.innerHeight / size);

    let map = [];
    let new_map = [];
    for (let x = 0; x < width; x++) {
        map[x] = [];
        new_map[x] = [];
        for (let y = 0; y < height; y++) {
            map[x][y] = Math.round(Math.random() * 0.55);
            new_map[x][y] = undefined;
        }
    }

    function mod(n, m) {
        return ((n % m) + m) % m;
    }

    function drawMap() {
        let divs = [];
        for(let i = 0; i < width; i++) {
            divs[i] = new Array(height);
        }

        for (let x = 0; x < width; x++) {
            for (let y = 0; y < height; y++) {
                divs[x][y] = document.createElement('div');
                divs[x][y].setAttribute('style', `left: ${size * x }px; top: ${size * y}px; width: ${size}px; height: ${size}px;`);
                divs[x][y].classList += 'cell';

                document.body.append(divs[x][y])
            }
        }

        return divs
    }

    function updateMap(map, divs) {
        for (let x = 0; x < width; x++) {
            for (let y = 0; y < height; y++) {
                divs[x][y].classList = '';

                if (map[x][y]) {
                    divs[x][y].classList += 'cell live';
                } else {
                    divs[x][y].classList += 'cell dead';
                }
            }
        }
    }

    function rule(map, divs, x, y, rule) {
        let live_neighbor = 0;

        for (let x_offset = -1; x_offset <= 1; x_offset++) {
            for (let y_offset = -1; y_offset <= 1; y_offset++) {
                if (x_offset !== 0 || y_offset !== 0) {
                    live_neighbor += map[mod(x + x_offset, width)][mod(y + y_offset, height)];
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

    let divs = drawMap();
    updateMap(map, divs);

    // window.addEventListener('click', () => {
    setInterval(() => {
        updateMap(map, divs);

        for (let x = 0; x < width; x++) {
            for (let y = 0; y < height; y++) {
                new_map[x][y] = rule(map, divs, x, y, '12345/3');
            }
        }

        for (let x = 0; x < width; x++) {
            for (let y = 0; y < height; y++) {
                map[x][y] = new_map[x][y]
            }
        }
    }, 100)
    // });
</script>
</body>
</html>
