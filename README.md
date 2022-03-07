## Задача

1. Сделать категории номеров:
   * Одноместный
   * Двуместный
   * Люкс
   * Де-Люкс
   <br>
   <br>
   У каждой категории - определенное число доступных комнат. 2, 4, 3, 5 - соответственно.

2. Сделать форму поиска с выбором даты *заселения* и *убытия*
3. Вывести доступные номера
4. Сделать форму бронирования с вводам *имени* и *почты*
5. Оповещение об успешном бронировании

## Условия
1. Выполнять на Yii2 + Vue 3

### Пояснение:

- Категория - Двухместный номер.
- Количество номеров - 1
- Была одна бронь номера с 8 по 10 марта

а. При фильтре с 1 по 25 марта, номера из этой категории не должны выводиться
б. При фильтре с 1 по 7 марта, выводится 1 доступный номер.

<hr>

- Категория - Одноместный номер
- Количество номеров - 2
- Была одна бронь номера с 8 по 10 марта

а. При фильтре с 1 по 25 марта, выводится 1 доступный номер.
б. При фильтре с 1 по 7 марта, выводится 2 доступных номера.


## Запуск проекта

1. docker-compose build
2. docker-compose up -d
3. docker-compose exec php ./yii migrate --interactive=0
