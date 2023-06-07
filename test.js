
const dry_food = document.getElementById('dry-food-non');
const wet_food = document.getElementById('wet-food-non');
const lunch = document.getElementById('lunch-non');
const candy = document.getElementById('candy-non');
const coffee = document.getElementById('coffee-non');
const tea = document.getElementById('tea-non');
const mineral_water = document.getElementById('mineral-water-non');
const soft_drink = document.getElementById('soft-drink-non');
const helm = document.getElementById('helm-non');
const handuk = document.getElementById('handuk-non');
const speaker = document.getElementById('speaker-non');
const speaker_wireless = document.getElementById('speaker-wireless-non');
const motor = document.getElementById('motor-non');
const mobil = document.getElementById('mobil-non');
const mini_bus = document.getElementById('mini-bus-non');
const bus = document.getElementById('bus-non');
// const checkbox = document.getElementById('dry-food-non');
// const checkbox = document.getElementById('dry-food-non');

// food
$('#dry-food-non-quantity').hide();
$('#wet-food-non-quantity').hide();
$('#lunch-non-quantity').hide();
$('#candy-non-quantity').hide();
$("input[type='checkbox']").on("change", function() {
    if (this.checked) {
        if (this == dry_food) {
            $('#dry-food-non-quantity').show();
        } else if (this == wet_food) {
            $('#wet-food-non-quantity').show();
        } else if (this == lunch) {
            $('#lunch-non-quantity').show();
        } else if (this == candy) {
            $('#candy-non-quantity').show();
        }
    } else {
        if (this == dry_food) {
            $('#dry-food-non-quantity').hide();
        } else if (this == wet_food) {
            $('#wet-food-non-quantity').hide();
        } else if (this == lunch) {
            $('#lunch-non-quantity').hide();
        } else if (this == candy) {
            $('#candy-non-quantity').hide();
        }
    }
});

// drink
$('#coffee-non-quantity').hide();
$('#tea-non-quantity').hide();
$('#soft-drink-non-quantity').hide();
$('#mineral-water-non-quantity').hide();
$("input[type='checkbox']").on("change", function() {
    if (this.checked) {
        if (this == coffee) {
            $('#coffee-non-quantity').show();
        } else if (this == tea) {
            $('#tea-non-quantity').show();
        } else if (this == soft_drink) {
            $('#soft-drink-non-quantity').show();
        } else if (this == mineral_water) {
            $('#mineral-water-non-quantity').show();
        }
    } else {
        if (this == coffee) {
            $('#coffee-non-quantity').hide();
        } else if (this == tea) {
            $('#tea-non-quantity').hide();
        } else if (this == soft_drink) {
            $('#soft-drink-non-quantity').hide();
        } else if (this == mineral_water) {
            $('#mineral-water-non-quantity').hide();
        }
    }
});

// Plant tour
$('#helm-non-quantity').hide();
$('#handuk-non-quantity').hide();
$('#speaker-non-quantity').hide();
$('#speaker-wireless-non-quantity').hide();
$("input[type='checkbox']").on("change", function() {
    if (this.checked) {
        if (this == helm) {
            $('#helm-non-quantity').show();
        } else if (this == handuk) {
            $('#handuk-non-quantity').show();
        } else if (this == speaker) {
            $('#speaker-non-quantity').show();
        } else if (this == speaker_wireless) {
            $('#speaker-wireless-non-quantity').show();
        }
    } else {
        if (this == helm) {
            $('#helm-non-quantity').hide();
        } else if (this == handuk) {
            $('#handuk-non-quantity').hide();
        } else if (this == speaker) {
            $('#speaker-non-quantity').hide();
        } else if (this == speaker_wireless) {
            $('#speaker-wireless-non-quantity').hide();
        }
    }
});

// Parkir
$('#motor-non-quantity').hide();
$('#mobil-non-quantity').hide();
$('#mini-bus-non-quantity').hide();
$('#bus-non-quantity').hide();
$("input[type='checkbox']").on("change", function() {
    if (this.checked) {
        if (this == motor) {
            $('#motor-non-quantity').show();
        } else if (this == mobil) {
            $('#mobil-non-quantity').show();
        } else if (this == mini_bus) {
            $('#mini-bus-non-quantity').show();
        } else if (this == bus) {
            $('#bus-non-quantity').show();
        }
    } else {
        if (this == motor) {
            $('#motor-non-quantity').hide();
        } else if (this == mobil) {
            $('#mobil-non-quantity').hide();
        } else if (this == mini_bus) {
            $('#mini-bus-non-quantity').hide();
        } else if (this == bus) {
            $('#bus-non-quantity').hide();
        }
    }
});

});