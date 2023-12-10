<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <a class="navbar-brand" href="/">Apple</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Категории
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <?php
                    require_once 'db.php';
                    $cats = getCategories();
                    foreach($cats as $cat){
                        ?>
                        <a class="dropdown-item" href="index.php?category_id=<?=$cat->id?>"><?=$cat->name?></a>
                        <?php
                    }
                    ?>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">Про нас</a>
            </li>

            <li class="nav-item">
                <?php
                require_once 'db.php';
                if (getAuthUser() != null && getAuthUser()->role !== 'ADMIN') {
                    ?>
                    <a class="nav-link" href="#">Корзина</a>
                <?php } ?>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Мой профиль
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    require_once 'db.php';
                    if (getAuthUser() != null) {
                        ?>
                        <a class="dropdown-item" href="profile.php">Профиль</a>
                        <a class="dropdown-item" href="logout.php">Выйти</a>
                        <?php
                        if (getAuthUser()->role === 'ADMIN') {
                            ?>
                            <a class="dropdown-item" href="additem.php">Добавить товар</a>
                            <?php
                        }
                    } else {?>
                        <a class="dropdown-item" href="login.php">Логин</a>
                        <a class="dropdown-item" href="registration.php">Регистрация</a>
                    <?php } ?>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
            <input name="keyword" class="form-control mr-sm-2" type="search" placeholder="поиск" aria-label="Search"
                   required>
            <button class="btn btn-info my-2 my-sm-0" type="submit">Поиск</button>
        </form>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>