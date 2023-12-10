<?php


include_once 'db.php';
if (getAuthUser() == null || getAuthUser()->role != 'ADMIN') {
    header("Location: index.php");
    exit;
}
if(isset($_POST['role'])){
    $var = updateRole($_POST['user_id'], $_POST['role']);
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main">
        <div class="container mt-4">
            <h2>Пользователи</h2>

            <table class="table mt-2 roles_table">
                <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Логин</th>
                        <th>Роль</th>
                        <th>Действия</th>
<!--                        <th>Статус</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $resultUsers = getUsers();

                    if ($resultUsers != null && count($resultUsers) > 0)
                    foreach($resultUsers as $user):
                    ?>
                    <tr>
                        <td><?php echo $user->name ?></td>
                        <td><?php echo $user->last_name ?></td>
                        <td><?php echo $user->username ?></td>
                        <td><?php echo $user->role ?></td>
                        <td>
                            <form action="users.php" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user->id ?>">
                                <select name="role" id="role">
                                    <option <?php if($user->role == 'ADMIN') echo 'selected' ?> value="ADMIN">Админ</option>
                                    <option <?php if($user->role == 'USER') echo 'selected' ?> value="USER">Пользователь</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Изменить роль</button>
                            </form>
                        </td>

                    </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
