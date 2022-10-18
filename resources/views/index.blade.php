<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>All In One Music</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/index.css">
        <link rel="stylesheet" href="/css/aiom.css">
    </head>
    <body>
    
<video id="background-video" autoplay loop muted>
    <source src="/storage/portada.mp4" type="video/mp4">
    </video>
    <div id="filter"></div>
            <div class="logotipo">
                <h1>AIOM</h1>
                <h2>All In One Music</h2>
                <div class="align-buttons-div">
                    <div>
                        <a class="btn btn-primary"href="/register" >Hazte una cuenta</a>
                        <a class="btn btn-primary" href="/login">Entra en tu cuenta</a>
                    </div>
                </div>
            </div>
    </body>
</html>