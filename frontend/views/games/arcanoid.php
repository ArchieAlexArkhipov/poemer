<?php
$this->title = 'Arcanoid game';
?>
<div class="games-arcanoid">

  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    header, footer {
      display: none;
    }
    body {
      background: black;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .bg-light { background: black!important; }
    canvas { margin: auto; }
  </style>

  <canvas width="400" height="500" id="game"></canvas>

<script>
  const canvas = document.getElementById('game');
  const context = canvas.getContext('2d');

  // каждый ряд состоит из 14 кирпичей. На уровне будут 6 пустых рядов, а затем 8 рядов с кирпичами
  // цвета кирпичей: красный, оранжевый, зелёный и жёлтый
  // буква в массиве означает цвет кирпича
  const level1 = [
    [],
    [],
    [],
    [],
    [],
    [],
    ['R','R','R','R','R','R','R','R','R','R','R','R','R','R'],
    ['R','R','R','R','R','R','R','R','R','R','R','R','R','R'],
    ['O','O','O','O','O','O','O','O','O','O','O','O','O','O'],
    ['O','O','O','O','O','O','O','O','O','O','O','O','O','O'],
    ['G','G','G','G','G','G','G','G','G','G','G','G','G','G'],
    ['G','G','G','G','G','G','G','G','G','G','G','G','G','G'],
    ['Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y'],
    ['Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y']
  ];

  // сопоставляем буквы (R, O, G, Y) с цветами
  const colorMap = {
    'R': 'red',
    'O': 'orange',
    'G': 'green',
    'Y': 'yellow'
  };

  // делаем зазор в 2 пикселя между кирпичами, чтобы отделить их друг от друга
  const brickGap = 2;
  // размеры каждого кирпича
  const brickWidth = 25;
  const brickHeight = 12;

  // ширина стены должна занимать оставшееся место на холсте с каждой стороны
  // у нас 14 кирпичей по 25 пикселей и 13 промежутков по 2 пикселя, а общая ширина холста — 400 пикселей
  // получаем общую ширину стен: 400 - (14 * 25 + 2 * 13) = 24px.
  // разделим пополам, чтобы получить ширину каждой стены, и получим  12px
  const wallSize = 12;
  // основной массив для игры
  const bricks = [];

  // количество набранных очков за одну попытку
  score = 0;

  // сколько очков нужно набрать до очередного увеличения платформы
  score_paddle = 25;

  // сколько очков нужно набрать до получения дополнительной жизни
  score_lives = 100;

  // количество жизней на старте
  lives = 3;

  // создадим уровень так: обработаем весь массив level1
  // и те места, которые обозначены каким-либо цветом, поместим в игровой массив.
  // там же будем хранить координаты начала каждого кирпича и его цвет

  // в эту функцию мы поместим всё, что связано с касанием кирпичей
  function touchdown(t_brick) {

    // начисляем очки в зависимости от цвета кирпича
    switch(t_brick.color) {
      case "yellow" : score += 1; break;
      case "green"  : score += 2; break;
      case "orange" : score += 3; break;
      case "red"    : score += 4;
    }

    // за каждые 25 очков — увеличиваем размер платформы на 2 пикселя
    if (score > score_paddle) {
      paddle.width += 20;
      // следующее увеличение — через 25 очков
      score_paddle += 25;
    }

    // а за каждые 100 очков в одной попытке — прибавляем ещё одну жизнь
    if (score > score_lives){
      lives += 1;
      // и усложняем игру — увеличиваем скорость шарика
      ball.speed += 1;
      // сразу меняем скорость движения по осям
      if (ball.dx > 0) { ball.dx = ball.speed}
        else {ball.dx = -1 * ball.speed};
      if (ball.dy > 0) { ball.dy = ball.speed}
        else {ball.dy = -1 * ball.speed};
      // следующее увеличение жизни — через 100 очков
      score_lives += 100;
    }

  }

  // пока у нас есть необработанные элементы в массиве с уровнем — обрабатываем их
  for (let row = 0; row < level1.length; row++) {
    for (let col = 0; col < level1[row].length; col++) {

      // находим цвет кирпича
      const colorCode = level1[row][col];

      // создаём новый элемент игрового массива — с координатами кирпича, цветом, шириной и высотой кирпича
      bricks.push({
        x: wallSize + (brickWidth + brickGap) * col,
        y: wallSize + (brickHeight + brickGap) * row,
        color: colorMap[colorCode],
        width: brickWidth,
        height: brickHeight
      });
    }
  }

  // платформа, которой управляет игрок
  const paddle = {
    // ставим её внизу по центру поля
    x: canvas.width / 2 - brickWidth / 2,
    y: 440,
    // делаем её размером с кирпич
    width: brickWidth,
    height: brickHeight,

    // пока платформа никуда не движется, поэтому направление движения равно нулю
    dx: 0
  };

  // шарик, который отскакивает от платформы и уничтожает кирпичи
  const ball = {
    // стартовые координаты
    x: 130,
    y: 260,
    // высота и ширина (для простоты это будет квадратный шарик)
    width: 5,
    height: 5,

    // скорость шарика по обеим координатам
    speed: 2,

    // на старте шарик пока никуда не смещается
    dx: 0,
    dy: 0
  };

  // проверка на пересечение объектов
  // взяли отсюда: https://developer.mozilla.org/en-US/docs/Games/Techniques/2D_collision_detection
  function collides(obj1, obj2) {
    return obj1.x < obj2.x + obj2.width &&
       obj1.x + obj1.width > obj2.x &&
       obj1.y < obj2.y + obj2.height &&
       obj1.y + obj1.height > obj2.y;
  }

  // главный цикл игры
  function loop() {
    // на каждом кадре — очищаем поле и рисуем всё заново
    requestAnimationFrame(loop);
    context.clearRect(0,0,canvas.width,canvas.height);

    // двигаем платформу с нужной скоростью
    paddle.x += paddle.dx;

    // при этом смотрим, чтобы она не уехала за стены
    if (paddle.x < wallSize) {
      paddle.x = wallSize
    }
    else if (paddle.x + paddle.width > canvas.width - wallSize) {
      paddle.x = canvas.width - wallSize - paddle.width;
    }

    // шарик тоже двигается со своей скоростью
    ball.x += ball.dx;
    ball.y += ball.dy;

    // и его тоже нужно постоянно проверять, чтобы он не улетел за границы стен
    // смотрим левую и правую стенки
    if (ball.x < wallSize) {
      ball.x = wallSize;
      ball.dx *= -1;
    }
    else if (ball.x + ball.width > canvas.width - wallSize) {
      ball.x = canvas.width - wallSize - ball.width;
      ball.dx *= -1;
    }
    // проверяем верхнюю границу
    if (ball.y < wallSize) {
      ball.y = wallSize;
      ball.dy *= -1;
    }

  // перезагружаем шарик, если он улетел вниз, за край игрового поля
  if (ball.y > canvas.height) {

  // уменьшаем количество жизней
  lives -= 1;

  // обнуляем набранные очки
  score = 0;
  score_paddle = 25;
  score_lives = 100;

  // возвращаем прежний размер платформы
  paddle.width = brickWidth;


  if (lives <= 0){
    // рисуем чёрный прямоугольник посередине поля
    context.fillStyle = 'black';
    context.globalAlpha = 0.75;
    context.fillRect(0, canvas.height / 2 - 30, canvas.width, 60);
    // пишем надпись белым моноширинным шрифтом по центру
    context.globalAlpha = 1;
    context.fillStyle = 'white';
    context.font = '36px monospace';
    context.textAlign = 'center';
    context.textBaseline = 'middle';
    context.fillText('GAME OVER!', canvas.width / 2, canvas.height / 2);

    // останавливаем игру
    return; };

  ball.x = 130;
  ball.y = 260;
  ball.dx = 0;
  ball.dy = 0;
  }

    // проверяем, коснулся ли шарик платформы, которой управляет игрок. Если коснулся — меняем направление движения по оси Y на противоположное
    if (collides(ball, paddle)) {
      ball.dy *= -1;

      // сдвигаем шарик выше платформы, чтобы на следующем кадре это снова не засчиталось за столкновение
      ball.y = paddle.y - ball.height;
    }

    // проверяем, коснулся ли шарик цветного кирпича
    // если коснулся — меняем направление движения шарика в зависимости от стенки касания
    // для этого в цикле проверяем каждый кирпич на касание
    for (let i = 0; i < bricks.length; i++) {
      // берём очередной кирпич
      const brick = bricks[i];

      // если было касание
      if (collides(ball, brick)) {

        touchdown(brick);

        // убираем кирпич из массива
        bricks.splice(i, 1);

        // если шарик коснулся кирпича сверху или снизу — меняем направление движения шарика по оси Y
        if (ball.y + ball.height - ball.speed <= brick.y ||
          ball.y >= brick.y + brick.height - ball.speed) {
          ball.dy *= -1;
        }
        // в противном случае меняем направление движения шарика по оси X
        else {
          ball.dx *= -1;
        }
        // как нашли касание — сразу выходим из цикла проверки
        break;
      }
    }

    // рисуем стены
    context.fillStyle = 'lightgrey';
    context.fillRect(0, 0, canvas.width, wallSize);
    context.fillRect(0, 0, wallSize, canvas.height);
    context.fillRect(canvas.width - wallSize, 0, wallSize, canvas.height);

    // если шарик в движении — рисуем его
    if (ball.dx || ball.dy) {
      context.fillRect(ball.x, ball.y, ball.width, ball.height);
    }

    // рисуем кирпичи
    bricks.forEach(function(brick) {
      context.fillStyle = brick.color;
      context.fillRect(brick.x, brick.y, brick.width, brick.height);
    });

    // рисуем платформу
    context.fillStyle = 'cyan';
    context.fillRect(paddle.x, paddle.y, paddle.width, paddle.height);

    // Цвет текста — серый
    context.fillStyle = "#777777";
    // Задаём размер и шрифт
    context.font = "20pt monospace";
    // Сначала выводим рекорд
    context.fillText('Очки: ' + score, 50, 490);
    // Затем — набранные очки
    context.fillText('Жизни:'+ lives, 250, 490);
  }

  // отслеживаем нажатия игрока на клавиши
  document.addEventListener('keydown', function(e) {
    // стрелка влево
    if (e.which === 37) {
      paddle.dx = -3;
    }
    // стрелка вправо
    else if (e.which === 39) {
      paddle.dx = 3;
    }

    // обрабатываем нажатие на пробел
    // если шарик не запущен — запускаем его из начальной точки, сверху вних
    if (ball.dx === 0 && ball.dy === 0 && e.which === 32) {
      ball.dx = ball.speed;
      ball.dy = ball.speed;
    }
  });

  // как только игрок перестал нажимать клавиши со стрелками — останавливаем платформу
  document.addEventListener('keyup', function(e) {
    if (e.which === 37 || e.which === 39) {
      paddle.dx = 0;
    }
  });

  // запускаем игру
  requestAnimationFrame(loop);
</script>

</div>
