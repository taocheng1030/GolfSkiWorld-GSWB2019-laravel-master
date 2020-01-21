function LocationInfo()
{
    var rootUrl = "/location/api.php";
    var call = new AjaxCall();

    this.loadCountry = false;

    this.getCities = function (id) {
        $(".cities option").remove();

        var url = rootUrl + '?type=getCities&stateId=' + id;
        call.send(url, "post", {}, function (data) {
            dropDown($(".cities"), data);
        });
    };

    this.getStates = function (id) {
        $(".states option").remove();
        $(".cities option").remove();

        var url = rootUrl + '?type=getStates&countryId=' + id;
        call.send(url, "post", {}, function (data) {
            dropDown($(".states"), data);
        });
    };

    this.getCountries = function () {
        var selected_option = $('.countries option:selected');
        if (!selected_option) {
            $(".countries option").remove();
            $(".states option").remove();
            $(".cities option").remove();
        }

        var url = rootUrl + '?type=getCountries';
        call.send(url, "post", {}, function (data) {
            dropDown($(".countries"), data);
        });
    };

    function dropDown (element, data) {
        console.log(data);
        if (data.tp == 1) {
            $.each(data['result'], function (key, val) {
                element.append($('<option>', {val: key}).text(val));
            });
            element.prop("disabled", false);
        }
        else {
            alert(data.msg);
        }
    }
}

$(document).ready(function ()
{
    var countries = $(".countries");
    var states = $(".states");

    var loc = new LocationInfo();

    if (loc.loadCountry && countries.length > 0)
        loc.getCountries();

    countries.on("change", function (ev) {
        var countryId = $(this).val();
        if (countryId != '') {
            loc.getStates(countryId);
        }
        else {
            $(".states option:gt(0)").remove();
        }
    });

    states.on("change", function (ev) {
        var stateId = $(this).val();
        if (stateId != '') {
            loc.getCities(stateId);
        }
        else {
            $(".cities option:gt(0)").remove();
        }
    });
});
