<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <a class="navbar-brand" href="index.php">Apple</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Главная <span class="sr-only">(current)</span></a>
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
                    <a class="nav-link" href="mycart.php">Корзина</a>
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
                    } else {?>
                        <a class="dropdown-item" href="login.php">Логин</a>
                        <a class="dropdown-item" href="registration.php">Регистрация</a>
                    <?php } ?>
                </div>
            </li>
            <?php if (getAuthUser() != null && getAuthUser()->role === 'ADMIN') { ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        ADMIN
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="admin_add_product.php">Add product</a>
                            <a class="dropdown-item" href="users.php">Users</a>
                    </div>
                </li>
            <?php } ?>

        </ul>
        <button style="margin-right: 20px" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            filter
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="get" action="index.php">
                            цена от: <input class="form-control mr-sm-2" type="number" name="price_from">
                            до: <input class="form-control mr-sm-2" type="number" name="price_to">
                            сначала <select class="form-control mr-sm-2" name="sort_type">
                                <option value="price_asc">по возрастанию цены</option>
                                <option value="price_desc">по убыванию цены</option>
                                <option value="name_asc">по имени А-Я</option>
                                <option value="name_desc">по имени Я-А</option>
                            </select>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Применить</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыт</button>

                    </div>
                </div>
            </div>
        </div>

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