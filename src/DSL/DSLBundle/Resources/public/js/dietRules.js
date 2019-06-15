var $collectionHolder;

var $addPeriodicityButton = $('<button type="button" class="add-periodicity">Add periodicity</button>');
var $newElement = $('<div></div>').append($addPeriodicityButton);

$collectionHolder = $('div#dsl_dslbundle_diet_rules_periodicities');

$collectionHolder.find('div.new-periodicity').each(function() {
    addTagFormDeleteLink($(this));
});

$collectionHolder.append($newElement);

$collectionHolder.data('index', $collectionHolder.find(':input').length);
$addPeriodicityButton.on('click', function(e) {
    addPeriodicityForm($collectionHolder, $newElement);
});

function addPeriodicityForm($collectionHolder, $newElement) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;

    newForm = newForm.replace(/__name__label__/g, index);
    newForm = newForm.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<div class="new-periodicity"></div>').append(newForm);
    $newElement.before($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button type="button">Delete this periodicity</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
    $tagFormLi.remove();
    });
}