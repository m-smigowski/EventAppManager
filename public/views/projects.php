<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/projects.css">

    <script src="https://kit.fontawesome.com/723297a893.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <title>PROJECTS</title>
</head>

<body>
<div class="base-container">
    <nav>
        <div class="main-logo"><a href="/main">EVENT MENAGER APP</a></div>
        <ul>
            <li>
                <i class="fas fa-project-diagram"></i>
                <a href="/projects" class="button">Projekty</a>
            </li>
            <li>
                <i class="fas fa-project-diagram"></i>
                <a href="/events" class="button">Wydarzenia</a>
            </li>
            <li>
                <i class="fas fa-project-diagram"></i>
                <a href="#" class="button">Spotkania</a>
            </li>
            <li>
                <i class="fas fa-project-diagram"></i>
                <a href="#" class="button">Magazyn</a>
            </li>
            <li>
                <i class="fas fa-project-diagram"></i>
                <a href="#" class="button">Panel użytkownika</a>
            </li>
        </ul>
        <div id="logged"><?php echo $_SESSION['user_name'];echo $_SESSION['user_id'] ?></div>
    </nav>
    <main>
        <header>
            <div class="search-bar">
                <input placeholder="search project">
            </div>
            <div class="add-project">
                <i class="fas fa-plus"></i><a href="/addProject">add project</a>
            </div>
        </header>
        <section class="projects">
            <?php foreach ($projects as $project): ?>

            <div id="project-1">
                <img src="public/img/uploads/<?= $project->getImage()?>">
                <div>
                    <h2><?=$project->getTitle();?></h2>
                    <p><?=$project->getDescription();?></p>
                    <div class="social-section">
                        <i class="fas fa-heart"> 600</i>
                        <i class="fas fa-minus-square"> 121</i>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </section>
    </main>
</div>
</body>

<template id="project-template">
<div id="project-1">
    <img src="">
    <div>
        <h2>title</h2>
        <p>description</p>
        <div class="social-section">
            <i class="fas fa-heart"> 0</i>
            <i class="fas fa-minus-square">0</i>
        </div>
    </div>
</div>

</template>