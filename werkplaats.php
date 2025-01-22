<?php
?>
<head>
    <meta charset="UTF-8">
    <title>R.F. de Wit Auto's - Werkplaats</title>
    <link rel="stylesheet" href="my-bulma-project.css">
    <style>
        .slideshow-container {
            position: relative;
            max-width: 100%;
            height: 50vh;
            overflow: hidden;
        }

        .slideshow-container img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slideshow-container img.active {
            opacity: 1;
        }

        .slideshow-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            text-align: center;
            z-index: 1;
        }

        .slideshow-container .image-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Custom styling for articles section */
        .articles-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .article {
            width: 45%;
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .article img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .article-content {
            margin-top: 10px;
        }

        .article h2 {
            font-size: 1.5em;
            color: #333;
        }

        .article p {
            color: #666;
        }

    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.slideshow-container img');
            const text = document.querySelector('.slideshow-text');
            let currentIndex = 0;

            function showNextImage() {
                images[currentIndex].classList.remove('active');
                currentIndex = (currentIndex + 1) % images.length;
                images[currentIndex].classList.add('active');

                // Show or hide the text every 10 seconds
                if (currentIndex === 0) {
                    text.style.opacity = 1;
                } else {
                    text.style.opacity = 0;
                }
            }

            setInterval(showNextImage, 10000);
        });
    </script>
</head>
<body>
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <figure class="image is-150x150px">
                <img src="https://rfdewitautos.nl/wp-content/uploads/2018/11/RF-de-wit-autos-logo.png" alt="logo"/>
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
            <a class="navbar-item" href="hometryaya.php">
                Home
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Occasions
                </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item" href="#">
                        Auto leasen
                    </a>
                    <a class="navbar-item" href="#">
                        Auto kopen
                    </a>
                    <a class="navbar-item" href="contact.php">
                        Contact
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="#">
                        Meld een probleem
                    </a>
                </div>
            </div>

            <a class="navbar-item" href="werkplaats.php">
                Werkplaats
            </a>
            <a class="navbar-item" href="select-date.php.php">
                Reserveren
            </a>
            <a class="navbar-item" href="contact.php">
                Contact
            </a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-primary">
                        <strong>+31 6 421 28724</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar-end">
        <div class="navbar-item">
            <div class="buttons">
                <a href="login.php" class="button is-primary">
                    <strong> Login medewerkers</strong>
                </a>
            </div>
        </div>
    </div>
</nav>

<main>
    <section class="slideshow-container">
        <div class="slideshow-text">
            <h1 class="title">RF de Wit Auto's</h1>
            <p class="subtitle">Voor inkoop en verkoop van jonge gebruikte auto's</p>
        </div>
        <img src="https://rfdewitautos.nl/wp-content/uploads/2022/04/occasions-home.jpg" alt="auto" class="active">
        <img src="https://rfdewitautos.nl/wp-content/uploads/2020/03/RF-de-Wit-Autos-Krimpen-ad-Lek-aug19-1-1024x683.jpg"
             alt="auto foto">
    </section>


    <!-- Articles section -->
    <section class="section">
        <div class="container">
            <h2 class="title">Werkplaats</h2>
            <p>Heeft uw auto onderhoud nodig of is er wat defect? In onze werkplaats zullen wij u op vakkundige
                en professionele wijze weer op weg helpen. Voor een APK kunt u altijd zonder afspraak
                terecht.</p>
            <br>
            <div class="articles-container">
                <div class="article">
                    <img src="https://rfdewitautos.nl/wp-content/uploads/2020/05/APK-Keuring-e1589198916973.jpg"
                         alt="Article Image">
                    <div class="article-content">
                        <h2>APK keuringstation</h2>
                        <p>Het is mogelijk bij ons om de Apk uit te laten voeren voor zowel Benzine,Diesel als LPG
                            Auto's.

                            U kunt uw auto bij ons laten keuren in krimpen aan den IJssel of in krimpen aan de Lek.

                            Een Apk keuring duurt ongeveer 15 Min. U hoeft hier geen afspraak voor te maken.
                            Eventuele kleine reparaties kunnen wij direct uitvoeren.

                            Apk Categorie
                            Wij kunnen de Apk voor alle Auto's uitvoeren tot 3500Kg.
                            Dit houdt ook de grotere voertuigen in zoals Campers en bussen.
                            Wij hebben hiervoor een speciale garagebrug en verzwaarde remmentestbank.
                        </p>
                    </div>
                </div>

                <div class="article">
                    <img src="https://rfdewitautos.nl/wp-content/uploads/2020/04/Ruitschade-sterreparatie.jpg"
                         alt="Article Image">

                    <div class="article-content">
                        <h2>Ruitschade</h2>
                        <p>
                            Dat ene steentje op de weg wat net weer tegen je vooruit aan knalt, vervolgens wordt dat
                            kleine sterretje een gigantische scheur of zit je voorruit vol met kleine gebarsten
                            stukjes...

                            Wist je dat we bij R.F. de Wit ook sterreparaties doen?
                            Voor een vaste prijs van €34,99 is jouw voorruit weer als nieuw!
                        </p>
                    </div>
                </div>

                <div class="article">
                    <img src="https://rfdewitautos.nl/wp-content/uploads/2020/04/airco-onderhoud.jpg"
                         alt="Article Image">
                    <div class="article-content">
                        <h2>Airco onderhoud</h2>
                        <p>
                            U kunt bij R.F. de Wit auto's ook terecht voor het onderhoud aan uw airco.
                            In de warme zomerdagen is uw airco natuurlijk onmisbaar,
                            maar ook in de andere seizoenen is een goedwerkende airco geen overbodige luxe.
                            Aan de hand van regelmatig onderhoud bent u er zeker van het hele jaar door van een volledig
                            werkende airco te profiteren.
                        </p>
                    </div>
                </div>

                <div class="article">
                    <img src="https://rfdewitautos.nl/wp-content/uploads/2020/05/Motor-reparatie-jeroen-e1589206953473.jpg"
                         alt="Article Image">
                    <div class="article-content">
                        <h2>Motor reparaties</h2>
                        <p>
                            U kunt bij ons terecht voor het onderhoud of reparatie van uw motor,
                            ongeacht welk merk het is. Ook zelf gebrachte onderdelen is voor ons geen probleem,
                            bel voor de mogelijkheden!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer style="background-color: #f4f4f4; padding: 20px;">
    <div style="display: flex; justify-content: space-between; flex-wrap: wrap; max-width: 1200px; margin: auto;">
        <!--      <h1> <strong>contact</strong>Contact</h1>-->
        <div style="flex: 1; min-width: 250px;">
            <h2 class="has-text-black is-size-5	">Contact</h2>
            <br>
            <p class=" has-text-grey-darker	">R.F. de Wit Auto's<br>Buitenweg 12<br>2931AC Krimpen aan de Lek</p>
            <p><img src="https://www.abk-kunststoffen.nl/uploads/imagemanager/rdw_erkend_breed.jpg" alt="RDW Erkend"
                    style="height: 40px; margin-top: 10px;"></p>

        </div>

        <div style="flex: 1; min-width: 250px;">
            <br>
            <br>
            <p class=" has-text-grey-darker">M: 0642128724</p>
            <p class=" has-text-grey-darker">E: <a href="mailto:RFdeWitautos@outlook.com">RFdeWitautos@outlook.com</a>
            </p>
        </div>


        <div style="flex: 1; min-width: 250px;">
            <h2 class="has-text-black is-size-5	">Openingstijden</h2>
            <br>
            <ul style="list-style: none; padding: 0;" class=" has-text-grey-darker">
                <li>Maandag: 8:30 - 17:30</li>
                <li>Dinsdag: 8:30 - 17:30</li>
                <li>Woensdag: 8:30 - 17:30</li>
                <li>Donderdag: 8:30 - 17:30</li>
                <li>Vrijdag: 8:30 - 17:30</li>
                <li>Zaterdag: 10:00 - 15:00</li>
                <li>Zondag: Gesloten</li>
            </ul>
        </div>

        <div style="flex: 1; min-width: 250px;">
            <h2 class="has-text-black is-size-5	">Onze socials</h2>
            <p>
                <br>
                <a href="https://www.facebook.com/rfdewitautos/" style="text-decoration: none;">
                    <img src="https://z-m-static.xx.fbcdn.net/rsrc.php/v4/yD/r/5D8s-GsHJlJ.png" alt="Facebook"
                         style="height: 30px;">
                </a>
        </div>
    </div>
</footer>
</body>
</html>