<!doctype html>
<html lang="en">
<head>
    <title>Nieuwe reservering - datum</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<section class="container">
    <div class="content">
        <h1 class="title">Maak een nieuwe reservering aan</h1>

        <form action="select-time.php" method="get">

            <div class="field">
                <label for="date" class="label">Selecteer een datum</label>
                <div class="control">
                    <input id="date" class="input" type="date" name="date" value="<?= date('Y-m-d') ?>">
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link">Kies een tijd</button>
                </div>
            </div>
        </form>
    </div>
</section>
</body>
</html>