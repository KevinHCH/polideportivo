<?php 
// REQUIRES
require('../Conexion.php');
require('../comunes_polideportivo/footer.php');
require('../comunes_polideportivo/header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>
    <link rel="stylesheet" href="./../../public/css/mainUsuario.css">
    <link rel="stylesheet" href="./../../public/css/polideportivo-global.css">
    <style type="text/css">
        * {
  margin: 0;
  border: 0;
}


.offset {

}

.outer {
  position:relative;
}

.calendar {
    margin: 0 auto;
  max-width: 1280px;
  min-width: 500px;

  box-shadow: 0px 30px 50px rgba(0, 0, 0, 0.2) ,0px 3px 7px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}
.wrap {

  overflow-x: hidden;
  overflow-y: scroll;
    max-width: 1280px;
  height: 500px;
  border-radius: 8px;
}

thead {
    box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.2);
}

thead th {

  text-align: center;
  width: 100%;

}

header {
  background: #fff;
  padding: 1rem;
  color: rgba(0, 0, 0, 0.7);
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  position: relative;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  border-radius: 8px 8px 0px 0px;
}

header h1 {
 font-size: 1.25rem;
 text-align: center;
 font-weight: normal;

}
tbody {
    position: relative;
  top: 100px;
}
table {
  background: #fff;
  width: 100%;
  height: 100%;
  border-collapse: collapse;
  table-layout: fixed;

}



.headcol {
  width: 60px;
  font-size: 0.875rem;
  font-weight: 500;
  color: rgba(0, 0, 0, 0.5);
  padding: 0.25rem 0;
  text-align: center;
  border: 0;
  position: relative;
  top: -12px;
  border-bottom: 1px solid transparent;
}

thead th {
  font-size: 1rem;
  font-weight: bold;
  color: rgba(0, 0, 0, 0.9);
  padding: 1rem;
}

thead {
    z-index: 2;
    background: white;
    border-bottom: 2px solid #ddd;

}

tr, tr td {
  height: 20px;
}
td {
  text-align: center;
}
tr:nth-child(odd) td:not(.headcol) {
  border-bottom: 1px solid #e8e8e8;
}

tr:nth-child(even) td:not(.headcol) {
  border-bottom: 1px solid #eee;
}

tr td {
  border-right: 1px solid #eee;
  padding: 0;
  white-space: none;
  word-wrap: nowrap;
}

tbody tr td {
  position: relative;
  vertical-align: top;
  height: 40px;
  padding: 0.25rem 0.25rem 0 0.25rem;
  width: auto;

}

.secondary {
  color: rgba(0, 0, 0, 0.4);
}


.checkbox {
   display: none;
}

.checkbox + label {
    border: 0;
    outline: 0;
    width: 100px;
    heigth: 100px;
    background: white;
    color: transparent;
    display:block;
  display: none;
}

.checkbox:checked + label {
    border: 0;
    outline: 0;
    width: 100%;
    heigth: 100%;
    background: red;
    color: transparent;
    display: inline-block;
}

.event {
  background: #00B4FC;
  color: white;
  border-radius: 2px;
  text-align: left;
  font-size: 0.875rem;
  z-index: 2;
  padding: 0.5rem;
  overflow-x: hidden;
  transition: all 0.2s;
  cursor: pointer;
}

.event:hover {
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
  background: #00B4FC;
}

.event.double {
  height: 200%;
}

/**
thead {
    tr {
      display: block;
      position: relative;
    }
  }
tbody {
    display: block;
    overflow: auto;
    width: 800px;
    height: 100%;
  }
*/



td:hover:after {
  content: "+";
  vertical-align: middle;
  font-size: 1.875rem;
  font-weight: 100;
  color: rgba(0, 0, 0, 0.5);
  position: absolute;
}

button.secondary {
  border: 1px solid rgba(0, 0, 0, 0.1);
  background: white;
  padding: 0.5rem 0.75rem;
  font-size: 14px;
  border-radius: 2px;
  color: rgba(0, 0, 0, 0.5);
  box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  font-weight: 500;
}

button.secondary:hover {
  background: #fafafa;
}
button.secondary:active {
  box-shadow: none;
}
button.secondary:focus {
  outline: 0;
}

tr td:nth-child(2), tr td:nth-child(3), .past {
  background: #fafafa;
}

.today {
  color: red;
}

.now {
  box-shadow: 0px -1px 0px 0px red;
}

.icon {
  font-size: 1.5rem;
  margin: 0 1rem;
  text-align: center;
  cursor: pointer;
  vertical-align: middle;
  position: relative;
  top: -2px;
}

.icon:hover {
  color: red;
}
    </style>
</head>
<body>
    <?=header_usuarios()?>
        <div class="container">
            <!--
            <div class="contenedor-imagen" id="imgGallary">
                <h3>Contenido</h3>
                <img src="../../public/img/tennis_bg.jpg" alt="Tennis">
                <img src="../../public/img/swpool_bg.jpg" alt="sw">
                <img src="../../public/img/soccer_bg.jpg" alt="fut">
            </div>
            -->
            <div class="row">
                
                <div class="col-md-3">
                    <figcaption class="text-center">
                                <figure>
                                    <img src="./../../public/img/default_male.png">
                                </figure>
                            </figcaption>
                </div>

                <div class="col-md-9">
                    <h3>Andres Lopez Guzman (Andrew)</h3>
                    <span>22 años</span>
                                                <h4> Clases en las que estoy </h4>
                            Tenis, Baloncesto.
                            <br>
                    <h4> Mis deportes favoritos</h4>
                            Baloncesto, Tenis, Futbol. <a href=""><img src=""></a>
                            <br>
                    <h4> Sobre mi</h4>
                    Me gusta mucho el deporte... Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                </div>
            </div>
            <div class="row">
                <h3>Horario de esta semana</h3>
                <div class="calendar">
  
  <header>
      <button class="secondary" style="align-self: flex-start; flex: 0 0 1">Today</button>
      <div class="calendar__title" style="display: flex; justify-content: center; align-items: center">
        <div class="icon secondary chevron_left">‹</div>
        <h1 class="" style="flex: 1;"><span></span><strong>18 JAN – 24 JAN</strong> 2016</h1>
        <div class="icon secondary chevron_left">›</div>
      </div> 
      <div style="align-self: flex-start; flex: 0 0 1"></div>
  </header>
  
  <div class="outer">

  
  <table>
  <thead>
    <tr>
      <th class="headcol"></th>
      <th>Mon, 18</th>
      <th>Tue, 19</th>
      <th class="today">Wed, 20</th>
      <th>Thu, 21</th>
      <th>Fri, 22</th>
      <th class="secondary">Sat, 23</th>
      <th class="secondary">Sun, 24</th>
    </tr>
  </thead>
  </table>

<div class="wrap"> 
  <table class="offset">

  <tbody>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td class="past"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">6:00</td>
      <td></td>
      <td></td>
      <td class="past"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td class="past"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">7:00</td>
      <td></td>
      <td></td>
      <td class="past"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td class="now"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">8:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><div class="event double"><input id="check" type="checkbox" class="checkbox" /><label for="check"></label>8:30–9:30 Yoga</div></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">9:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">10:00</td>
      <td></td>
      <td></td>
      <td><div class="event double"><input id="check" type="checkbox" class="checkbox" /><label for="check"></label>10:00–11:00 Meeting</div></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">11:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">12:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">13:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">14:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">15:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">16:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">17:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol">18:00</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="headcol"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>
</div>
</div>
</div>

            </div>
        </div>
    <?=footer()?>

    <!--<script src="../../public/js/slider.js"></script>-->
</body>
</html>