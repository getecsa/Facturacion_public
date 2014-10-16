function ocultar(pElemento)
{
  $(pElemento).fadeOut("slow");
}

function FixHeader(pContainerId, pGridviewId) {
    var _headContainerId = pContainerId + "Header";
    var _headGridViewId = _headContainerId + "GV";

    $("#" + pContainerId).clone().insertBefore("#" + pContainerId).attr("id", _headContainerId);

    $("#" + _headContainerId + " tr").css({ visibility: "hidden" });
    $("#" + _headContainerId + " td").css({ borderColor: "Transparent" });
    $("#" + _headContainerId + " tr").first().css({ visibility: "visible", borderBottom: "1px solid gray" });

    $("#" + _headContainerId).height($("#" + _headContainerId + " tr").first().outerHeight(true));

    $("#" + _headContainerId).css({ marginBottom: "0px", overflow: "hidden" });
    $("#" + pContainerId).css({ marginTop: "0px" });

    $("#" + _headContainerId + " table").attr("id", _headGridViewId);

    $("#" + _headGridViewId).width($("#" + pGridviewId).outerWidth() + "px");

    $("#" + pContainerId + " table").css({ marginTop: "-" + $("#" + pContainerId + " tr").outerHeight(true) + "px" });

    $("#" + pContainerId).scrollLeft(99999);
    $("#" + _headContainerId).scrollLeft(99999);

    $("#" + pContainerId).width(
        $("#" + pContainerId).width() + ($("#" + pContainerId).scrollLeft() - $("#" + _headContainerId).scrollLeft())
    );

    $("#" + pContainerId).scrollLeft(0);
    $("#" + _headContainerId).scrollLeft(0);

    if ($("#" + pContainerId + " tr.selected").length)
        $("#" + pContainerId + " tr.selected input").focus().blur();

    $("#" + pContainerId).scroll(function () { $("#" + _headContainerId + "").scrollLeft($("#" + pContainerId).scrollLeft()) });
}