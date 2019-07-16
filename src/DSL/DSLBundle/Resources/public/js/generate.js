$(document).ready(function(){
    var dietTable = $('table#diet');
    var BodyDietTable = $('table#diet tbody');

    BodyDietTable .sortable();

    var refresh = $('#refresh-diet');

    refresh.on('click', function(e) {
        location.reload();
    })

    var rule = dietTable.data('rule');
    var save = $('#save-diet');

    save.on('click', function (e) {
        var days = dietTable.find('.day');
        var state = getState(days);

        $.ajax({
            method: 'POST',
            url: Routing.generate('createddiet_save'),
            data: {
                rule: rule,
                diet: state
            }
        }).done(function(msg){
            location.href = Routing.generate('createddiet_show', {'id': rule})
        }).fail(function(XMLHttpRequest, textStatus, errorThrown){
            console.error(textStatus + ' ' + errorThrown);
        })
    })

    function getState(days) {
        var state = {};

        days.each(function(index){
            var dayTr = $(days[index]);
            var day = index+1;

            var meals = dayTr.find('.meal')

            // daysMealsIds (position in array): 0-breakfast, 1-brunch, 2-lunch, 3-dinner, 4-supper
            var dayMealIds = [];
            meals.each(function(i){
                var mealTd = $(meals[i]);
                var meal = mealTd.data('meal');
                dayMealIds[i] = meal
            })
            state[day] = dayMealIds
        })

        return state
    }

    var meals = $('.meal');

    meals.on('click', function (e) {
        var meal = $(this);
        var details = meal.data('details');
        var dialog = $(document.createElement('div'));

        dialog.html(function(){
            return `<div class="container">
                                <div class="row">
                                    <div class="col-lg-5">typ:</div>
                                    <div class="col-lg-7">${details.type}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5">wartość energetyczna [kcal]:</div>
                                    <div class="col-lg-7">${details.energy}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5">białko [g]:</div>
                                    <div class="col-lg-7">${details.protein}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5">węglowodany [g]:</div>
                                    <div class="col-lg-7">${details.carbohydrates}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5">tłuszcze [g]:</div>
                                    <div class="col-lg-7">${details.fat}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5">średni koszt [zł]:</div>
                                    <div class="col-lg-7">${details.avgCost}</div>
                                </div>
                                <div class="pt-4">przygotowanie:</div>
                                <div>${details.description}</div>
                            </div>`
        });
        dialog.dialog({
            'modal':true,
            'title':details.name,
            'width': 600
        });
    })

    var dayTds = $('.day').children('.day-td');
    dayTds.hover(
        function() {
            var dayMeals = $(this).parent().children('.meal');
            var summary = getDaySummary(dayMeals)
            $(this).attr('title',
                `Podsumowanie dnia:
wartość energetyczna: ${summary.energy} kcal/dzień
białko: ${summary.protein} g/dzień
węglowodany: ${summary.carbohydrates} g/dzień
tłuszcze: ${summary.fat} g/dzień
średni koszt: ${summary.avgCost} zł`);

            $(this).tooltip({
                "track": true
            })

        }, function() {
            return;
        });

    function getDaySummary(meals) {

        var summary = {'energy': 0, 'protein': 0, 'carbohydrates': 0, 'fat': 0, 'avgCost': 0};
        meals.each(function(i) {
            var meal = $(meals[i]);
            var details = meal.data('details');
            summary.energy += details.energy;
            summary.protein += details.protein;
            summary.carbohydrates += details.carbohydrates;
            summary.fat += details.fat;
            summary.avgCost = (parseFloat(summary.avgCost)+parseFloat(details.avgCost)).toFixed(2);
        })
        return summary;
    }
})