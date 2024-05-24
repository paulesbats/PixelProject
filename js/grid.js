document.addEventListener("DOMContentLoaded", function() {
    const grid = document.getElementById("grid");
    const pixels = JSON.parse(document.getElementById("grid").dataset.pixels);
    const gridID = grid_ID;
    const pixelChangeTime = {};
    let selectedColor = '#000000';
    let selectedSwatch = document.querySelector('.color-swatch[data-color="#000000"]');
    selectedSwatch.classList.add('selected');

    document.querySelectorAll('.color-swatch').forEach(swatch => {
        swatch.addEventListener('click', function() {
            selectedColor = swatch.dataset.color;
            selectedSwatch.classList.remove('selected');
            selectedSwatch.style.borderColor = '#b3b3b3';
            selectedSwatch = swatch;
            swatch.classList.add('selected');
            swatch.style.borderColor = '#0070c0';
            
        });
    });

    for (let horpos = 0; horpos < 30; horpos++) {
        for (let verpos = 0; verpos < 30; verpos++) {
            const cell = document.createElement('div');
            cell.classList.add('cell');
            cell.dataset.horpos = horpos;
            cell.dataset.verpos = verpos;
            cell.style.backgroundColor = 'white';
            grid.appendChild(cell);
            pixelChangeTime[`${horpos},${verpos}`]=0;
        }
    }

    pixels.forEach(pixel => {
        const horpos = pixel.Horizontal_pos;
        const verpos = pixel.Vertical_pos;
        const color = pixel.Color;
        const user_ID = pixel.User_ID;
        const cell = grid.querySelector(`.cell[data-horpos="${horpos}"][data-verpos="${verpos}"]`);

        if (cell) {
            cell.style.backgroundColor = color;
            console.log("on rentre dans la boucle");
            cell.addEventListener('mouseover', function() {
                fetch('getusername.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                    userID: user_ID,
                    })
                }).then(((response) => {
                    response.text().then((userName) => {
                        cell.title = `Placed by : ${userName}`;
                    })
                }))
            });
        }
    });
    
    grid.addEventListener('click', function(event) {
        const cell = event.target;
        if (cell.classList.contains('cell')) {
            const horpos = cell.dataset.horpos;
            const verpos = cell.dataset.verpos;
            const currentTime = Date.now();
            const currentChangeTime = pixelChangeTime[`${horpos},${verpos}`];

            if (currentTime - currentChangeTime >= 30000) {
                cell.style.backgroundColor = selectedColor;
                pixelChangeTime[`${horpos},${verpos}`] = currentTime;
                fetch('updatepixel.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        gridID: gridID,
                        horpos: horpos,
                        verpos: verpos,
                        color: selectedColor,
                    })
                });
            } else {
                alert("You must wait 30 seconds !");
            }
        }
    });
});
