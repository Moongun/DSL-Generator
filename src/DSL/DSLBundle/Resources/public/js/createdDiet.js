$(function () {
    console.log("DOM załadowany");

//load full info about meal
    $('.expand').on('click', function () {
        $(this).find('div').fadeToggle('slow');
    });

//drukowanie diety
//    $('#printDiet').on('click', function(){
//        $('#diet').show();
//        window.print();
//        console.log($('#diet'));
//    });



});

//JAVASCRIPT
function printDiv()
{
    //klonowanie kontenera, zeby nie zmieniac wyswietlanej na stronie
    var divToPrint = document.getElementById('diet').cloneNode('true');

    //usuwanie elementow, ktore sa nie potrzebne
    var elements = divToPrint.getElementsByClassName('description');
    while (elements.length > 0) {
        elements[0].parentNode.removeChild(elements[0]);
    }

    var summary = divToPrint.getElementsByTagName('h3');
    while (summary.length > 0) {
        summary[0].parentNode.removeChild(summary[0]);
    }

    //wstawianie przerw w odpowiednim miejscu
    var child = divToPrint.lastElementChild;
    for ($i = 0; $i < 4; $i++) {
        element = document.createElement('br');
        divToPrint.insertBefore(element, child);
    }

    //przygotowanie do drukowania
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
    newWin.document.close();

    setTimeout(function () {
        newWin.close();
    }, 10);

}

