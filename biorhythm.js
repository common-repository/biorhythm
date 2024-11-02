<!-- Biorhythm javascript START -->
function validateColor(color_obj) {
    regexp_str = "((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?),){2}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)";
    re = new RegExp(regexp_str);
    if (!re.test(color_obj.value)) {
        alert("The color must be in RGB format with comma separator\n"+"(e.g. 255,0,0)");
        color_obj.value = "";
        color_obj.focus();
    }
}

function expand_biorhythm_form(div_id) {
    var div = document.getElementById(div_id);
    var status = div.style.display;
    if (status == "none") {
        div.style.display = "";
    } else {
        div.style.display = "none";
    }
}
<!-- Biorhythm javascript END -->