<?php
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>R.F. de Wit Auto's - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
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
            <a class="navbar-item" href="#">
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
                    <a class="navbar-item" href="#">
                        Contact
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="#">
                        Meld een probleem
                    </a>
                </div>
            </div>

            <a class="navbar-item" href="#werkplaats">
                Werkplaats
            </a>
            <a class="navbar-item" href="#">
                Reserveren
            </a>
            <a class="navbar-item" href="#contact">
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
        <img src="https://rfdewitautos.nl/wp-content/uploads/2020/03/RF-de-Wit-Autos-Krimpen-ad-Lek-aug19-1-1024x683.jpg" alt="auto foto">
    </section>

    <section class="section has-background-white has-text-black" id="werkplaats" style="border-top: 2px solid black;">
        <div class="container">
            <div class="columns is-align-items-center has-text-black">
                <div class="column is-half">
                    <figure class="image" style="max-width: 40%; margin-left: 0; border: 1px solid grey;">
                        <img src="https://rfdewitautos.nl/wp-content/uploads/2020/03/Werkplaats.png" alt="werkplaats">
                    </figure>
                </div>
                <div class="column is-half">
                    <h2 class="title has-text-black">Werkplaats</h2>

                    <p>Heeft uw auto onderhoud nodig of is er wat defect? In onze werkplaats zullen wij u op vakkundige en professionele wijze weer op weg helpen. Voor een APK kunt u altijd zonder afspraak terecht.</p>
                    <p class="has-text-black"><strong class="has-text-black">Direct contact met de werkplaats: 0180-444381</strong></p>
                </div>
            </div>
        </div>
    </section>



    <section class="section" id="contact">
        <div class="container">
            <div class="columns is-align-items-center">
                <div class="column is-half">
                    <h2 class="title">Contact</h2>

                    <p>Heeft u een vraag aan ons over een reservatie of reparatie? Neem via verschillende kanalen contact op om uw vraag beantwoord te krijgen.</p>
                    <a href="contact.php" class="button is-link">Naar contact</a>
                </div>
                <div class="column is-half">
                    <figure class="image ml-auto" style="max-width: 40% ; border: 1px solid grey;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSG4-EfjeqnQslft0KqGRLDlkeIYRblR5cc6A&s" alt="contact">
                    </figure>
                </div>
            </div>
        </div>
    </section>



</main>
</body>

<footer style="background-color: #f4f4f4; padding: 20px;">
    <div style="display: flex; justify-content: space-between; flex-wrap: wrap; max-width: 1200px; margin: auto;">
        <!--      <h1> <strong>contact</strong>Contact</h1>-->
        <div style="flex: 1; min-width: 250px;">
            <h2 class="has-text-black is-size-5	">Contact</h2>
            <br>
            <p class=" has-text-grey-darker	">R.F. de Wit Auto's<br>Buitenweg 12<br>2931AC Krimpen aan de Lek</p>
            <p><img src="https://www.abk-kunststoffen.nl/uploads/imagemanager/rdw_erkend_breed.jpg" alt="RDW Erkend" style="height: 40px; margin-top: 10px;"></p>

        </div>

        <div style="flex: 1; min-width: 250px;">
            <br>
            <br>
            <p  class=" has-text-grey-darker">M: 0642128724</p>
            <p  class=" has-text-grey-darker">E: <a href="mailto:RFdeWitautos@outlook.com">RFdeWitautos@outlook.com</a></p>
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
                    <img src="https://z-m-static.xx.fbcdn.net/rsrc.php/v4/yD/r/5D8s-GsHJlJ.png" alt="Facebook" style="height: 30px;">
                </a>
        </div>
    </div>
</footer>

</html>