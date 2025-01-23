<!doctype html>
<html lang="en">
<head>
    <title>Nieuwe reservering - datum</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="my-bulma-project.css">
    <style>
        /* Ensures the body takes up at least the full height of the screen */
        html, body {
            height: 100%;
        }

        /* Flexbox layout for the body to push footer to the bottom */
        body {
            display: flex;
            flex-direction: column;
        }

        /* Footer style */
        footer {
            margin-top: auto;
            background-color: #f4f4f4;
            padding: 20px;
        }

        footer .container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        footer .container > div {
            flex: 1;
            min-width: 250px;
        }

        footer img {
            height: 40px;
            margin-top: 10px;
        }

        footer .socials img {
            height: 30px;
        }
    </style>
</head>

<body>
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <figure class="image is-150x150px">
                <img src="https://rfdewitautos.nl/wp-content/uploads/2018/11/RF-de-wit-autos-logo.png" alt="logo" />
            </figure>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="hometryaya.php">Home</a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Occasions</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="#">Auto leasen</a>
                    <a class="navbar-item" href="#">Auto kopen</a>
                    <a class="navbar-item" href="#">Contact</a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="#">Meld een probleem</a>
                </div>
            </div>

            <a class="navbar-item" href="werkplaats.php">Werkplaats</a>
            <a class="navbar-item" href="select-date.php">Reserveren</a>
            <a class="navbar-item" href="#contact">Contact</a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-primary"><strong>+31 6 421 28724</strong></a>
                </div>
            </div>
        </div>
    </div>
</nav>

<section class="container">
    <div class="content">
        <h1 class="title">Maak een nieuwe reservering aan</h1>
        <form action="select-time.php" method="get">
            <div class="field">
                <label for="date_of" class="label">Selecteer een datum</label>
                <div class="control">
                    <input id="date_of" class="input" type="date" name="date_of" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button type="submit" name="submit" class="button is-link">Kies een tijd</button>
                </div>
            </div>
        </form>
    </div>
</section>

<footer>
    <div class="container">
        <div>
            <h2 class="has-text-black is-size-5">Contact</h2>
            <br>
            <p class="has-text-grey-darker">R.F. de Wit Auto's<br>Buitenweg 12<br>2931AC Krimpen aan de Lek</p>
            <p><img src="https://www.abk-kunststoffen.nl/uploads/imagemanager/rdw_erkend_breed.jpg" alt="RDW Erkend"></p>
        </div>

        <div>
            <br><br>
            <p class="has-text-grey-darker">M: 0642128724</p>
            <p class="has-text-grey-darker">E: <a href="mailto:RFdeWitautos@outlook.com">RFdeWitautos@outlook.com</a></p>
        </div>

        <div>
            <h2 class="has-text-black is-size-5">Openingstijden</h2>
            <br>
            <ul style="list-style: none; padding: 0;" class="has-text-grey-darker">
                <li>Maandag: 8:30 - 17:30</li>
                <li>Dinsdag: 8:30 - 17:30</li>
                <li>Woensdag: 8:30 - 17:30</li>
                <li>Donderdag: 8:30 - 17:30</li>
                <li>Vrijdag: 8:30 - 17:30</li>
                <li>Zaterdag: 10:00 - 15:00</li>
                <li>Zondag: Gesloten</li>
            </ul>
        </div>

        <div class="socials">
            <h2 class="has-text-black is-size-5">Onze socials</h2>
            <a href="https://www.facebook.com/rfdewitautos/" style="text-decoration: none;">
                <img src="https://z-m-static.xx.fbcdn.net/rsrc.php/v4/yD/r/5D8s-GsHJlJ.png" alt="Facebook">
            </a>
        </div>
    </div>
</footer>
</body>
</html>
