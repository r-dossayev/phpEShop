

<!doctype html>
<html lang="en">
<?php include_once 'head.php';
?>
<body>
<?php include_once 'navbar.php';

$user = getAuthUser();
if ($user == null) {
    header('location:login.php?error');
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h3> информация</h3>
            <hr>
            <p><span class="font-weight-bold">Счeт: </span><?php echo $user->balance ?> тг</p>
            <p><span class="font-weight-bold">Имя: </span> <?php echo $user->name ?></p>
            <p><span class="font-weight-bold">Last name: </span> <?php echo $user->last_name ?></p>
            <p><span class="font-weight-bold">username: </span> <?php echo $user->username ?></p>
            <p><span class="font-weight-bold">Последный вход: </span> <?php echo $user->last_login ?></p>
        </div>
        <div class="col-md-8">
            <h3>Заказы</h3>
            <hr>
            <table class="table">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Товар</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    <th>Время</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                {% for cart_item in cart_items %}
                <tr>
                    <td>{{ forloop.counter }}</td>
                    <td><a href="{{ cart_item.product.get_absolute_url }}">{{ cart_item.product.title }}</a></td>
                    <td>{{ cart_item.count }}</td>
                    <td>{{ cart_item.product.selling_price }} тг</td>
                    <td>{{ cart_item.created_at|timesince }} назад</td>
                    <td>куплено</td>
                </tr>
                {% endfor %}
                </tbody>
            </table>
        </div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Обнавить счет
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Обнавить счет</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{% url 'updateMoney' %}" method="post">
                            {% csrf_token %}
                            <label> тенге
                                <input type="number" name="money" placeholder="1000 тг" class="form-control">
                            </label>
                            <br>
                            <br>
                            <button type="submit" class="btn btn-primary">Обнавить</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыт</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>