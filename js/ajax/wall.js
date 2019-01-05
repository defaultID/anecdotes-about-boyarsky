var wall = {
    startData: 0, //Начальная позиция выборки
    selectorButton: '#wallButton',
    flagLoadDataNow: false, //Началась ли загрузка данных с сервера

    run: function () {
        this.onLoadData();
        $(this.selectorButton).on('click', this.onLoadData.bind(this));
    },
    /**
     * Метод подгрузки данных с сервера
     */
    onLoadData: function () {
        var self = this;
        $.ajax({
            url: 'server/wall/wall.php',
            type: 'get',
            data: {"wallOffset": self.startData}, //Отступ от начала выборки
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                //Защита от дублирования
                if (self.flagLoadDataNow){
                    return false; //Если загрузка уже идёт, не начинаем новый запрос
                }
                self.flagLoadDataNow = true; //Ставим блокировку
                //console.log('Блокировка - start');
                return true;
            },
            success: function (data) {
                function time_format(t){
                    var day, month, year, time;
                    day = t.substr(8,2);
                    month = t.substr(5,2);
                    year = t.substr(0,4);
                    time = t.substr(10,6);
                    return day+"."+month+"."+year+time;
                }
                if (data.length === 0){
                    //console.log('Отсутствуют новые записи');
                    $(self.selectorButton).hide();
                    return; //Выход
                }
                for (var i = 0; i < data.length; i++){
                    data[i].title = data[i].title.replace(/\n/gi, "<br>");
                    data[i].date = time_format(data[i].date);
                    var htmlCodeItem = $('#template').tmpl(data[i]);
                    $('#wall').append(htmlCodeItem);
                    if (getcookie(data[i]['id'])){
                        $('.' + data[i]['id']).attr('rel', 'Unlike').attr('class', 'doneLike like ' + data[i]['id']);
                    }
                    self.startData++;
                }

                //Ставим точку, где закончились записи
                /*var $point = $('<hr class ="point">'); //Метка
                $('#wall').find('.point').remove(); //Удаляем все предыдущие метки
                $('#wall').append($point);*/

                self.flagLoadDataNow = false; //Снимаем блокировку
                //console.log('Блокировка - end');
            }
        });
    },
    /**
     * Метод реализует автоматическую подгрузку данных при прокрутке ленты
     */
    goScroll: function () {
        var self = this;
        $(self.selectorButton).hide(); //Скрываем кнопку "Показать ещё"
        $(document).on('scroll', function () {
            var point = $('.point:last').offset().top; //Точка, где заканчиваются новые записи
            var scrollNow = $(this).scrollTop(); //Насколько прокручена страница сверху (без учета высоты окна)
            var height = $(window).height(); //Высота окна
            var loadDataFlag = scrollNow + height >= point; //Флаг. Подгружаем ли данные
            //console.log(scrollNow, point, loadDataFlag);

            //Если пользователь прокрутил страницу ниже метки и загрузка данных ещё
            //не началась подгружаем данные с помощью self.onLoadData();
            if (loadDataFlag && !self.flagLoadDataNow){
                self.onLoadData();
            }
        })
    },
};

$(document).ready(function() {
    //wall.goScroll();
    //wall.onLoadData();
    wall.run();
});