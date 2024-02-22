<!DOCTYPE html>
<head>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .instruction-list {
            list-style: decimal;
            padding-left: 20px;
        }
        .top-list {
            list-style: circle;
            padding-left: 20px;
        }
        .instruction-item {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <ol class="top-list">
            <li class="instruction-item">Основные опции представлены в меню слева</li>
            <li class="instruction-item">
                Пункт "Загрузить Файл" позволяет загрузить и предварительно просмотреть загруженный файл:
                <ol class="instruction-list">
                    <li class="instruction-item">Нажмите на иконку облачка чтобы выбрать PDF файл для загрузки</li>
                    <li class="instruction-item">Нажмите "Загрузить файл" чтобы загрузить файл на сервер и подготовить его к рассылке. </li>
                    <li class="instruction-item">Нажмите "Удалить файл" чтобы удалить загруженный файл и получить возможность выбрать новый</li>
                </ol>
            </li>
            <li class="instruction-item">
                Пункт "Редактирование Получателей" позволяет редактировать список получателей файла:
                <ol class="instruction-list">
                    <li class="instruction-item">Кнопка "Добавить получателя" открывает страницу на которой можно добавть получателя.</li>
                    <li class="instruction-item">В качестве адреса можно использовать e-mail или ID чата telegram (бот должен иметь право писать в этот чат)</li>
                    <li class="instruction-item">Действие "Править" позволяет редактировать получателя, действие "Удалить" удаляет его</li>
                </ol>
            </li>
            <li class="instruction-item">
                Пункт "Отправить Файл" позволяет просмотреть список получаетелей и отправить файл:
                <ol class="instruction-list">
                    <li class="instruction-item">Файл будет отправлен получателям отмеченным галочкой, её можно снять или поставить при желании на этом экране </li>
                    <li class="instruction-item">Нажмите "Отправить Файл" чтобы запустить рассылку</li>
                </ol>
            </li>
        </ol>
    </div>
</body>
</html>
