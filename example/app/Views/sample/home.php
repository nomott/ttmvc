<html>
    <head>
        <title>ttmvc example</title>
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">

        <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
        }
        section {
            width: 800px;
            margin: 0 auto;
        }
        
        h1 {
            font-size: 30px;
        }

        h2 {
            font-size: 24px;
            font-weight: 400;
        }

        p {
            font-size: 18px;
            margin: 10px 0;
        }

        label {
            display: block;
            font-size: 14px;
        }
        input {
            font-size: 14px;
        }

        .mt80 {
            margin-top: 80px;
        }
        .mt80 {
            margin-top: 80px;
        }
        </style>
    </head>

    <body>
        <section>
            <h1>ttmvc example</h1>
            <h2>1. Example for passing parameter by post request:</h2>

            <p>Name will be changed after post submit:</p>
            <p> Hello <?= $name ?? 'World'; ?></p>

            <form method="post" action="">
                <label>Name</label>
                <input type="text" name="name" value="<?= $name ?? ''; ?>" />

                <input type="submit" value="Submit" />
            </form>
        </section>

        <section class="mt80">
            <h2>2. You can also pass parameters in URL:</h2>

            <div>
                <p><a href="<?= dirname($_SERVER['SCRIPT_NAME']); ?>/product/test1/"><?= (empty($_SERVER['HTTPS'])) ? 'http' : 'https'; ?>://<?= $_SERVER['HTTP_HOST']; ?><?= dirname($_SERVER['SCRIPT_NAME']); ?>/product/test1/</a></p>
                <p><a href="<?= dirname($_SERVER['SCRIPT_NAME']); ?>/product/test2/"><?= (empty($_SERVER['HTTPS'])) ? 'http' : 'https'; ?>://<?= $_SERVER['HTTP_HOST']; ?><?= dirname($_SERVER['SCRIPT_NAME']); ?>/product/test2/</a></p>
            </div>
        </section>
    </body>
</html>
